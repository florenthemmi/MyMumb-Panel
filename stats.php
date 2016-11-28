<?php
require 'Ice.php';
require 'inc/config.inc.php';
require 'inc/Murmur.php';

$password = array('secret' => $MyConfig['ICE_Password']);
$Ice = Ice_initialize();
$ip = $MyConfig['default_host'];
$port = $MyConfig['default_port'];
$base = $Ice->stringToProxy($MyConfig['MetaConnection']." -h $ip -p $port");
$MasterServer = $base->ice_checkedCast("::Murmur::Meta")->ice_context($password);
$Server = $MasterServer->getServer(1)->ice_context($password);

$tree = $Server->getTree();
echo count($tree->users);
?>
