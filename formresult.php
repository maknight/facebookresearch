
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

echo "this is working";

// Pass session data over.
session_start();
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
//assign user a unique id
$userid = uniqid('', true);

$purpose = $_POST['purpose'];

$withdraw = $_POST['withdraw'];

$age = $_POST['age'];


if ((strcmp($purpose, "yes") !== 0)) 
{
	Header("Location: thankyouno.php"); 
}
elseif ((strcmp($withdraw, "yes") !== 0)) 
{
	Header("Location: thankyouno.php"); 
}
elseif ((strcmp($age, "yes") !== 0)) 
{
	Header("Location:thankyouno.php"); 
}
else 
{
	require_once ('../databaseconnection.php');
} 

//insert record of consent
$sql = "INSERT INTO facebookconsent  (userid, consent)
VALUES ('$userid', '$purpose')";

if ($conn->query($sql) === TRUE) {
	Header("Location: logintofacebook.php?userid=$userid"); 
} else {
    echo "Error1: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
      </div>
    </div>
  </div>
</html>
