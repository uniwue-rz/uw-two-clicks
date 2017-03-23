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

class StartController extends ActionController{
    /**
    * The index action which is called by the plugin
    */
    public function indexAction(){
        $backendData = new BackendConfig();
        $youtubeService = new YoutubeService($backendData->value("youtube.apiUrl"), $backendData->value("youtube.apiToken"));
        $url = $youtubeService->getPreviewImageUrl("j8UCHvSK09E");
        $fileHandler = new FileHandler();
        $data = $this->configurationManager->getContentObject()->data;
        $youtubeService->addPreviewImageAsFile($url, "j8UCHvSK09E",$data["uid"]);
        $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $a);
        $this->view->assign('hello', "HELLO");
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