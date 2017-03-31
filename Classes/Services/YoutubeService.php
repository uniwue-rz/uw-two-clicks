<?php
/**
* Manages all the interaction with the youtube server
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Services;

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
    * @param string $recordData The id of the record the details needs
    *
    * @return array
    */
    public function getProviderInformation($recordData){
        $cacheKey = $this->getCacheHash($recordData);
        // Check if the item exists in the cache
        if($this->getCache() === true && $this->getCacheItem($cacheKey) !== false){

            return $this->getCacheItem($cacheKey);
        }
        $url = new Url($this->getApiUrl());
        $url->addParameter("key", $this->getApiToken());
        $url->addParameter("part", "snippet");
        $url->addParameter("id", $recordData);
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
    * @param string $recordId The id of the record the details needs
    * 
    * @return string
    */
    public function getPreviewImageUrl($recordId){
        $jsonDetails = $this->getProviderInformation($recordId);
        if(isset($jsonDetails["items"][0]["snippet"]["thumbnails"]["standard"]["url"])){

            return $jsonDetails["items"][0]["snippet"]["thumbnails"]["standard"]["url"];
        }

        return "";
    }

    /**
    * Downloads the given image and save it to the FAL of the given page 
    *
    * @param string    $url          The url of the given image
    * @param string    $fileName     The name of the file to be saved
    * @param int       $contentId    The id of content element that should be used.
    *
    * @return TYPO3\CMS\Core\Resource\File|Null
    */
    public function addPreviewImageAsFile($url, $fileName, $contentId){
        $name = $fileName.".jpeg";
        $url = new Url($url, $name);
        $fileMount = $this->fileHandler->getContentFileMount($contentId);
        $storeFolder = $this->fileHandler->getStoreFolder();
        $storage = $this->fileHandler->getStorage();
        
        return $this->fileHandler->addFile($url->fetch(), $fileMount, $storeFolder, $storage, $name);
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

        return $this->fileHandler->addFileReference($contentId, $fileObject);
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