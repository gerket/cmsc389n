<?php

function generatePage($body) {
    $page = <<<EOPAGE
<!doctype html>
<html>    
    <body>
            $body
    </body>
</html>
EOPAGE;

    return $page;
}

function connectToDB($host, $user, $password, $database) {
	$db = mysqli_connect($host, $user, $password, $database);
	if (mysqli_connect_errno()) {
		echo "Connect failed.\n".mysqli_connect_error();
		exit();
	}
	return $db;
}
?>