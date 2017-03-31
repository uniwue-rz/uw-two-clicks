<?php
/**
* Dispatches the record to the right service.
*
* @author Pouyan Azari
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Services;

use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Domain\Model\Record;
use De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Services\YoutubeService;

class ServiceDispatcher{

    /**
    * Placeholder for the service that should be used.
    * @var Service
    */
    protected $service;

    /**
    * Placeholder for the record
    * @var Record
    */
    protected $record;

    /**
    * Constructor
    *
    * @param Record $record The record object that should be used.
    */
    public function __construct(Record $record){
        $this->setRecord($record);
    }

    /**
    * Sets the record for the service dispatcher
    *
    * @param Record $record The record object that should be used.
    */
    public function setRecord($record){
        $this->record = $record;
    }

    /**
    * Returns the record for the given dispatcher
    *
    * @return Record
    */
    public function getRecord(){
        
        return $this->record;
    }

    /**
    * Sets the service on hand the record
    */
    public function setService(){
        if($this->getRecord()->getRecordType() === "yt"){
            $this->service = new YoutubeService();
        }
        if($this->getRecord()->getRecordType() === "gm"){
            $this->service = new GoogleMapService();
        }
    }

    /**
    * Returns the Service
    *
    * @return Service
    */
    public function getService(){
        return $this->service;
    }
}