<?php
/* pokio base class
** Handles session and token creation 
** for 'secure' ajax requests.  
*/
define('POKIO_CSV', 'csv');
define('POKIO_JSON', 'json'); 
define('POKIO_HTML', 'html'); 
define('POKIO_TEXT', 'txt'); 
define('POKIO_DATABASE', 'db'); 

session_start();

class Pokio {

    private $config;
    private $token;
    private $salt;
    private $storageDB;
    private $contentLength;

    public $verbos = 0;

    public function __construct() {

        require_once('pokio-config.php');
        $this->config = $pokio_cfg;
        $this->salt = md5($this->config['salt']);
        //set storage from config file
        switch ($this->config['logType']){
            case POKIO_CSV :
                $storageDB = $this->config['statfile'];
                break;
            case POKIO_JSON :
                $storageDB = $this->config['statfile'];
                //could also be mongo update?
                break;
            case POKIO_DATABASE :
                //mysqli db connection
                break;
        }
        $this->output = "";
    }

    private function buildHeader($type){
        //header('Access-Control-Allow-Origin:'.join($this->config['allowedHosts'],","));
        if($this->allowedHost()){
            header('HTTP/1.1 200 OK');
            header('Cache-Control:no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            header('Content-Length:'.$this->contentLength);
            header('Date:'.gmdate("D, j M Y G:i:s T"));
            header('Expires:'.gmdate("D, j M Y G:i:s T",mktime(1,0,0,1,1,1970)));
            header('Pragma:no-cache');
            header('X-Powered-By:Pokio/0.2');
            switch($type){
                case POKIO_CSV :
                    header("Content-Type: text/plain");
                    break;
                case POKIO_TEXT :
                    header("Content-Type: text/plain");
                    break;
                case POKIO_JSON :
                    header("Content-Type: application/json");
                    break;
                case POKIO_HTML :
                    header("Content-Type: text/html");
                    break;
            }
        }else{
            $this->breakResponse();
        }
    }

    private function generateToken() {
        //make, store, and return a unique token
        $this->token = md5(uniqid(microtime(), true));  
        $_SESSION[$this->salt] = $this->token; 
        
        return $this->token;
    }

    private function validateToken() {

        if(isset($_SESSION[$this->salt]) && isset($_POST[$this->salt])){
            if($_SESSION[$this->salt] == $this->sanitizedPost($this->salt)){
               return true;
            }
        }
        
        return false;
    }

    //pass name of $_POST arg to 'clean'
    private function sanitizedPost($parg){
        if(isset($_POST[$parg])){
            $pv = (string) stripslashes($_POST[$parg]);
            $stringTest = (string) preg_replace("/[^a-zA-Z0-9_\#\.\-]+/", "", stripslashes($_POST[$parg]));
            //force salt and token to strings before comparison
            if($stringTest == $pv){
                return $pv;
            }
            $this->breakResponse();
        }
        
        return false;
        
    }

    private function breakResponse(){
        header('HTTP/1.1 404 Not Found');
        die('File Not Found');
    }

    //cheap domain control
    private function allowedHost(){

        // get allowed domains
        $allowedDomains = $this->config['allowedHosts'];
        $requestDomain = $_SERVER['HTTP_HOST'];

        //filter proxied requests
        if (strstr($_SERVER['REMOTE_ADDR'], ',')) {
            $ips = explode(', ', $_SERVER['REMOTE_ADDR']);
            $requestDomain = gethostbyaddr($ips[0]);
        }
        
        //add header
        foreach($allowedDomains  as $domain){
            if($requestDomain === $domain){
                header('Access-Control-Allow-Origin: '.$domain);
                return true;
            }
        }

        //or don't
        return false;
    }

    private function writeToStorage($line){

        if(!$this->storageDB){
            $myFile = realpath(dirname(dirname(__FILE__))).$this->config['statfile'];
            $fh = fopen($myFile, 'a') or die("can't open file");

            $stringData = $line."\n";

            fwrite($fh, $stringData);
            fclose($fh);
        }else{
            //query db
            continue;
        }

    }

    public function handleRequest(){

        if($this->allowedHost()){
            if($this->validateToken()){
                $record = $this->sanitizedPost('ts').", ";
                $record.= $this->sanitizedPost('id');
                
                $this->writeToStorage($record);

                $this->buildHeader(POKIO_TEXT);

                print "success";

            }else{
                $this->buildHeader(POKIO_JSON);
                print "{\"".$this->salt."\":\"".$this->generateToken()."\"}\n";
            }
        }

    }

    public function test(){

        ob_start();
        $output = "<h2>Tests:</h2>\n";
        $output.= "<p>Token: ".$this->token."</p>\n";
        foreach($this->config['allowedHosts']  as $domain){
            $output.= "<p>domain: ".$domain."</p>\n";
        }
        $output.= "<p>Allowed Host: ".(string)$this->allowedHost()."</p>\n";
        //$output.= "<p>Storage : ".$this->writeToStorage('data,test')."</p>\n";
        $output.= gmdate("D, j M Y G:i:s T",mktime(1,0,0,1,1,1970))."\n";
        foreach($_SERVER as $k=>$v){
            $output.= $k." : ".$v."<br>\n";
        }
        print $output;
        $this->contentLength=ob_get_length();
        $this->buildHeader(POKIO_HTML);
        ob_end_flush();
    }
}
