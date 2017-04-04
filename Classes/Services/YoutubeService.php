<?php
/**
* Manages all the interaction with the youtube server
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Services;

use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Domain\Model\Record;
use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\Url;

class YoutubeService extends GenericService{
    /**
    * Constructor 
    *
    * @param string $apiUrl The api url for youtube
    * @param string $apiToken The api Token for the youtube
    */
    public function __construct($apiUrl = '', $apiToken = ''){
        parent::__construct("yt", $apiUrl, $apiToken);
    }

    /**
    * Returns the record detail for the given record
    *
    * @param Record $record The record object instance that the preview image should be built from.
    *
    * @return array
    */
    public function getProviderInformation(Record $record){
        $cacheKey = $this->getCacheHash($record->getRecordId());
        // Check if the item exists in the cache
        if($this->getCache() === true && $this->getCacheItem($cacheKey) !== false){

            return $this->getCacheItem($cacheKey);
        }
        $url = new Url($this->getApiUrl());
        $url->addParameter("key", $this->getApiToken());
        $url->addParameter("part", "snippet, status");
        $url->addParameter("id", $record->getRecordId());
        $value = json_decode($url->fetch("GET", array(), true), true);
        // Check the result of query
        if($value === null){
            throw new \Exception("Error decoding the provider information: ". json_last_error());
        }
        if(isset($value["error"]) === true){
            throw new \Exception("There was an error getting information from provider");
        }
        if($this->getCache() === true){
            $this->setCacheItem($cacheKey, $value, 60);
        }

        return $value;
    }

    /**
    * Returns the preview image for the given record
    *
    * @param Record $record The record object instance that the preview image should be built from.
    * 
    * @return string
    */
    public function getPreviewImageUrl(Record $record){
        $jsonDetails = $this->getProviderInformation($record);
        if(isset($jsonDetails["items"][0]["snippet"]["thumbnails"]["standard"]["url"])){

            return $jsonDetails["items"][0]["snippet"]["thumbnails"]["standard"]["url"];
        }

        return "";
    }

    /**
    * Creates the name of the preview image
    *
    * @param Record $record The record object instance that the preview image should be built from.
    *
    * @return string
    */
    public function createPreviewFileName(Record $record){

        return $record->getRecordId()."-".$record->getContentId().".jpeg";
    }

    /**
    * Create preview file path for the given record and contentId based
    * on the users setting
    *
    * @param Record $record The record object instance that the preview image should be built from.
    *
    * @return string
    */
    public function createPreviewFilePath(Record $record){
        $fileName = $this->createPreviewFileName($record);
        $path = $this->fileHandler->getContentFileMount($record->getContentId());
        $path = $this->fileHandler->createFilePath($path, $this->fileHandler->getStoreFolder());
        
        return $this->fileHandler->createFilePath($path, $fileName);
    }

    /**
    * Checks if the image exists
    *
    * @param Record $record The record object instance that the preview image should be built from.
    *
    * @return bool
    */
    public function previewImageExists(Record $record){
        $path = $this->createPreviewFilePath($record);

        return $this->fileHandler->fileExists($path);
    }

    /**
    * Downloads the given image and save it to the FAL of the given page 
    *
    * @param string    $url          The url of the given image
    * @param Record    $record       The record object instance that the preview image should be built from.
    * @param string    $recordId     The old recordId, which is used by updates
    *
    * @return TYPO3\CMS\Core\Resource\File | Null
    */
    public function addOrUpdatePreviewImage($url, Record $record){
        // Check if the file exists before, if yes return the existing file.
        $fileName = $this->createPreviewFileName($record);
        if($this->previewImageExists($record)){
            $path = $this->createPreviewFilePath($record);
            
            return $this->fileHandler->getFile($path);
        }
        // File not exists download
        $url = new Url($url, $fileName);
        $fileMount = $this->fileHandler->getContentFileMount($record->getContentId());
        $storeFolder = $this->fileHandler->getStoreFolder();
        
        return $this->fileHandler->addFile($url->fetch(), $fileMount, $storeFolder, $fileName);
    }

    /**
    * Adds the given file to the given content.
    *
    * @param int                          $contentId  The content id
    * @param TYPO3\CMS\Core\Resource\File $fileObject The file object that should be used.
    *
    * @return bool
    */
    public function addPreviewImageToContent($contentId, $fileObject){

        return $this->fileHandler->addFileReference($contentId, $fileObject);
    }

    /**
    * Removes the preview image from the system if exists
    */
    public function removePreviewImage(Record $record){
        $path = $this->createPreviewFilePath($record);
        $this->fileHandler->deleteFile($record->getPreviewImageId());
    }

    /**
    * Creates the copy right tag for the given video 
    * This is added underneath the given image
    *
    * @return string
    */ 
    public function getLicense(Record $record){
        $license = "";
        $videoInformation = $this->getProviderInformation($record);
        if(isset($videoInformation["items"][0]["status"]["license"])){
            $license = "(C) " . $videoInformation["items"][0]["status"]["license"]. " License";
        }
        if(isset($videoInformation["items"][0]["snippet"]["channelTitle"])){
            $license  = $license ." ". $videoInformation["items"][0]["snippet"]["channelTitle"];
        }

        return $license;
    }

    /**
    * Returns the Alt text
    *
    * @return string
    */
    public function getAltText(Record $record){
        $altText = "";
        $videoInformation = $this->getProviderInformation($record);
         if(isset($videoInformation["items"][0]["snippet"]["title"])){
            $altText = $videoInformation["items"][0]["snippet"]["title"];
        }

        return $altText;       
    }
}