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

use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Services\ServiceDispatcher;

class Record{

    /**
    * @var string
    */
    protected $recordId;

    /**
    * @var string
    */
    protected $recordType;

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
        $pid = null,
        $url = "")
        {
            $this->setRecordId($recordId);
            $this->setRecordType($recordType);
            $this->setEmbeddedText($embeddedText);
            $this->setWidth($width);
            $this->setHeight($height);
            $this->setAutoPlay($autoPlay);
            $this->setLicense($license);
            $this->setPreviewImageId($previewImageId);
            $this->setContentId($contentId);
            $this->setPid($pid);
            $this->setUid($uid);
            $this->setUrl($url);
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
    * Returns the url for the given service on the provider
    *
    * @return string
    */
    public function getUrl(){

        return $this->url;
    }

    /**
    * Sets the url for the given record
    *
    * @param string $url The url for the given service record on the provider
    */
    public function setUrl($url){
        $this->url = $url;
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
        if($pid === "" || $pid === Null){

            return;
        }
        $this->pid = $pid;
    }

    /**
    * Sets the width for the given record.
    *
    * @param int $width The width for the given element
    */
    public function setWidth($width, $defaultWidth=500){
        if($width === Null || $width === ""){
            $this->width=$defaultWidth;
        }
        else{
            $this->width = $width;
        }
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
    public function setHeight($height, $defaultHeight=250){
        if($height === Null || $height === ""){
            $this->height = $defaultHeight;
        }else{
            $this->height = $height;
        }
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
        if(is_bool($autoPlay)){
            $this->autoPlay = $autoPlay;
        }
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
    * Returns the record type
    *
    * @return string
    */
    public function getRecordType(){
        return $this->recordType;
    }

    /**
    * Sets the record type for the given record
    *
    * @param string $recordType The record Type that should be set.
    */
    public function setRecordType($recordType){
        $this->recordType = (string) $recordType;
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
        $flexFormService = new FlexFormService();
        return $flexFormService->convertFlexFormContentToArray($flexForm);
    }
    
    /**
    * Returns the record data saved in the database.
    *
    * @return array
    */
    public function getRecordDataByContentId(){
        return BackendUtility::getRecordRaw('tx_uw_two_clicks_records', "content_id = ".$this->getContentId());
    }

    /**
    * Returns the record by the given uid
    *
    * @return array
    */
    public function getRecordDataByUid(){

        return BackendUtility::getRecord('tx_uw_two_clicks_records', $this->getUid());
    }
    
    /**
    * Returns the data that is saved in the tt_content table for the given record
    *
    * @return array
    */
    public function getContent(){

        return BackendUtility::getRecord('tt_content', $this->contentId);
    }

    /**
    * Synchronizes the record with database, it does not update,
    * only fetches the data from the server.
    *
    *
    * @param bool $useContentUid If the sync with record should use the content uid to get the record element
    **/
    public function syncWithRecords($useContentUid = false){
        if($useContentUid === true){
            $record = $this->getRecordDataByContentId();
            $this->setUid($record["uid"]);
        }
        else{
            $record = $this->getRecordDataByUid();
            $this->setContentId($record["content_id"]);
        }
        $this->setPid($record["pid"]);
        $this->setAutoPlay($record["auto_play"]);
        $this->setEmbeddedText($record["embedded_text"]);
        $this->setLicense($record["license"]);
        $this->setRecordType($record["record_type"]);
        $this->setPreviewImageId($record["preview_image_id"]);
        $this->setRecordId($record["record_id"]);
        $this->setHeight($record["height"]);
        $this->setWidth($record["width"]);
    }

    /**
    * Sync the Record with the available flexform data.
    */
    public function syncWithFlexForm(){
        $content = $this->getContent();
        $this->fillWithFlexForm($this->getContent()["pi_flexform"]);
    }

    /**
    * Fills the record with the flexform data
    * 
    * @param string $flexForm The flexForm string data.
    */
    public function fillWithFlexForm($flexForm){
        $flexFormData = $this->convertFlexFormToArray($flexForm);
        $record = $this->updateRecordFromFlexForm(array(), $flexFormData);
        $this->setAutoPlay($record["auto_play"]);
        $this->setEmbeddedText($record["embedded_text"]);
        $this->setRecordId($record["record_id"]);
        $this->setRecordType($record["record_type"]);
        $this->setHeight($record["height"]);
        $this->setWidth($record["width"]);
        if(isset($record["two_click_record"]) && $record["two_click_record"]!== ''){
            $this->setUid($record["two_click_record"]);
        }
    }

    /**
    * Commit the data to the record table
    *
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler  DataHandler Object with can be used to retrieve data
    */
    public function commitToRecordsTable($dataHandler){
        if($this->getUid() === Null){
            $id = StringUtility::getUniqueId('NEW');
        }
        else{
            $id = $this->getUid();
        }
        $data["tx_uw_two_clicks_records"][$id] = $this->getRecordAsDataArray();
        $this->processTCAData($data, $dataHandler);

        if($this->getUid() === Null){

            return $dataHandler->substNEWwithIDs[$id];
        }

        return $id;       
    }

    /**
    * Returns the record as database associative array
    *
    * @return array
    */
    public function getRecordAsDataArray(){
        return array(
            "pid" =>  $this->getPid(),
            "auto_play" => $this->getAutoPlay(),
            "width" => $this->getWidth(),
            "height" => $this->getHeight(),
            "url" => $this->getUrl(),
            "license" => $this->getLicense(),
            "content_id" => $this->getContentId(),
            "preview_image_id" => $this->getPreviewImageId(),
            "record_id" => $this->getRecordId(),
            "record_type" => $this->getRecordType());
    }

    /**
    * Commit the data to the flex form table
    *
    */
    public function commitToFlexForm($dataHandler){
        $this->addFlexFormDataToContent($this->getContent(), "two_click_record", $this->getUid(), $dataHandler);
    }

    /**
    * Returns the difference of the record with the other one as an array
    *
    * @param Record $record Another instance of record object
    * 
    * @return array
    */
    public function diff($record){
        return array_diff_assoc(get_object_vars($this), get_object_vars($record));
    }

    /**
    * Updates the given record with the given data
    *
    * @param array $data The data array
    */
    public function updateRecordWithArray($data){
        if(isset($data["recordType"])){
            $this->recordType = $data["recordType"];
            unset($data["recordType"]);
        }
        $sd = new ServiceDispatcher($this);
        $service = $sd->getService();
        if(isset($data["recordId"]) && $data["recordId"] !== ""){
            if($this->getRecordId() !== ''){
                $service->removePreviewImage($this);
            }
            $this->setRecordId($data["recordId"]);
            $file = $service->addOrUpdatePreviewImage($service->getPreviewImageUrl($this), $this);
            $this->setPreviewImageId($file->getUid());
        }
        if(isset($data["height"])){
            $defaultHeight = $service->getDefaultHeight();
            $this->setHeight($data["height"], $defaultHeight);
        }
        if(isset($data["width"])){
            $defaultWidth = $service->getDefaultWidth();
            $this->setWidth($data["width"], $defaultWidth);
        }
    }    
}