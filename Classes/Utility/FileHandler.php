<?php
/**
* All the file operation of this plugin is handled with the help
* of this class.
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de> 
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility;

use TYPO3\CMS\Backend\Utility\BackendUtility;

use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\File;

class FileHandler{
    /**
    * Placeholder for DataHandler
    *
    * @var TYPO3\CMS\Core\DataHandling\DataHandler
    */
    protected $dataHandler;

    /**
    * Placeholder for the ResourceFactory
    *
    * @var TYPO3\CMS\Core\Resource\ResourceFactory
    */
    protected $resourceFactory;

    /**
    * Placeholder for the BackendConfig
    *
    * @var De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\BackendConfig
    */
    protected $backendConfig;

    /**
    * Creates the FileHandler instance
    */
    public function __construct(){
        $this->dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $this->resourceFactory = ResourceFactory::getInstance();
        $this->backendConfig = new BackendConfig();
        $this->setStorage($this->findStorage());
    }

    /**
    * Creates a path for the given file and folder
    *
    * @param string $folderPath The path for the folder
    * @param string $filePath   The name of the given file
    *
    * @return string
    */
    public function createFilePath($folderPath, $filePath){

        return $folderPath."/".$filePath;
    }

    /**
    * Get the file mount from backend group
    *
    * @param int $uid The content uid of the content element
    */
    public function getFileMountFromBackendGroup($uid){
        $page = $this->getPageFromContentUid($uid);
        $group = $this->getBackendGroupFromPage($page);
        $fileMountId = $this->getBackendGroupFileMount($group);
        if($fileMountId !== null){
            return $this->getFileMount($fileMountId)["path"];
        }

        return null;
    }

    /**
    * Sets the storage for the given fileHandler
    *
    * @param TYPO3\CMS\Core\Resource\ResourceStorage $storage The storage insatnce
    */
    public function setStorage($storage){
        $this->storage = $storage;
    }

    /**
    * Returns the file mount path for the given content
    *
    * @param int $uid The uid of the given content.
    *
    * @return string
    */
    public function getContentFileMount($uid){
        $mountPoint = null;
        // check if the file.mountPointType is group
        if($this->backendConfig->value("files.mountPointType") === "group"){
            $mountPoint = $this->getFileMountFromBackendGroup($uid);
        }
        // check if the file.mountPoint is simple
        if($this->backendConfig->value("files.mountPointType") === "simple"){
            $mountPoint = $this->getConfiguredMountPoint();
        }
        // if it is still null return the last resort
        if($mountPoint === null){
            $mountPoint = $this->getDefaultMountPoint();
        }

        return $mountPoint;
    }

    /**
    * Returns the content element form the given uid
    *
    * @param int $uid The id of the wanted content element
    *
    * @return array
    */
    public function getContent($uid){

        return BackendUtility::getRecord("tt_content", $uid);
    }

    /**
    * Returns the page Record from the given content uid
    * 
    * @param int $uid The id of the given content
    *
    * @return array
    */
    public function getPageFromContentUid($uid){
        $content = $this->getContent($uid);

        return $this->getPage($content["pid"]);
    }


    /**
    * Returns the storage for the given file handler.
    *
    * @return TYPO3\CMS\Core\Resource\ResourceStorage
    */
    public function getStorage(){
        
        return $this->storage;
    }

    /**
    * Returns the page record for the given page.
    *
    * @param int $pid The page id
    *
    * @return array
    */
    public function getPage($pid){

       return BackendUtility::getRecord('pages', $pid);
    }

    /**
    * Returns the given page backend group
    *
    * @param array $page The page array
    *
    * @return array
    */
    public function getBackendGroupFromPage($page){
        $permId = $page["perms_groupid"];

        return $this->getBackendGroupByPermId($permId);
    }

    /**
    * Returns the backend group from the page perm_id
    *
    * @param int $permId The perms_groupid of the given page
    *
    * @return array
    */
    public function getBackendGroupByPermId($permId){

        return BackendUtility::getRecord('be_groups', $permId, '*');
    }

    /**
    * Returns the group file mount or null
    *
    * @param array $backendGroup The backend group array from database
    *
    * @return int|null
    */
    public function getBackendGroupFileMount($backendGroup){
        $fileMounts = $backendGroup["file_mountpoints"];

        return $this->extractSysFileMounts($fileMounts);
    }

    /**
    * Handles the sys_file_mounts of the given group
    *
    * @param string $fileMounts The sys_file_mounts record
    *
    * @return int|null
    */
    public function extractSysFileMounts($fileMounts){
        $fileMountsArray = explode(",", $fileMounts);
        if(sizeof($fileMountsArray) > 0){

            return intval($fileMountsArray[0]);
        }

        return null;
    }

    /**
    * Returns the file mount string for the given group.
    *
    * @param int $fileMountId The id of the file mount
    *
    * @return array
    */
    public function getFileMount($fileMountId){

        return BackendUtility::getRecord('sys_filemounts', $fileMountId, '*');
    }

    /**
    * Returns the storage if not found the fallback one
    *
    * @return TYPO3\CMS\Core\Resource\ResourceStorage | Null
    */
    public function findStorage(){
        if($storage === null && ($id === Null  || $id === "")){

            $storage =  $this->getFallbackStorage();
        }
        else{
            $id = $this->getConfiguredStorage();    
            $storage = $this->getStorageObject($id);
        }

        return $storage;
    }

    /**
    * Returns the default storage
    *
    * @param int $id The id of the storage usually is 1.
    *
    * @return TYPO3\CMS\Core\Resource\ResourceStorage
    **/
    public function getStorageObject($id = 1){

        return $this->resourceFactory->getStorageObject($id);
    }

    /**
    * Adds the file from the tmp folder to the given fileadmin and storeFolder, creates the folders on the fly
    *
    * @param string                                  $fileRealPath      The path to the file in tmp folder
    * @param string                                  $fileAdminPath     The fileadmin path for the given page
    * @param string                                  $storeFolder       The store folder
    * @param TYPO3\CMS\Core\Resource\ResourceStorage $storage           The storage object
    * @param string                                  $fileName          The fileName that should be set for the given user
    *
    * @return TYPO3\CMS\Core\Resource\File | Null
    */
    public function addFile($fileRealPath, $fileAdminPath,  $storeFolder, $fileName){
        $endStoreFolder = $this->createFilePath($fileAdminPath, $storeFolder);
        // Create the fileadmin path if not exists
        if($this->folderExists($fileAdminPath) === false){
            $this->createFolder("/", $fileAdminPath);
        }
        // Create the store path if not exists
        if($this->folderExists($endStoreFolder) === false){
            $this->createFolder($fileAdminPath, $storeFolder);
        }
        $fileAdminPathObject = $this->getFolder($endStoreFolder);
        // Add the file when not exists
        $filePath = $this->createFilePath($endStoreFolder, $fileName);
        if($this->fileExists($filePath) === false){
                
                return $this->storage->addFile($fileRealPath, $fileAdminPathObject, $fileName);
        }

        return Null;
        
    }

    /**
    * Returns the given file from storage by the fileadmin path or the id of the given file
    *
    * @param string  $filePath The path to the given file
    *
    * @return TYPO3\CMS\Core\Resource\File
    */
    public function getFile($filePath){

        return $this->resourceFactory->retrieveFileOrFolderObject($filePath);
    }

    /**
    * Adds the file reference for the given file to the content element
    *
    * @param int                          $contentId        The uid of the content element
    * @param TYPO3\CMS\Core\Resource\File $fileObject       The file object that should be used.
    *
    * @return bool
    */
    public function addFileReference($contentId, File $fileObject){
        $contentElement = BackendUtility::getRecord('tt_content',(int)$contentId);
        $newId = StringUtility::getUniqueId('NEW');
        $data = array();
        $data['sys_file_reference'][$newId] = array(
            'table_local' => 'sys_file',
            'uid_local' => $fileObject->getUid(),
            'tablenames' => 'tt_content',
            'uid_foreign' => $contentElement['uid'],
            'fieldname' => 'image',
            'pid' => $contentElement['pid']
        );
        $data['tt_content'][$contentElement['uid']] = array(
            'image' => $newId
        );
        $this->dataHandler->start($data, array());
        $this->dataHandler->process_datamap();
        if (count($this->dataHandler->errorLog) === 0) {

            return true;
        } else {

            return false;
        }
    }

    /**
    * Returns the fallback mount point to save the images
    *
    * @return string | Null
    */
    public function getConfiguredMountPoint(){

        return $this->backendConfig->value("files.defaultMountPoint");
    }

    /**
    * Returns the value of the configured storage
    *
    * @return string
    **/
    public function getConfiguredStorage(){

        return $this->backendConfig->value("files.storageId");
    }

    /**
    * Returns the default mount point, it is the last 
    * resort.
    *
    * @return string
    */
    public function getDefaultMountPoint(){

        return "/TwoClicks";
    }

    /**
    * Returns the storeFolder, where the images are saved on the given mount point
    *
    * @return string
    */
    public function getStoreFolder(){
        if($this->backendConfig->value("files.storeFolder") === null || $this->backendConfig->value("files.storeFolder") === ""){
            
            return "TwoClicksImage";
        }
        return $this->backendConfig->value("files.storeFolder");
    }

    /**
    * Returns the fallback storage to save the files
    *
    * @return TYPO3\CMS\Core\Resource\ResourceStorage
    */
    public function getFallbackStorage(){

        return $this->resourceFactory->getDefaultStorage();
    }

    /**
    * Creates a folder on the given storage and mount point.
    *
    * @param string  $mountPoint        The mount point for the folder
    * @param string  $folder            The name of the folder that should be created
    *
    * @return Folder
    */
    public function createFolder($mountPoint, $folder){
        $mountPointFolder = $this->getFolder($mountPoint);
        
        return $this->storage->createFolder($folder, $mountPointFolder);
    }

    /**
    * Returns the folder object for the given path.
    *
    * @return Folder
    **/
    public function getFolder($path){

        return $this->storage->getFolder($path);
    }

    /**
    * Search if the given file exists on the given storage
    *
    * @param string $path The filename that should be checked for existence
    *
    * @return bool
    */
    public function fileExists($path){

        return $this->storage->hasFile($path);
    }

    /**
    * Checks if the given folder exists on the storage
    *
    * @param string  $path  The folder that should exists
    *
    * @return bool
    */
    public function folderExists($path){
        
        return $this->storage->hasFolder($path);
    }

    /**
    * Deletes the file from the file system and database
    *
    * @param int  $id  The id of the given file to be deleted
    *
    * @return bool
    */
    public function deleteFile($id){
        $file = $this->getFile($id);
        
        return $this->storage->deleteFile($file);
    }

}