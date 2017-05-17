
<!DOCTYPE html>
<html>
<title>Megan Knight - University of Hertfordshire - Social Media Research</title>
<body>

<h3>Megan Knight - University of Hertfordshire</h3>

<?php
// Pass session data over.
session_start();

$userid=$_GET['userid'];

//echo $userid;


?>

<form action="surveyresult.php?userid='$userid'" method="post">
<input type="hidden" name="userid" value="<?php echo($userid); ?>">
How often do you deliberately read, watch, or listen to news or current affairs (online, newspapers, radio or television)?<br>
<input type="radio" name="often" value="1"> Multiple times a day<br>
<input type="radio" name="often" value="2"> Once a day<br>
<input type="radio" name="often" value="3"> A few times a week <br>
<input type="radio" name="often" value="4"> A few times a month <br>
<input type="radio" name="often" value="5"> Never, or hardly ever <br><br>

What types of news are you interested in (click as many as apply)?<br>
<input type="checkbox" name="types1" value="1"> Politics<br>
<input type="checkbox" name="types2" value="2"> Crime and social issues<br>
<input type="checkbox" name="types3" value="3"> Celebrity news <br>
<input type="checkbox" name="types4" value="4"> Sports <br>
<input type="checkbox" name="types5" value="5"> International news <br>
<input type="checkbox" name="types6" value="6"> I am not interested in news at all <br><br>

How well informed do you think you are about current affairs?<br>
<input type="radio" name="informed" value="1"> Very well informed<br>
<input type="radio" name="informed" value="2"> Fairly well informed<br>
<input type="radio" name="informed" value="3"> Not particularly well-informed <br>
<input type="radio" name="informed" value="4"> Not at all well-informed <br><br>

Do you intend to vote in the June 8th UK General Election?<br>
<input type="radio" name="vote" value="1"> Yes<br>
<input type="radio" name="vote" value="2"> No<br>
<input type="radio" name="vote" value="3"> I have not decided yet <br>
<input type="radio" name="vote" value="4"> I am not entitled to a vote in this election <br><br>

If you do intend to vote, or if you could vote, do you know who you would vote for?<br>
<input type="radio" name="intent" value="1"> I am certain I know who I will vote for<br>
<input type="radio" name="intent" value="2"> I am fairly sure who I will vote forbr>
<input type="radio" name="intent" value="3"> I have some ideas about who I will vote for <br>
<input type="radio" name="intent" value="4"> I have no idea who I will vote for <br>
<input type="radio" name="intent" value="5"> I am not intending to vote <br><br>

<input type="submit" value="Submit">    <input type="reset" value="Reset">

 
</form></body>

</html>

