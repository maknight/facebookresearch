<!DOCTYPE html>
<html>
<title>Megan Knight - University of Hertfordshire - Social Media Research</title>
<body>

<h3>Megan Knight - University of Hertfordshire</h3>



<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);


// Pass session data over.
session_start();
$userid=$_GET['userid'];

//echo $userid;
 
// Include the required dependencies.
require( '../facebook-php-sdk-5/src/Facebook/autoload.php' );

// Initialize the Facebook PHP SDK v5.
$fb = new Facebook\Facebook([
  'app_id'                => '2092932830933312',
  'app_secret'            => '282303ece01dd46a3436dd94606c06ca',
  'default_graph_version' => 'v2.9',
  
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['public_profile','user_religion_politics', 'user_birthday', 'user_posts', 'user_likes']; // optional
//$permissions = array(
    //'public_profile',
    //'user_location',
    //'user_birthday',
	//'user_religion_politics',
	//'user-posts'
//);
 
// Get login URL
 $callback    = "http://www.meganknight.uk/research/getdatafromfacebook.php?userid='$userid'";
//$callback    = "http://localhost/research/getdatafromfacebook.php?userid='$userid'";
$loginUrl    = $helper->getLoginUrl($callback, $permissions);
$helper = $fb->getRedirectLoginHelper();


if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // There was an error communicating with Graph
  echo $e->getMessage();
  exit;
}
 
if (isset($accessToken)) {
  // User authenticated your app!
  // Save the access token to a session and redirect
  $_SESSION['facebook_access_token'] = (string) $accessToken;
  // Log them into your web framework here . . .
  echo 'Successfully logged in!';
  
$cilent = $fb->getOAuth2Client();
   
  exit;
} elseif ($helper->getError()) {

  // The user denied the request
  // You could log this data . . .
  var_dump($helper->getError());
  var_dump($helper->getErrorCode());
  var_dump($helper->getErrorReason());
  var_dump($helper->getErrorDescription());
  // You could display a message to the user
  // being all like, "What? You don't like me?"
  exit;
} else {
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';	
}
 
// If they've gotten this far, they shouldn't be here
http_response_code(400);
exit;

?>
</html>