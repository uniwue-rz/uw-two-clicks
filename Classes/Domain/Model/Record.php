<?php
/**
* Records class is generic class for all the data managed by this extensions.
* 
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
**/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Domain\Model;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use TYPO3\CMS\Extbase\Service\FlexFormService;

use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Services\YoutubeService;
use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\BackendConfig;

class Record{

    /**
    * @var string
    */
    protected $recordId;

    /**
    * @var string
    */
    protected $service;

    /**
    * @var string
    */
    protected $embeddedText;

    /**
    * @var int
    */
    protected $width;

    /**
    * @var int
    */
    protected $height;

    /**
    * @var bool
    */
    protected $autoPlay;

    /**
    * @var int
    */
    protected $previewImageId;

    /**
    * @var string
    */
    protected $license;

    /**
    * @var int
    */
    protected $contentId;

    /**
    * @var int
    */
    protected $pid;

    /**
    * @var TYPO3\CMS\Extbase\Service\FlexFormService
    */
    protected $flexFormService;

    /**
    * Constructor
    *
    * @param string $recordId       The id of the given record ont the service
    * @param string $service        The service that should be used. (youtube, vimeo, ...)
    * @param string $embeddedText   The text that should be embedded
    * @param int    $width          The width of the element
    * @param int    $height         The height of the given element
    * @param bool   $autoPlay       The autoplay for the given record
    */
    public function __construct(
        $recordId = '',
        $service = '',
        $embeddedText = '',
        $width = 0,
        $height = 0,
        $autoPlay = false,
        $license = "",
        $recordType = '',
        $previewImageId = null,
        $contentId = null,
        $udi = null,
        $pid = null)
        {
            $this->setRecordId($recordId);
            $this->setService($service);
            $this->setEmbeddedText($embeddedText);
            $this->setWidth($width);
            $this->setHeight($height);
            $this->setAutoPlay($autoPlay);
            $this->setLicense($license);
            $this->setPreviewImageId($previewImageId);
            $this->setContentId($contentId);
            $this->setPid($pid);
            $this->setUid($uid);
            $this->flexFormService = new FlexFormService();
            $this->backendData = new BackendConfig();
            $this->youtubeService = new YoutubeService($this->backendData->value("youtube.apiUrl"), $this->backendData->value("youtube.apiToken"));    
            }


    /**
    * Adds the preview Image to the system
    *
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler   $dataHandler        DataHandler Object with can be used to retrieve data
    */
    public function addPreviewImage($dataHandler){
        $record = $this->getRecordData();
        $url = $this->youtubeService->getPreviewImageUrl($record["record_id"]);
        $file = $this->youtubeService->addPreviewImageAsFile($url, $record["record_id"], $record["content_id"]);
        $this->updateRecordToDatabase($record["uid"], array("preview_image_id" => $file->getUid()), $dataHandler);
    }

    /**
    * Sets the Uid of the given record from
    * record table
    *
    * @param int $uid The uid of the record
    */
    public function setUid($uid){
        $this->uid = $uid;
    }

    /**
    * Returns the uid of the given record
    *
    * @return int
    */
    public function getUid(){
        return $this->uid;
    }

    /**
    * Sets the license for the given record.
    *
    * @param string $license The license for the given record
    */
    public function setLicense($license){
        $this->license = $license;
    }

    /**
    * Returns the license for the given record
    *
    * @return string|Null
    */
    public function getLicense(){

        return $this->license;
    }


    /**
    * Returns the preview image for the given record
    *
    * @return int
    */
    public function getPreviewImageId(){

        return $this->previewImageId;
    }

    /**
    * Sets the id if the preview image
    *
    * @param int $previewImage The preview image that is used
    */
    public function setPreviewImageId($previewImage){
        $this->previewImageId = $previewImage;
    }

    /**
    * Returns the width of the given record
    *
    * @return int
    */
    public function getWidth(){
        return $this->width;
    }

    /**
    * Returns the content id for the given record
    *
    * @return int
    */
    public function getContentId(){

        return $this->contentId;
    }

    /**
    * Sets the content id for the given record
    *
    * @param int $contentId The id of the given content
    */
    public function setContentId($contentId){
        $this->contentId = $contentId;
    }

    /**
    * Returns the pid for the given record
    *
    * @return int
    **/
    public function getPid(){
        
        return $this->pid;
    }

    /**
    * Sets the pid in the given record
    *
    * @param int $pid The page id of given content having this record.
    **/
    public function setPid($pid){
        $this->pid = $pid;
    }

    /**
    * Sets the width for the given record.
    *
    * @param int $width The width for the given element
    */
    public function setWidth($width){
        $this->width = $width;
    }

    /**
    * Returns the height of the given record
    *
    * @return int
    */
    public function getHeight(){
        return $this->height;
    }

    /**
    * Sets the height of the given record.
    *
    * @param int $height The height of the record to set
    */
    public function setHeight($height){
        $this->height = $height;
    }

    /**
    * Returns the auto play status of the record
    *
    * @return bool
    */
    public function getAutoPlay(){
        return $this->autoPlay;
    }

    /**
    * Set the auto play status of the given record
    *
    * @param bool $autoPlay The autoplay of the record that should be set.
    */
    public function setAutoPlay($autoPlay){
        $this->autoPlay = $autoPlay;
    }

    /**
    * Returns the record Id
    *
    * @return string
    */
    public function getRecordId(){
        return $this->recordId;
    }

    /**
    * Sets the record id
    *
    * @param string $recordId The record id that should be set.
    */
    public function setRecordId($recordId){
        $this->recordId = (string) $recordId;
    }

    /**
    * Returns the service id
    *
    * @return string
    */
    public function getService(){
        return $this->service;
    }

    /**
    * Sets the service for the given record
    *
    * @param string $service The service that should be set.
    */
    public function setService($service){
        $this->service = (string) $service;
    }

    /**
    * Returns the embedded text used
    *
    * @return string
    */
    public function getEmbeddedText(){
        return $this->embeddedText;
    }

    /**
    * Sets the embedded text for the given record
    *
    * @param string $embeddedText The embedded text to be set.
    **/
    public function setEmbeddedText($embeddedText){
        $this->embeddedText = (string) $embeddedText;
    }

    /**
    * Updates the record from the flexform
    *
    * @param array $record              The record data in the database
    * @param array $flexFormData        The flexform data that is updated
    *
    * @return array
    */
    public function updateRecordFromFlexForm($record, $flexFormData){
        if(sizeof($flexFormData)>0){
        foreach($flexFormData["settings"] as $k => $v){
            if(isset($record[$k]) === false || $record[$k] !== $v){
                $record[$k] = $v;
            }
        }

            return $record;
        }

        return array();
    }

    /**
    * Updates the given record 
    *
    * @param array                                    $updateArray        The updated data in an array
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler        DataHandler Object with can be used to retrieve data
    *
    * @return int
    */
    public function updateRecordFlexForm($updateArray, $dataHandler){
        if($this->existsRecord()){
            $updatedRecordData = $this->updateRecordFromFlexForm(
                        $this->getRecordData(), 
                        $this->convertFlexFormToArray($updateArray["pi_flexform"])
            );
            $updatedRecordData["tstmap"] = $this->getRecordData()["tstmap"];

            $this->updateRecordToDatabase($this->getRecordData()["uid"], $updatedRecordData, $dataHandler);
            //$this->addFlexFormDataToContent($this->getContent(), "two_click_record", $this->getRecordData()["uid"], $dataHandler);

            return $this->getRecordData()["uid"];
        }

        return 0;
    }

    /** 
    * Adds data to flexForm
    *
    * @param array                                    $content          The content array from database
    * @param string                                   $key              The key in the flexform data
    * @param string                                   $value            The value that should be added to the key in flexFrom
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler      DataHandler Object with can be used to retrieve data
    **/
    public function addFlexFormDataToContent($content, $key, $value, $dataHandler){
        $flexForm = $content["pi_flexform"];
        if($flexForm !== Null){ 
            $flexFormData =  GeneralUtility::xml2array($flexForm);
            $flexFormData['data']['sDEF']['lDEF']["settings.".$key]['vDEF'] = $value;
            $flexFormTools = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Configuration\\FlexForm\\FlexFormTools');
            $content["pi_flexform"] = $flexFormTools->flexArray2Xml($flexFormData, true);
            $this->updateContent($content, $dataHandler);
        }
    }

    /**
    * Update the content with the given content array
    *
    * @return 
    **/
    public function updateContent($content, $dataHandler){
        $data["tt_content"][$content["uid"]] = $content;
        $this->processTCAData($data, $dataHandler);
    }

    /**
    * Adds the given record to the record table, returns 0 when
    * The record can not be added.
    *
    * @param array                                    $fieldArray        The updated data in an array
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler        DataHandler Object with can be used to retrieve data
    *
    * @return int
    **/
    public function addRecord($fieldArray, $dataHandler){
        if($this->ExistsRecord() === false){
            $recordData = $this->updateRecordFromFlexForm(
                array(), 
                $this->convertFlexFormToArray($fieldArray["pi_flexform"])
            );
            $recordData["content_id"] = $this->getContent()["uid"];
            $recordData["pid"] = $this->getContent()["pid"];
            $id = $this->addRecordToDatabase($recordData, $dataHandler);
            $this->addFlexFormDataToContent($this->getContent(), "two_click_record", strval($id), $dataHandler);

            return $id;
        }

        return 0;
    }

    /**
    * Adds the record data to database.
    *
    * @param array $recordData The recordData that should be added to database
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler        DataHandler Object with can be used to retrieve data
    *
    * @return int
    */
    public function addRecordToDatabase($recordData, $dataHandler){
        $id = StringUtility::getUniqueId('NEW');
        $data["tx_uw_two_clicks_records"][$id] = $recordData;
        $this->processTCAData($data, $dataHandler);

        return $dataHandler->substNEWwithIDs[$id];;
    }

    /**
    * Updates the given record in the database
    *
    * @param int        $id                                               The id of the given record in database
    * @param array      $recordData                                       The record data
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler        DataHandler Object with can be used to retrieve data
    */
    public function updateRecordToDatabase($id, $recordData, $dataHandler){
        $data["tx_uw_two_clicks_records"][$id] = $recordData;
        $this->processTCAData($data, $dataHandler);
    }

    /**
    * Processes the TCA data
    *
    * @param array                                    $tcaData The TCA data that should be processed
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler        DataHandler Object with can be used to retrieve data
    */
    public function processTCAData($tcaData, $dataHandler){
            $dataHandler->stripslashes_values = 0;
            $dataHandler->start($tcaData, array());
            $dataHandler->process_datamap();
    }

    /**
    * Checks if the given record exists in the system
    *
    * @return bool
    */
    public function ExistsRecord(){
        if(sizeof($this->getRecordData()) === 0 || $this->getRecordData() === false){

            return false;
        }

        return true;
    }

    /**
    * Convert the flexform to array
    *
    * @param string $flexForm The flexform text from database
    *
    * @return array 
    */
    public function convertFlexFormToArray($flexForm){
        
        return $this->flexFormService->convertFlexFormContentToArray($flexForm);
    }

    /**
    * Adds or updates the record
    * @param array                                    $updateArray        The updated data in an array
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler        DataHandler Object with can be used to retrieve data
    */
    public function addOrUpdateRecord($fieldArray, $dataHandler){
        $id = $this->addRecord($fieldArray, $dataHandler);
        if($id === 0){
            $id = $this->updateRecordFlexForm($fieldArray, $dataHandler);
        }

        $this->setUid($uid);
    }
    
    /**
    * Returns the record data saved in the database.
    *
    * @return array
    */
    public function getRecordData(){
        return BackendUtility::getRecordRaw('tx_uw_two_clicks_records', "content_id = ".$this->getContentId());
    }
    
    /**
    * Returns the data that is saved in the tt_content table for the given record
    *
    * @return array
    */
    public function getContent(){

        return BackendUtility::getRecord('tt_content', $this->contentId);
    }
}