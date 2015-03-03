<?php
/** pokio
*
*/
require_once('./pokio-config.php');

class Pokio {

    private $pokio = array();
    private $pokio_cfg = array();
    private $storageDB;

    public $verbos = 0;

    public function __construct($config) {
        $this->pokio_cfg = $config;
        $storageDB = $this->pokio_cfg['db-type'];
        if(!$storageDB){
            $storageDB = $this->pokio_cfg['statfile'];
        }
    }

    public function __set($variable, $value){
        $this->pokio_cfg[$variable] = $value;
    }

    public function __get($variable){
        if(isset($this->pokio_cfg[$variable])){
            return $this->pokio_cfg[$variable];
        }else{
            die('Unknown error: Err');
        }
    }

    private function buildHeaderJSON(){
            header('HTTP/1.0 200 OK');
            header("Content-Type: text/plain");
    }

    private function buildHeaderText(){
            header('HTTP/1.0 200 OK');
            header("Content-Type: application/json");
    }

    //cheap domain control
    //there are 'better' ways, this is just convenient
    public function allowedHost(){

        $allowedDomain = $this->pokio_cfg['domain'];

        //filter proxied requests
        if (strstr($_SERVER['REMOTE_ADDR'], ', ')) {
            $ips = explode(', ', $_SERVER['REMOTE_ADDR']);
            $requestDomain = $ips[0];
        }else{
            $requestDomain = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        }

        //make sure . is the only non-alphanumeric
        $containsSpecial = preg_match_all('/([^\pL\pN])/', $requestDomain, $specialMatch);
        foreach($specialMatch[0] as $spChar){
            if($spChar !== '.'){
                die('Unknown error: Error');
            }
        }

        //do stuff
        if($containsSpecial || $requestDomain === 'localhost'){
            foreach($allowedDomain as $domain){
                if($requestDomain === $domain){
                    header('Access-Control-Allow-Origin: '.$domain);
                    return true;
                }
            }
        }

        return false;
    }

    public function writeToStorage($stat){

        if(!$this->storageDB){
            $myFile = $this->pokio_cfg['statfile'];
            $fh = fopen($myFile, 'a') or die("can't open file");

            //$stringData = "New Stuff 2\n";
            $stringData = $_POST['ts'].", ".$_POST['id']."\n";
            fwrite($fh, $stringData);
            fclose($fh);
        }else{
            //query db
            continue;
        }

    }

}


$mypok = new Pokio($pokio_cfg);
if( $mypok->allowedHost() || ! $mypok->allowedHost()){
    $mypok->writeToStorage('data');
}


/*


    $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
    $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
    echo $scriptFolder;

$pagename = '';
if(isset($_POST['m']) && $_POST['m']!=''){
    //quick alphanumeric sanitize
    $pagename =  preg_replace("/[^a-zA-Z0-9_-]+/", "", stripslashes(strval($_GET['m'])));
}
if($pagename === '' || $pagename !== $_GET['m']){
    //redirect if anything besides a string is passed to query (No Hackers!)
    header( 'Location: http://ntangle.tv' );
}


// check the query string
$callingURL='None';
$callingDB='None';
if(isset($_GET['m']) && $_GET['m'] != ''){
    if(isset($_GET['d']) && $_GET['d'] != ''){
        $callingURL = 'http://208.43.240.138:5984/ntangle_'.$_GET['d'].'/'.$_GET['m'];
    }
}


function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

// put response together
if($callingURL != 'None'){
    // check file exists
    if(get_http_response_code($callingURL) != "404"){
        $file = file_get_contents($callingURL);
        header('HTTP/1.0 200 OK');
        header("Content-Type: application/json");
    }else{
        $file = '404 File Not Found';
        header('HTTP/1.0 404 File Not Found');
        header("Content-Type: text/plain");
    }
}else{
    $file = '{"error":"There was a problem with your request"}';
}


echo $file;
*/
