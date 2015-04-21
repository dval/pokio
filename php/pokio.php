<?php
require_once('pokio-recorder.php');



$mypok = new Pokio();
$mypok->handleRequest();

//$mypok->test() ;

//dynamic salt
//$mypok->makeSalt(md5(uniqid($_SERVER['REMOTE_ADDR'], true)));

