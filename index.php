<?php
include 'inc/config.inc.php';
include 'Ice.php';
require 'inc/Murmur.php';

session_start();

// Initialize language
if(file_exists('languages/'.$MyConfig['default_language'].'.php'))
{
	include 'languages/'.$MyConfig['default_language'].'.php';
}
else
	die('ERROR, CANT INITIALIZE LANGUAGE');
	
$LanguageInfos = array(
	'fr_FR' => 'Français',
	'en_EN' => 'English',
);

echo '
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyMumb - Murmur Server Management </title>
    <link href="template/css/bootstrap.css" rel="stylesheet">
	<link href="template/css/default.css" rel="stylesheet">
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="'. ( isset($_GET['login']) ? 'active' : '' ) .'"><a href="?login">'.$LANGUAGE['login_button'].'</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="https://github.com/florenthemmi/MyMumb-Panel">'.$LANGUAGE['mumble_menu_github'].'</a></li>
          </ul>
        </div>
      </div>
    </div>
	
    <div class="container">';
	if(isset($_GET['login']))
	{
		echo '
		<h1 style="text-align:center;">'. $LANGUAGE['login_title'] .'</h1>
		<div class="well" style="margin: 0 auto; margin-top:30px; width:60%;">
			<div style="width:80%; margin: 0 auto;">';
		
		
		if(isset($_GET['login']))
		{
			if(isset($_POST['login_adress']) && isset($_POST['login_port']) && isset($_POST['login_password']))
			{
				try
				{
					$Password = array('secret' => $_POST['login_password']);
					$ICE = Ice_initialize();
					$ip = $_POST['login_adress'];
					$port = $_POST['login_port'];
					$base = $ICE->stringToProxy($MyConfig['MetaConnection']." -h $ip -p $port");
					$meta = $base->ice_checkedCast("::Murmur::Meta")->ice_context($Password);
					
					// Check Read Rights:
					$meta->getUptime();
					
					$_SESSION['host'] = $_POST['login_adress'];
					$_SESSION['port'] = $_POST['login_port'];
					$_SESSION['password'] = $_POST['login_password'];
					
					header('location: mumble/');
					
				}
				catch (Exception $e) 
				{
					echo '<div class="alert alert-danger">'. $LANGUAGE['login_error'] .'</div>';
				}
			}
		}
		
		echo '
		<form action="?login" method="post">
			<div class="row">
				<div class="col-sm-5"> <b>'. $LANGUAGE['login_adressip'] .'</b> </div>
				<div class="col-sm-7"><input type="text" class="form-control" name="login_adress" placeholder="'. $LANGUAGE['login_adressip_hint'] .'" value="'. $MyConfig['default_host'] .'"></div>
			</div>
			
			<div class="row" style="margin-top:10px;">
				<div class="col-sm-5"> <b>'. $LANGUAGE['login_port'] .'</b> </div>
				<div class="col-sm-7"><input type="text" class="form-control" name="login_port" placeholder="'. $LANGUAGE['login_port_hint'] .'" value="'. $MyConfig['default_port'] .'"></div>
			</div>
			
			<div class="row" style="margin-top:10px;">
				<div class="col-sm-5"> <b>'. $LANGUAGE['login_icepassword'] .'</b> </div>
				<div class="col-sm-7"><input type="password" class="form-control" name="login_password" placeholder="'. $LANGUAGE['login_icepassword_hint'] .'"></div>
			</div>
			
			<div style="text-align: center; margin-top:20px;">
				<input type="submit" value="'. $LANGUAGE['login_button_submit'] .'" class="custom-metro cm-green"/>
			</div>
		</form>';
		
		echo '
			</div>
		</div>';
	}
	elseif(isset($_GET['help']))
	{
		echo '
		<div class="well" style="margin: 0 auto; margin-top:30px; width:100%; text-align:center;">
		<h4>Il est nécessaire de configurer correctement votre serveur Murmur pour pouvoir utiliser notre panel de gestion.</h4>
		
		
		
			
		</div>
		';
	}
	elseif(isset($_GET['dev']))
	{
		echo '
		<div class="well" style="margin: 0 auto; margin-top:30px; width:60%; text-align:center;">
			
			'. str_replace('{GitHub_LINK}', '<a href="https://github.com/florenthemmi/MyMumb-Panel">GitHub</a>', $LANGUAGE['dev_text']) .'
			
		</div>
		';
	}
	else
		header('location: ?login');
	
	echo '
    </div>

    <script src="/template/js/jquery.min.js"></script>
    <script src="/template/js/bootstrap.min.js"></script>
  </body>
</html>
';


?>
