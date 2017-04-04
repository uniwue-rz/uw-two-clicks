<?php
/**
* The main controller for the Two Click application
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
**/
namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Controller;

use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility\BackendConfig;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
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
        $disclaimer = $backendConfig->value($record["record_type"].".disclaimer");
        $forward = $backendConfig->value($record["record_type"].".forward");
        $this->view->assign('record', $record);
        $this->view->assign('forward', $forward);
        $this->view->assign('disclaimer', $disclaimer);
    }
}