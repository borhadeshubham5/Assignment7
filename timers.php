<html>
    <head>
    </head>
    <body>
        <?php
            //include_once "index.php";
            $myval = $_POST['variable'];
            $myfile = fopen("test.txt", "w") or die("Unable to open file!");
            fwrite($myfile, $myval);
            fclose($myfile);
            //func1();
        ?>
    </body>
</html>