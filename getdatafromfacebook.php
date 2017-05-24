
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Megan Knight - University of Hertfordshire - Social Media Research</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <div class="container">
    <div class="row">
      <div class="one-half column" style="margin-top: 25%">

<h5>Megan Knight - University of Hertfordshire</h5>

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
   $response3 = $fb->get('/me/news.reads', $accessToken);

  
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
 
 //news items
 
 //echo "this is response3 again: ";
//print_r ($response3); 
//var_dump ($response3);
 
$newsitems = $response3->getGraphEdge()->asArray();

// echo "this is newsitems again: ";
//echo $newsitems;
//var_dump  ($newsitems);


//$newsarray = array_values ($newsobject);
//echo "newsarray  is" . $newsarray)  "<br>";

// echo "newsobject  is" . $newsobject . "<br>";


//print_r(array_keys($newsitems));





//$newsid = $graphNode['id'];
//$newstitle = $graphNode['article'];
//$newsurl = $graphNode['url'];
//echo "<b>this is a news title: </b>" . $newstitle . "<br>";



 
//
$birthday = $user['birthday'];
$political = $user['political'];
$feedarray = $user['feed'];
$fbid = $user['id'];
$gender = $user['gender'];
//echo $gender;

//calculate age
$age = date_diff($birthday, date_create('today'))->y;
//var_dump ($age);
//generate unique id

//$userid = uniqid('', true);
//echo $userid;



//connect to database

// Create connection
	require_once ('../databaseconnection.php');

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

//insert reads into database


foreach ($newsitems as $graphNode) {
	
//$newsfield = $graphNode['article'];
//$newsfield = str_replace("'", '"', $newsfield);

//echo "<b>this is a news item: </b>" ;
//print_r	($graphNode);
//echo "<br>";	
//print_r (array_keys($graphNode));
echo "<br>";

$newsitemdata = ($graphNode['data']);
foreach ($newsitemdata as $article) {
	
$articleid=$article['id'];	
$articletitle=$article['title'];	
$articletitle = str_replace("'", '"', $articletitle);
$articleurl=$article['url'];	

$sql = "INSERT INTO facebookreads (userid,articleid, articletitle, articleurl )
VALUES ('$userid','$articleid','$articletitle', '$articleurl')";
if ($conn->query($sql) === TRUE) {
    //echo "New link record created successfully";
} else {
    echo "Error3: " . $sql . "<br>" . $conn->error;
}

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
  Header("Location: surveyform.php?userid=$userid"); 
} else {
    echo "Error4: " . $sql . "<br>" . $conn->error;
}
}
$conn->close();



?>

      </div>
    </div>
  </div>
</html>