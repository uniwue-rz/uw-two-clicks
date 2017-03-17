<?php
/**
* Returns the Backend configuration for the extension.
*
*
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility;

class BackendConfig{

    /**
    * Returns the fallback config for the given Backend
    *
    */
    public function getFallbackConfig(){

    }

    /**
    * Returns the configuration for the given key.
    *
    * @param string $key The key can be single value like setting or dotted, like settings.url
    *
    * @return mix
    */
    public function value($key){
        $allConfig = $this->all();

        return $this->extractKey($allConfig, $key);
    }

    /**
    * Returns the whole configuration for the given extension
    *
    * @return array
    **/
    public function all(){

        return unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['uw_two_clicks']);
    }

    /**
    * Parses the given key to given values, returns null if not found
    * 
    * @param string $allConfig  All the configs available
    * @param string $key        The key for the given value
    *
    * @return mix|Null
    */
    public function extractKey($allConfig, $key){
        $keyArray = explode(".", $key);
        if(sizeof($keyArray) === 0){

            return Null;
        }
        if(sizeof($keyArray) === 1){
            $keyForValue = $keyArray[0].".";
            if(isset($allConfig[$keyForValue])){

                return $allConfig[$keyForValue];
            }
        }
        if(sizeof($keyArray)> 1){
            foreach($keyArray as $v => $k){
                if($v !== sizeof($keyArray) - 1){
                    $allConfig = $allConfig[$k."."];
                }
                else{

                    return $allConfig[$k];
                }
            }
        }
    }

}