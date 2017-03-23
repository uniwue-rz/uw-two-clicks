<?php
/**
* This class can be used to handle urls. Every url that is used
* in this project is an instance of this class. This class
* uses CURL to fetch the urls.
* 
* @author Pouyan Azari <pouyan.azari@uni-wuerzburg.de>
* @license MIT
*/

namespace De\Uniwue\RZ\Typo3\Ext\UwTwoClicks\Utility;

class Url{

    /**
    * Placeholder for the url
    *
    * @var $url
    */
    protected $url;

    /**
    * Placeholder for the tmp folder
    *
    * @var $tmpFolder 
    */
    protected $tmpFolder;

    /**
    * Placeholder for the name of the file to be saved
    *
    * @var name
    **/
    protected $name;

    /**
    * Placeholder for the variables for the url
    *
    * @var parameters
    */
    protected $parameters = array();

    /**
    * Constructor
    *
    * @param string $url  The link that should be handled.
    * @param string $name The name of the file to be saved.
    */
    public function __construct($url, $name=''){
        if (filter_var($url, FILTER_VALIDATE_URL) === true){
            throw new Exception("The URL is not valid");
        }
        $this->url = $url;
        $this->name = $name;
        $this->tmpFolder = sys_get_temp_dir()."/";
    }

    /**
    * Adds the given parameter to the given url
    *
    * @param string $key    The key for the given parameter
    * @param mix    $value  The value for the given parameter
    */
    public function addParameter($key, $value){
        $this->parameters[$key] = $value;
    }


    /**
    * Adds the parameters to the given url
    */
    public function addParametersToUrl(){
        if(sizeof($this->parameters)>0){
            $parameters = http_build_query($this->parameters);
            $this->url = $this->url."?".$parameters;
        }
    }

    /**
    * Returns the path to store the file
    *
    * @return string
    */
    public function getStorePath(){
        return $this->tmpFolder.$this->name;
    }

    /**
    * Fetch the given file, if not asVar file be saved in /tmp/
    * 
    * @param string $type  The type of the fetch that should be done
    * @param array  $data  The data that should be used
    * @param bool   $asVar If the fetched content should be given as variable
    * 
    * @return mix
    */
    public function fetch($type = "GET", $data = array(), $asVar = false){
        $this->addParametersToUrl();
        $ch = curl_init($this->url);
        if($asVar === false){

            return $this->fetchAsFile($ch);
        }
        else{
            
            return $this->fetchAsVar($ch);
        }
    }

    /**
    * Downloads the file to the given path. Returns the path to the file.
    *
    * @param CURL $curl The curl object that should be used.
    *
    * @return CURL
    */
    public function fetchAsFile($curl){
        $fp = fopen($this->getStorePath(), "w");
        curl_setopt($curl, CURLOPT_FILE, $fp);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_exec($curl);
        echo "<br>Error is : ".curl_error($curl); 
        curl_close($curl);
        fclose($fp);

        return $this->getStorePath();
    }


    /**
    * Fetches the given url as variable
    *
    * @param CURL $curl The curl object that should be used.
    *
    * @return mix
    */
    public function fetchAsVar($curl){
        curl_setopt($curl, CURLOPT_HEADER, 0);  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }

    
}