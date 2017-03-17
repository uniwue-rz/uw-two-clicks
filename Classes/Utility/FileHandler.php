<?php
/**
* Manages the whole file admin setting for the given file
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de> 
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility;

use \TYPO3\CMS\Backend\Utility\BackendUtility;

class FileHandler{

    /**
    * Returns the file mount of the given content as string
    * This can be used to add the preview image in the right
    * folder
    *
    * @param int $uid The uid of the given content.
    *
    * @return string
    */
    public function getContentFileMount($uid){
        $page = $this->getContentPage($uid);
        $group = $this->getBackendGroup($page["perms_groupid"]);
        $fileMountId = $this->extractSysFileMounts($group["file_mountpoints"]);

        return $this->getFileMount($fileMountId)["path"];
    }

    /**
    * Returns the page of the given content
    *
    * @param int $uid The id of the given content
    *
    * @return array
    */
    public function getContentPage($uid){
        $content = BackendUtility::getRecord('tt_content', $uid, 'pid');

        return $this->getPage($content["pid"]);
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
    * Returns the backend group from the page perm_id
    *
    * @param int $permId The perms_groupid of the given page
    *
    * @return array
    */
    public function getBackendGroup($permId){

        return BackendUtility::getRecord('be_groups', $permId, '*');
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
    * @return string
    */
    public function getFileMount($fileMountId){
        return BackendUtility::getRecord('sys_filemounts', $fileMountId, 'path');
    }

}