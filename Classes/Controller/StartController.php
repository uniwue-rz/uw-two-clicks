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

class StartController extends ActionController{
    /**
    * The index action which is called by the plugin
    */
    public function indexAction(){
                 $backendData = new BackendConfig();
                 var_dump($backendData->all());
                 $fileHandler = new FileHandler();
                 $url = new Url("http://php.net/images/logos/php-logo.svg", "google.txt");
                 $data = $this->configurationManager->getContentObject()->data;
                 var_dump($fileHandler->getContentFileMount($data["uid"]));
                 $this->configurationManager->getContentObject()->readFlexformIntoConf($data['pi_flexform'], $a);
                 $this->view->assign('hello', "HELLO");
    }



    public function getPagePerms($id){
        $pageinfo = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord(
           'pages',
           $id,
           '*',
           ($perms_clause ? ' AND ' . $perms_clause : '')
       );

       return $pageinfo;
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