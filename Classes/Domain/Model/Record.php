<?php
/**
* Records class is generic class for all the data managed by this extensions.
* 
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
**/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Domain\Model;

use \TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Record extends AbstractEntity{

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
    * @var string
    */
    protected $previewImage;

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
    public function __construct($recordId = '', $service = '', $embeddedText = '', $width = 0, $height = 0, $autoPlay = false){
        $this->setRecordId($recordId);
        $this->setService($service);
        $this->setEmbeddedText($embeddedText);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->setAutoPlay($autoPlay);
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
}