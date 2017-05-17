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
$userid = trim($userid, "'");
//echo $userid;
// Include the required dependencies.
require( '../facebook-php-sdk-5/src/Facebook/autoload.php' );

// Initialize the Facebook PHP SDK v5.
$fb = new Facebook\Facebook([
  'app_id'                => '2092932830933312',
  'app_secret'            => '282303ece01dd46a3436dd94606c06ca',
  'default_graph_version' => 'v2.9',
// 'default_access_token' => '{access-token}', 
  
]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
 $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
// $helper = $fb->getCanvasHelper();
//  $helper = $fb->getPageTabHelper();

try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
      $helper->getPersistentDataHandler()->set('state', $_GET['state']);
   $accessToken = $helper->getAccessToken();  
  // var_dump($accessToken);
   
   $response1 = $fb->get('/me?fields=id,name,about,birthday,political,feed,likes,gender', $accessToken);
  $response2 = $fb->get('/me/likes?fields=about', $accessToken, 'summary=true');
    $response3 = $fb->get('/me/news.reads', $accessToken, 'summary=true');
  
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$me = $response1->getGraphUser();
//echo 'Logged in as ' . $me->getName();
//echo "<br>";

// echo 'ID  ' . $me->getId();

$user = $response1->getGraphObject()->asArray();

//likes 
$pagesEdge = $response2->getGraphEdge()->asArray();
 
//
$birthday = $user['birthday'];
$political = $user['political'];
$feedarray = $user['feed'];
$fbid = $user['id'];
$gender = $user['gender'];

$newsitems = $response3->getGraphEdge()->asArray();

var_dump $newsitems; 

foreach ($newsitems as $graphNode) {
	
echo "this is a news item" . $graphNode;

}


//calculate age
$age = date_diff($birthday, date_create('today'))->y;
//var_dump ($age);
//generate unique id

//$userid = uniqid('', true);
//echo $userid;



//connect to database

// Create connection
	require_once ('../../databaseconnection.php');

//check if user has already participated

$sql = "SELECT * FROM `facebookusers` WHERE `fbid`='{$fbid}'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
//echo "user already exists";
$usercopy = "TRUE";

} else {
$usercopy = "FALSE";
//insert user into record of participants
$sql = "INSERT INTO facebookusers  (fbid)
VALUES ('$fbid')";

if ($conn->query($sql) === TRUE) {
   // echo "New record created successfully";
} else {
    echo "Error1: " . $sql . "<br>" . $conn->error;
}
//echo "new user created";
}

//echo $usercopy;


//insert user into database

$sql = "INSERT INTO facebookresults (userid,age,political, usercopy, gender )
VALUES ('$userid','$age','$political', '$usercopy', '$gender')";

if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
} else {
    echo "Error2: " . $sql . "<br>" . $conn->error;
}

//insert likes into database

foreach ($pagesEdge as $graphNode) {
	
if (array_key_exists ('about', $graphNode)){
$likeabout = $graphNode['about'];
$likeabout = str_replace("'", '"', $likeabout);
}


$likeid = $graphNode['id'];

$sql = "INSERT INTO facebooklikes (userid,about, linkid )
VALUES ('$userid','$likeabout','$likeid')";
if ($conn->query($sql) === TRUE) {
    //echo "New link record created successfully";
} else {
    echo "Error3: " . $sql . "<br>" . $conn->error;
}
}


//insert posts into database
// Create connection

foreach ($feedarray as $feeditem) {
	
	if (array_key_exists ('message', $feeditem)){
		$feedmessage = $feeditem['message'];
		$feedmessage = str_replace("'", '"', $feedmessage);
	}
  
	$feedtime = $feeditem['created_time'];
	$feedtime = date_format($feedtime, 'Y-m-d H:i:s');
	$feedid = $feeditem['id'];
$sql = "INSERT INTO facebookposts (userid,postmessage, postcreated, postid )
VALUES ('$userid','$feedmessage','$feedtime', '$feedid')";


if ($conn->query($sql) === TRUE) {
//  Header("Location: surveyform.php?userid=$userid"); 
} else {
    echo "Error4: " . $sql . "<br>" . $conn->error;
}
}
$conn->close();



?>


</html>