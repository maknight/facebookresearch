
<!DOCTYPE html>
<html>
<title>Megan Knight - University of Hertfordshire - Social Media Research</title>
<body>



<h5>Megan Knight - University of Hertfordshire</h5>

<?php
// Pass session data over.
session_start();
// Include the required dependencies.
//$userid=$_GET['userid'];
//$userid = trim($userid, "'");
//echo $userid;
//echo "<br>";
$userid=0;
$often=0;
$types1=0;
$types2=0;
$types3=0;
$types4=0;
$types5=0;
$types6=0;

$informed=0;
$vote=0;
$intent=0;
if (isset ($_POST['userid'])){
$userid = $_POST['userid'];}
//echo "user" . $userid;
//echo "<br>";
if (isset ($_POST['often'])){
$often = $_POST['often'];}
//echo "often" . $often;
//echo "<br>";
if (isset ($_POST['informed'])){
$informed = $_POST['informed'];}
//echo "informed" . $informed;
//echo "<br>";
if (isset ($_POST['vote'])){
$vote = $_POST['vote'];}
//echo "vote" . $vote;
//echo "<br>";
if (isset ($_POST['types1'])){
$types1 = $_POST['types1'];}
//echo "types1". $types1;
//echo "<br>";
if (isset ($_POST['types2'])){
$types2 = $_POST['types2'];}
//echo "types2". $types2;
//echo "<br>";
if (isset ($_POST['types3'])){
$types3 = $_POST['types3'];}
//echo "types3". $types3;
//echo "<br>";
if (isset ($_POST['types4'])){
$types4 = $_POST['types4'];}
//echo "types4". $types4;
//echo "<br>";
if (isset ($_POST['types5'])){
$types5 = $_POST['types5'];}
//echo "types5". $types5;
//echo "<br>";
if (isset ($_POST['types6'])){
$types6 = $_POST['types6'];}
//echo "types6". $types6;
//echo "<br>";
if (isset ($_POST['intent'])){
$intent = $_POST['intent'];}
//echo "intent" . $intent;
//echo "<br>";

$types = $types1 . $types2 . $types3 . $types4 . $types5 . $types6;
//echo $types;   

	//connect to database and upload data

	require_once ('../databaseconnection.php');

//insert record of consent
$sql = "INSERT INTO facebooksurvey  (userid, often, types, informed, vote, intent)
VALUES ('$userid', '$often', '$types', '$informed','$vote',  '$intent')";

if ($conn->query($sql) === TRUE) {
	echo "Thank you for your contribution to this research. If you have any questions, please feel free to contact me on m.knight3@herts.ac.uk";
	$to = "m.knight3@herts.ac.uk";
	$subject = "New survey response";
	$message = date('l jS \of F Y h:i:s A');
	mail($to,$subject,$message);
} else {
    echo "Error1: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>

</html>

