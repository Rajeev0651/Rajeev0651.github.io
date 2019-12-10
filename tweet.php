<HTML>
<TITLE></TITLE>
<HEAD>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
body{
	 background-color : #e7e7e7;
 }
 .button{
	 background-color: #008CBA;
	 font-size: 20px;
	 -webkit-transition-duration:
  transition-duration: 0.4s;
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
 }
 .button:hover{
	 background-color: #008CBA;
 }
</style>
</HEAD>
<BODY>
<?php
require_once 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
if(isset($_POST['send'])){
	tweet();}
function tweet(){
session_start();
$config = require_once 'config.php';	
$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
if (empty($oauth_verifier) ||
    empty($_SESSION['oauth_token']) ||
    empty($_SESSION['oauth_token_secret'])
) {

    header('Location: ' . $config['url_login']);
}
$connection = new TwitterOAuth(
$config['consumer_key'],
$config['consumer_secret'],
$_SESSION['oauth_token'],
$_SESSION['oauth_token_secret']
);
$token = $connection->oauth(
    'oauth/access_token', [
        'oauth_verifier' => $oauth_verifier
    ]
);
	
$twitter = new TwitterOAuth(
$config['consumer_key'],
$config['consumer_secret'],
$token['oauth_token'],
$token['oauth_token_secret']
);
$message = $_POST['send'];
$status = $twitter->post(
          "statuses/update", [
          "status" => $message
    ]
);
 echo ('Created new status with #' . $status->id . PHP_EOL);	
}
?>
<center><br><br><br><br><br>
<label for="comment"><B>Message<B></label><br>
 <form method = "POST">
 <textarea placeholder = "What's happening?" rows = "7" cols = "40" name="send"></textarea></Br></br>
 <button type = "submit" class="button btn pmd-btn-fab pmd-ripple-effect btn-success pmd-btn-raised" type="button"><i class="material-icons pmd-sm">Tweet</i></button>
 </form>
</center>
</BODY>
</HTML>