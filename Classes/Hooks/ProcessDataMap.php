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
                $content = BackendUtility::getRecord('tt_content', $id, 'CType, list_type, pid, uid');
                if($this->isTwoClicksElement($content)){
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

} 