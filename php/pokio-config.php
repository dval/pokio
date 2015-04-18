<?php $pokio_cfg=array();
//******************************************************//
//configure Pokio for your server/domain configuration
//******************************************************//

//unique id for install
$pokio_cfg['name']="Pokio the awesome!";

//path from server root
$pokio_cfg['domain']=['localhost','127.0.0.1'];

//path from server root
$pokio_cfg['root']='/pokio';

//allow http as well as https?
$pokio_cfg['http']=true;

//changing this will attempt to create a new file.
//relative to pokio install
$pokio_cfg['statfile']="/stats/ratings.csv";

//use db instead of csv file
$pokio_cfg['db-type']=false;

//only work if 'db-on' is false.
//relative to pokio install
$pokio_cfg['db-path']="/path/to/sqlite.db";

//only work if 'db-on' is true.
$pokio_cfg['dbhost']="";
$pokio_cfg['dblogin']="";
$pokio_cfg['dbpass']="";
