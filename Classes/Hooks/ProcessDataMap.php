<?php
/**
* Data input in the backend will be manipulated using this hook.
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Hooks;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Backend\Utility\BackendUtility;

use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Domain\Model\Record;

class ProcessDataMap {

    /**
     * Process the input of the Flexform after it is created or edited
     *
     * @param string                                   $status       status
     * @param string                                   $table        table name
     * @param int                                      $recordUid    id of the record
     * @param array                                    $fields       fieldArray
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler  DataHandler Object with can be used to retrieve data
     */
    public function processDatamap_afterDatabaseOperations($status, $table, $id, array $fieldArray, DataHandler &$dataHandler) {
        if($table === "tt_content"){
            if($status ===  "new"){
                if(strpos(strval($id), "NEW") !== false){
                    $id = $dataHandler->substNEWwithIDs[$id];
                }
            }
            $content = $this->getContentType($id);
            if($this->isTwoClicksElement($content)){
                $record = new Record();
                $record->setContentId($id);
                $record->setPid($content["pid"]);
                    // Updates only happen when there is fieldArray change
                    if(isset($fieldArray["pi_flexform"])){
                        // Create a new Record that contains the changes
                        $record->syncWithRecords(true);
                        $newRecord = clone $record;
                        $newRecord->fillWithFlexForm($fieldArray["pi_flexform"]);
                        $diff = $newRecord->diff($record);
                        $record->updateRecordWithArray($diff);
                        $record->commitToRecordsTable($dataHandler);
                        $record->commitToFlexForm($dataHandler);
                  }
            }
        }
    }

    /**
    * Post process then data that should put to the database before the commit
    *
    * @param string                                    $status         The status of the record, can be new or updated
    * @param string                                    $table          The table the operation is designated to
    * @param int                                       $id             The id of the element the operation is done on
    * @param array                                     $fieldArray     The field input data or changed data
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler  $dataHandler    DataHandler Object with can be used to retrieve data
    */
    public function processDatamap_postProcessFieldArray($status, $table, $id, array &$fieldArray, DataHandler &$dataHandler) {
    }

    /**
    * This command is run for the 
    *
    * @param string                                   $table              The table the delete action is done
    * @param int                                      $id                 The id of the element to be deleted
    * @param array                                    $recordToDelete     The record that should be deleted
    * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler        DataHandler Object with can be used to retrieve data
    */
    public function processCmdmap_deleteAction($table, $id, $recordToDelete, $recordWasDeleted=NULL, DataHandler &$dataHandler) {
    }

    /**
    * Returns the content type for the given id
    *
    * @param int $id The id of the given content element
    *
    * @return array
    */
    public function getContentType($id){
        
        return BackendUtility::getRecord("tt_content", $id, "CType, list_type, pid");
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

} 