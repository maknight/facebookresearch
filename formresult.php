
<!DOCTYPE html>
<html>
<title>Megan Knight - University of Hertfordshire - Social Media Research</title>
<body>

<h3>Megan Knight - University of Hertfordshire</h3>

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
	require_once ('../../databaseconnection.php');
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

</html>
