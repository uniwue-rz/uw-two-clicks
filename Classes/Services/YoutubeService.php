<?php
/**
* Manages all the interaction with the youtube server
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Services;

use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\Url;
use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\FileHandler;

class YoutubeService extends GenericService{
    /**
    * Constructor 
    *
    * @param string $apiUrl The api url for youtube
    * @param string $apiToken The api Token for the youtube
    */
    public function __construct($apiUrl = null, $apiToken = null){
    
        parent::__construct($apiUrl, $apiToken, "yt");
    }

    /**
    * Returns the record detail for the given record
    *
    * @param string $recordId The id of the record the details needs
    *
    * @return string
    */
    public function getRecordDetails($recordId){
        $url = new Url($this->getApiUrl());
        $url->addParameter("key", $this->getApiToken());
        $url->addParameter("part", "snippet");
        $url->addParameter("id", $recordId);
        
        return $url->fetch("GET", array(), true);
    }

    /**
    * Returns the preview image for the given record
    *
    * @param string $recordId The id of the record the details needs
    * 
    * @return string
    */
    public function getPreviewImageUrl($recordId){
        $jsonDetails = json_decode($this->getRecordDetails($recordId), true);
        if(isset($jsonDetails["items"][0]["snippet"]["thumbnails"]["standard"]["url"])){

            return $jsonDetails["items"][0]["snippet"]["thumbnails"]["standard"]["url"];
        }

        return "";
    }

    /**
    * Downloads the given image and save it to the FAL of the given page 
    *
    * @param string $url        The url of the given image
    * @param int    $contentId  The id of the given element
    *
    * @return TYPO3\CMS\Core\Resource\File|Null
    */
    public function addPreviewImageAsFile($url, $recordId, $contentId){
        $fileHandler = new FileHandler();
        $name = $recordId.".jpeg";
        $url = new Url($url, $name);
        $fileMount = $fileHandler->getContentFileMount($contentId);
        $storeFolder = $fileHandler->getStoreFolder();
        $storage = $fileHandler->getStorage();
        
        return $fileHandler->addFile($url->fetch(), $fileMount, $storeFolder, $storage, $name);
    }

    /**
    * Adds the given file to the given content.
    *
    * @param int $contentId The content id
    * @param TYPO3\CMS\Core\Resource\File $fileObject The file object that should be used.
    *
    * @return bool
    */
    public function addPreviewImageToContent($contentId, $fileObject){
        $fileHandler = new FileHandler();

        return $fileHandler->addFileReference($contentId, $fileObject);
    }

    /**
    * Checks if the preview image exists
    *
    * @param string $recordId The id of the record that the preview image should be searched for.
    *
    * @return bool
    */
    public function previewImageExists($recordId){

    }

    /**
    * Updates the preview image to a new image.
    *
    * @param string $recordId The id of the new preview image.
    *
    * @return bool
    **/
    public function updatePreviewImage($recordId){

    }
}