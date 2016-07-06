<!doctype html>
<html>
    <head> 
        <meta charset=UTF-8" /> 
		<title>CMSC389N</title>
        <link rel="stylesheet" href="classPage.css" />
		<script src="classPage.js"></script>
	</head>
</html>

<?php
    require_once("support.php");
    session_start();

    $body = "";
    $mtable = "";
    $newid;

    $host = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "groupproject";

    $db = connectToDB($host, $user, $password, $database);

    $query = "select * from messages where class = 'CMSC389N'"; 
    $q2 = "select * from users"; 

    $result = $db->query($query);
    $r2 = $db->query($q2);

    if (!$result) {
        die("Retrieval failed: ". $db->error);
    } 
    else {
        $numberOfRows = mysqli_num_rows($result);

        if ($numberOfRows == 0) {
            $body .= "<h2>No messages in this discussion</h2>";

        } 
        else {
            $newid = $numberOfRows + 1;
            $mtable .= "<table align='center' border='1' cellpadding='40' width='1000'>";

            while ($mArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $id = $mArray['id'];
                $username = $mArray['username'];
                $message = $mArray['message'];

                $mtable .= "<tr><td><br/><br/>#$id $username<br/><br/><br/></td> <td><br/><br/>$message<br/><br/><br/></td></tr>"; //profile pic?????
            }

            $mtable .= "</table>";
        }
    }

    $result->close();








    if(isset($_POST["submitbutton"])) {
        $curruser = "joe";//$_SESSION['username']; may need to change based on what the session var is actually stored as 
        $currclass = "CMSC389N";
        //$ftype = $_FILES['filename']['type'];

        $poop = $_POST["yourmessage"];

        //$sqlQuery = sprintf("insert into messages (class, id, username, message, fileName, fileMimeType, fileData) values (%s, %d, %s, %s, %s,%s,%s)", 
                     //$currclass, $newid, $curruser, $poop, "NULL", "NULL", "NULL"); //filedata????????????????

        $sqlq = "insert into messages values(\"".($currclass).("\", \"").($newid).("\", \"").($curruser).("\", \"").($poop).("\", null").(", null").(", null").(")");



        $res = $db->query($sqlq);


        if(!$res) {
            die("insert failed: " . $db->error);
        }
        mysqli_close($db);

        //send username and message to database

        $_SESSION["blob"] = $sqlQuery;



        header("Location: submitmessage389N.php");
    } 
    else {
        $themessage = "";
        $fname = NULL;
    }

    $scriptName = $_SERVER["PHP_SELF"];
    $topPart = <<<EOBODY
        <form action="$scriptName" method="post">
            <h1><u>CMSC389N</u></h1> 
            <br/>

            $mtable
            <br/><br/>

            <textarea name="yourmessage" value="$themessage" rows="8" cols="100"></textarea> 
            <br/>

            <br/>
        
            <p id = "fsbuttons"> 
                <input type="file" name="filename" value="$fname"/> 
                <input type="submit" name="submitbutton" value="Submit"/> 
            </p>
        </form>
EOBODY;

    $body = $topPart.$body; 
    
    $page = generatePage($body);

    echo $page;        
?>