<?php

	$MyConfig = array();


	$MyConfig['default_host'] = 'murmur'; //Ip of your Mumble Server. If its the same Server no need to change it.
	$MyConfig['default_port'] = 6502; //The Port of your Mumble Server

	$MyConfig['ICE_Password'] = ''; //The Password used in the mumble-server.ini 

	$MyConfig['default_language'] = 'en_EN'; //Change the Language currently supported en_EN fr_FR de_DE

	
	
	/*
	**	Edit the following line ONLY if you have trouble for connection
	**	Comment the first line and uncomment the other.
	*/
		//$MyConfig['MetaConnection'] = "Meta:tcp";
		$MyConfig['MetaConnection'] = "Meta -e 1.0:tcp";
?>
