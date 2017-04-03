<?php
/**
* A generic class that will be the parent of other services. It makes inserting, updating records
* much easier.
*
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
**/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Services;

use TYPO3\CMS\Core\Utility\GeneralUtility;

use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\FileHandler;
use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\BackendConfig;

class GenericService{

    /**
    * Placeholder for the service type
    */
    protected $serviceType;
    /**
    * Placeholder for the Url Handler Object
    */
    protected $urlHandler;
    /**
    * Placeholder for the FileHandler
    */
    protected $fileHandler;
    /**
    * Returns the backendConfig
    */
    protected $backendConfig;
    /**
    * Sets the Api url
    */
    protected $apiUrl;
    /**
    * Sets the Api Key
    */
    protected $apiToken;
    /*
    * The cache key
    */
    protected $cache;
    /**
    * The cache manager
    */
    protected $cacheManager;

    /**
    * Constructor
    *
    * @param string $serviceType Sets the service type for the given service
    * @param string $apiUrl      The api url for the given service
    * @param string $apiToken    The api token for the given service
    * @param string $cache       If the service should cache
    */
    public function  __construct($serviceType = '', $apiUrl = '', $apiToken = '', $cache = true){
        $this->setServiceType($serviceType);
        $this->fileHandler = new FileHandler();
        $this->backendConfig = new BackendConfig();
        $this->setApiUrl($apiUrl);
        $this->setApiToken($apiToken);
        $this->cache = $cache;
        $this->cacheManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('uw_two_clicks_cache');
    }

    /**
    * Sets the service type for the given Service
    *
    * @return string
    */
    public function getServiceType(){

        return $this->serviceType;
    }

    /**
    * Sets the Service type
    *
    * @param string $serviceType The service type tag
    */
    public function setServiceType($serviceType){
        $this->serviceType = $serviceType;
    }

    /**
    * Sets the ApiUrl
    *
    * @param string $apiUrl The api url for the given service
    */
    public function setApiUrl($apiUrl = ''){
        if($apiUrl === ""){
            $apiUrlKey = $this->getServiceType()."."."apiUrl";
            $apiUrl = $this->backendConfig->value($apiUrlKey);
        }
        if($apiUrl === Null || $apiUrl === ''){

            throw new \Exception("The ApiUrl should be set, go to extension setting and set $apiUrlKey");
        }
        $this->apiUrl = $apiUrl;
    }

    /**
    * Returns the Api Url
    *
    * @return string
    */
    public function getApiUrl(){
        
        return $this->apiUrl;
    }

    /**
    * Sets the Api token for the given service
    *
    * @param string $apiToken The api token for the given service
    */
    public function setApiToken($apiToken = ''){
        if($apiToken === ''){
            $apiTokenKey = $this->getServiceType()."."."apiToken";
            $apiToken = $this->backendConfig->value($apiTokenKey);
        }
        if($apiToken === Null || $apiToken === ''){

            throw new \Exception("The Api Token should be set, go to extension setting and set  $apiTokenKey");
        }
        $this->apiToken = $apiToken;
    }

    /**
    *  Returns the api token for the given service
    *
    * @return string
    */
    public function getApiToken(){

        return $this->apiToken;
    }

    /**
    * Returns the file handler for the given service
    *
    * @return FileHandler
    **/
    public function getFileHandler(){

        return $this->fileHandler;
    }

    /**
    * Sets the file handler for the given file
    *
    * @param FileHandler $fileHandler The instance of file handler that should be used.
    */
    public function setFileHandler($fileHandler){
        $this->fileHandler = $fileHandler;
    }

    /**
    * Returns the whole data the provider has about the given record data
    *
    * @param string $recordData The record data that should be used to get information for form provider
    *
    * @return array
    **/
    public function getProviderInformation($recordData){

        return array();
    }

    /**
    * Returns the url for the preview image.
    *
    * @param string $recordData The data that should be used to fetch the image url from the provider
    *
    * @return string
    */
    public function getPreviewImageUrl($recordData){

        return "";
    }

    /**
    * Returns the license for the given record data
    * 
    * @param string $recordData The record data
    *
    * @return string
    */
    public function getLicense($recordData){
        
        return "";
    }

    /**
    * Sets the switch to use cache for the given system
    *
    * @param bool $cache If the service should use cache
    */
    public function setCache($cache){
        $this->cache = $cache;
    }

    /**
    * Returns if the service is using cache
    *
    * @return bool
    */
    public function getCache(){

        return $this->cache;
    }

    /**
    * Returns the cache item for the given key. If not found returns False
    *
    * @return mix|False
    */
    public function getCacheItem($key){

        return $this->cacheManager->get($key);
    }

    /**
    * Sets the cache Item for the given time
    *
    * @param string $key    The key to the given item on the cache
    * @param mix    $value  The value that should be saved in the cache system
    * @param int    $time   The time the item should stay in cache in seconds
    */
    public function setCacheItem($key, $value, $time){
        $this->cacheManager->set($key, $value, array('none'), $time);
    }

    /**
    * Creates the hash cache for the given value. It is the value + "-" + serviceType
    *
    * @param string $value The value that should be hashed
    *
    * @return string
    */
    public function getCacheHash($value){

        return hash("md5", $value."-".$this->getServiceType());
    }

    /**
    * Returns the default set height in the given table
    *
    * @return string
    */
    public function getDefaultHeight(){
        $this->backendConfig->value($serviceType."."."height");
    }

    /**
    * Returns the default set width
    *
    * @return string
    */
    public function getDefaultWidth(){
        $this->backendConfig->value($serviceType."."."width");
    }
}