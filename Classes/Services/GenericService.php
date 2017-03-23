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

use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\BackendConfig;

class GenericService{

    /**
    * Placeholder for the api Url
    **/
    private $apiUrl;

    /**
    * Placeholder for the api token
    */
    private $apiToken;

    /**
    * Placeholder for the service type
    */
    private $serviceType;

    /**
    * Placeholder for the backend config
    */
    private $backendConfig;

    /**
    * Constructor
    *
    * @param string $apiUrl      The api url for the given service
    * @param string $apiToken    Sets the api token for the given service
    * @param string $serviceType Sets the service type for the given service
    */
    public function  __construct($apiUrl, $apiToken, $serviceType = ''){
        $this->setServiceType($serviceType);
        $this->setApiToken($apiToken);
        $this->setApiUrl($apiUrl);
    }

    /**
    * Sets the api url for the given service
    *
    * @param string $apiUrl The api url to be set.
    */
    public function setApiUrl($apiUrl){
        $this->apiUrl = $apiUrl;
    }

    /**
    * Returns the api url for the given service
    *
    * @return string
    **/
    public function getApiUrl(){

        return $this->apiUrl;
    }

    /**
    * Sets the Api token for the given service
    *
    * @param string $apiToken The api token for the query
    */
    public function setApiToken($apiToken){
        $this->apiToken = $apiToken;
    }

    /**
    * Returns the api token for the given service
    *
    * @return string
    */
    public function getApiToken(){

        return $this->apiToken;
    }

    /**
    * Sets the service type for the give service
    *
    * @param string $serviceType The service type for the give service
    */
    public function setServiceType($serviceType){
        $this->serviceType = $serviceType;
    }

    /**
    * Adds the given record to tx_uw_two_clicks_records
    *
    **/
    public function addRecord($record){

    }

    /**
    * Updates the given record in tx_uw_two_clicks_records
    *
    *
    */
    public function updateRecord($record){

    }

    /**
    * Returns the the url image for the given service
    *
    */
    public function getPreviewImageUrl($recordId){

    }

    /**
    * Downloads the preview image from the given service
    *
    **/
    public function getPreviewImageFile(){

    }

    /**
    * Creates the html text to be embedded on the page
    *
    */
    public function createEmbeddedText(){

    }

    /**
    * Adds the preview image to the given content
    *
    */
    public function addPreviewImageToContent(){

    }

}