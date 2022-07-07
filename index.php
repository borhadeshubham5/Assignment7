<?php
session_start();
if(isset($_GET['logout']))
{
    $sum=$_SESSION['sum'];
    $ques=$_SESSION['ques'];
    $sname=$_SESSION['name'];
    if($sname=='Teacher')
    {
        if($ques==0)
        {
            $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span> Student's final score is 0 and average is 0.<br></div>";
            file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
            $myfile = fopen("test.txt", "w") or die("Unable to open file!");
            fwrite($myfile, "00:00");
            fclose($myfile);
            session_destroy();
            header("Location: index.php"); 
        }
        else
        {
            $avg=$sum/$ques;
            $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span> Student's final score is $sum and average is $avg.<br></div>";
            file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
            $myfile = fopen("test.txt", "w") or die("Unable to open file!");
            fwrite($myfile, "00:00");
            fclose($myfile);
            session_destroy();
            header("Location: index.php"); 
        }
    }
    else if($sname=='Admin')
    {
        if($ques==0)
        {
            $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span> Student's final score is 0 and average is 0.<br></div>";
            file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
            session_destroy();
            header("Location: index.php"); 
        }
        else
        {
            $avg=$sum/$ques;
            $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span> Student's final score is $sum and average is $avg.<br></div>";
            file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
            session_destroy();
            header("Location: index.php"); 
        }
    }
    else if($sname=='Student')
    {
        if($ques==0)
        {
            $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span> Student's final score is 0 and average is 0.<br></div>";
            file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
            session_destroy();
            header("Location: index.php"); 
            file_put_contents("log.html","");
        }
        else
        {
            $avg=$sum/$ques;
            $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span> Student's final score is $sum and average is $avg.<br></div>";
            file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
            session_destroy();
            header("Location: index.php"); 
            file_put_contents("log.html","");
        }
    }
}
if(isset($_POST['enter'])){
    if($_POST['name'] != "")
    {
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else
    {
        echo '<span class="error">Please type in a name</span>';
    }
}
function loginForm()
{
    echo
    '<center><div id="loginform">
    <p>Please enter your name to continue!</p>
    <form action="index.php" method="post">
      <input type="text" name="name" id="name" placeholder="Name"/>
      <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
  </div></center>';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Assignment 7</title>
        <meta name="description" content="Assignment 7" />
        <link rel="stylesheet" href="style.css" />
    </head>
    <body> <center><h2>Shubham Subhash Borhade | 1001994235 | CSE6331 Advanced Database Systems | Assignment 7</h2></center><br><br>
    <center><h3><label id="minutes" hidden>00</label><label id="seconds" hidden>00</label></h3></center>
    <?php
    if(!isset($_SESSION['name']))
    {
        loginForm();
    }
    else 
    {
    ?>
    <script>
        function setvaluest()
        {
            var testVar = window.stored_value;
            var timer3 = document.getElementById("timer3");  
            timer3.innerHTML=testVar;
        }
    </script>
    <center>
        <?php
            echo "<p id='timer2' name='htimer' hidden></p>";
        ?>
         <?php
            echo "<p id='timer5' name='htimer'></p>";
        ?>
        <p id='timer3' name='htimers'></p>
        <div id="wrapper">
            <div id="menu">
                <?php
                $sname= $_SESSION['name'];
                if($sname=='Teacher')
                {
                    echo "<p class='welcome'>Welcome, <b> $sname</b></p>";
                    echo "<p class='logout'><a id='exit' href='#'>Exit Chat</a> &nbsp; 
                    <a id='timer1' href='#'>Start Timer</a> &nbsp;
                    <select name='minutes1' id='minutes1'>
                    <option value='minutes'>Minutes</option>
                    <option value='00'>00</option>
                    <option value='01'>01</option>
                    <option value='02'>02</option>
                    <option value='03'>03</option>
                    <option value='04'>04</option>
                    <option value='05'>05</option>
                    </select><select name='seconds1' id='seconds1'>
                    <option value='Seconds'>Seconds</option>
                    <option value='00'>00</option>
                    <option value='10'>10</option>
                    <option value='20'>20</option>
                    <option value='30'>30</option>
                    <option value='40'>40</option>
                    <option value='50'>50</option>
                    <option value='59'>59</option>
                    </select></p>";
                    //echo "<p id='timer2'></p>";
                }
                else
                {
                    echo "<p class='welcome'>Welcome, <b> $sname</b></p>";
                    echo "<p class='logout'><a id='exit' href='#'>Exit Chat</a></p>";
                }
                ?>  
            </div>
            <div id="chatbox">
            <?php
            if(file_exists("log.html") && filesize("log.html") > 0)
            {
                $contents = file_get_contents("log.html");          
                echo $contents;
            }
            ?>
            </div>
            <div>
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
            </div>
        </div>
    </center>
    <br>
    <div id="setv" hidden> </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                loadDoc();
                setInterval( loadDoc, 1000);
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg});
                    $("#usermsg").val("");
                    return false;
                });
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
 
                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div
 
                            //Auto-scroll           
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            }   
                        }
                    });
                }
                setInterval (loadLog, 2500);
            function loadDoc() 
            {
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() 
                {
                    document.getElementById("timer5").innerHTML = this.responseText;
                }
                xhttp.open("GET", "test.txt", true);
                xhttp.send();
            }
                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
            });
            $("#timer1").click(function () 
                {
                    var minutesLabel = document.getElementById("minutes");
                    var secondsLabel = document.getElementById("seconds");
                    var timer1 = document.getElementById("timer1");
                    var get = $("#minutes1").val();
                    var setv = document.getElementById("setv");
                    setv.innerHTML=get;
                    var x = document.getElementById('minutes1');
                    x.style.display = 'none';
                    var x = document.getElementById('seconds1');
                    x.style.display = 'none';
                    var totalSeconds = 0;
                    setInterval(setTime, 1000);
                    function setTime() 
                    {
                        ++totalSeconds;
                        secondsLabel.innerHTML = pad(totalSeconds % 60);
                        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
                        timer1.innerHTML="";
                        var ftxt= pad(parseInt(totalSeconds / 60)) +":"+ pad(totalSeconds % 60);
                        var timer2 = document.getElementById("timer2");
                        timer2.innerHTML=ftxt;
                        window.stored_value = ftxt;
                        //var get1 = $("#setv").val();
                        var get12 = $("#minutes1").val();
                        var get13 = $("#seconds1").val();
                        var mymins=ftxt.substring(0,2);
                        var mysecs=ftxt.substring(3,5);
                        if(get12==mymins && get13==mysecs)
                        {
                            var setv = document.getElementById("setv");
                            setv.innerHTML="in if";
                            var x1 = document.getElementById('timer5');
                            x1.style.display = 'none';
                            var x2 = document.getElementById('submitmsg');
                            x2.style.display = 'none';
                            var x3 = document.getElementById('usermsg');
                            var msg="Your session has ended!";
                            x3.style.display = 'none';
                            alert(msg);
                        }
                        else
                        {
                            var setv = document.getElementById("setv");
                            setv.innerHTML="in else";
                            $.ajax({
                            type: 'POST',
                            url: 'timers.php',
                            data: {'variable': ftxt},
                            });
                        }
                        
                        //setvaluest();
                    }
                    function pad(val) 
                    {
                        var valString = val + "";
                        if (valString.length < 2) 
                        {
                            return "0" + valString;
                        } 
                        else 
                        {
                            return valString;
                        }
                    }    
                    });
        </script>
    </body>
</html>
<?php
}
?>