<?php $pokio_cfg=array();
//******************************************************//
//configure Pokio for your server/domain configuration
//******************************************************//

//unique id for install
$pokio_cfg['name']="Pokio the awesome!";

//path from server root
$pokio_cfg['allowedHosts']=['localhost','127.0.0.1'];

//path from server root
$pokio_cfg['root']='/pokio';

//allow http as well as https?
$pokio_cfg['http']=true;

//A unique pass phrase for this install
$pokio_cfg['salt']="I am the Walrus. Ko0 Ko0 Katcho0";

//changing this will attempt to create a new file.
//relative to pokio install
$pokio_cfg['statfile']="/stats/ratings.csv";

//how to store pok counts
$pokio_cfg['logType']=POKIO_JSON;  //POKIO_DATABASE //POKIO_CSV

//how to return pok counts
$pokio_cfg['return']=POKIO_JSON;  //POKIO_HTML //POKIO_CSV

//only used if 'logtype' is POKIO_DATABASE.
//relative to pokio install

#$pokio_cfg['db-name']="/path/to/sqlite.db";
//OR:
#$pokio_cfg['db-host']="mysql-host";
#$pokio_cfg['db-login']="mysql-username";
#$pokio_cfg['db-pass']="mysql-password";
#$pokio_cfg['db-name']="mysql-database";
