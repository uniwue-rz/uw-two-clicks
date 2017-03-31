<?php
/**
* The main controller for the Two Click application
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
**/
namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\BackendConfig;
use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\Url;
use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\FileHandler;
use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Services\YoutubeService;
use TYPO3\CMS\Backend\Utility\BackendUtility;

class StartController extends ActionController{
    /**
    * The index action which is called by the plugin
    */
    public function indexAction(){
        $data = $this->configurationManager->getContentObject()->data;
        $backendConfig = new BackendConfig();
        $flexFromData = array();
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $flexFromData);
        $record = BackendUtility::getRecord("tx_uw_two_clicks_records", intval($flexFromData["settings.two_click_record"]));
        $height = $record["height"];
        $width = $record["width"];
        $this->view->assign('image_id', $record["preview_image_id"]);
        $this->view->assign('height', $height);
        $this->view->assign('width', $width);
    }

    /**
    * Returns the user input from the flexForm data.
    *
    * @param array $contentData The content data that the FlexForm data should be extracted from
    *
    * @return array
    */
    private function getFlexData($contentData){
        $result = [];
        if(isset($contentData['pi_flexform'])){
            $this->configurationManager->getContentObject()->readFlexformIntoConf($contentData['pi_flexform'], $result);
        }
        
        return $result;
    }


    /**
    * Returns the content data from the database.
    *
    * @return array
    */
    private function getContentData(){

        return  $this->configurationManager->getContentObject()->data;
    }

}