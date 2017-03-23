<?php
/**
* Data input in the backend will be manipulated using this hook.
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Hooks;


use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Extbase\Service\FlexFormService;

class ProcessDataMap {

    /**
     * Process the input of the Flexform after it is created or edited
     *
     * @param string                                   $status       status
     * @param string                                   $table        table name
     * @param int                                      $recordUid    id of the record
     * @param array                                    $fields       fieldArray
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $parentObject parent Object
     */
    public function processDatamap_afterDatabaseOperations(
        $status,
        $table,
        $id,
        array $fieldArray,
        \TYPO3\CMS\Core\DataHandling\DataHandler &$dataHandler) {
            if($table === "tt_content") {
                if($status === "new") {
                       // Converts the New With database ids
                       $id = $dataHandler->substNEWwithIDs[$id];
                }
                $content = BackendUtility::getRecord('tt_content', $id, 'CType, list_type, pid, uid, pi_flexform');
                if($this->isTwoClicksElement($content)){
                    $this->createOrUpdateRecord($content, $status, $dataHandler);
                }
            }
    }

    /**
    * Checks if the given fieldArray is a uw_two_click element
    *
    * @param array   $filedArray The field  
    * @param string  $status     The status of the query
    *
    * @return bool
    */
    public function isTwoClicksElement($fieldArray){
        if(isset($fieldArray["CType"]) && isset($fieldArray["list_type"])){
            if($fieldArray["CType"] === "list" && $fieldArray["list_type"] === "uwtwoclicks_app"){
                    
                return true;
            } 
        }

        return false;
    }

    /**
    * Create the data record for the the table.
    *
    * @param array  $content  The content from the array
    * @param string $status   The status of the given element
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $parentObject parent Object
    *
    * @return array
    */
    public function createOrUpdateRecord($content, $status, $dataHandler){
        // Create flexform setting data
        $flexFormArray = $this->convertFlexFormToArray($content["pi_flexform"]);
        // Create the given data
        $data = array();
        // New Record
        if($status === "new"){
            $id = StringUtility::getUniqueId('NEW');
            $data["tx_uw_two_clicks_records"][$id] = array(
                'content_id' => $content["uid"],
                'pid' => $content["pid"]
            );
            $dataHandler->stripslashes_values = 0;
            $dataHandler->start($data, array());
            $dataHandler->process_datamap();
        }
        if($status === "update"){
            
        }

        
    }


    /**
    * Updates the flex form with the given id of the element
    *
    * @param 
    */
    public function updateFlexFormWithId(){

    }

    /**
    * Converts the given flexform to an array
    *
    * @param string $flexFormContent The content of the flexform field
    *
    * @return array
    **/
    public function convertFlexFormToArray($flexFormContent){
        $flexFormService = GeneralUtility::makeInstance(FlexFormService::class);

        return $flexFormService->convertFlexFormContentToArray($flexFormContent);        
    }

} 