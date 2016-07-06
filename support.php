<?php

function generatePage($body, $title="CS Class Discussion") {
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="login.css" />
        <title>$title</title>	
    </head>
            
    <body>
            $body
    </body>
</html>
EOPAGE;

    return $page;
}
?>