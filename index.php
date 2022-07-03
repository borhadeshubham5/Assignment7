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
            session_destroy();
            ini_set('session.gc_max_lifetime', 0);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
            header("Location: index.php"); 
        }
        else
        {
            $avg=$sum/$ques;
            $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span> Student's final score is $sum and average is $avg.<br></div>";
            file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
            session_destroy();
            ini_set('session.gc_max_lifetime', 0);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
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
            echo "<p id='timer2' name='htimer'></p>";
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
                    <a id='timer1' href='#'>Start Timer</a></p>";
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
        </div></center>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
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
 
                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
                $("#timer1").click(function () 
                {
                    var minutesLabel = document.getElementById("minutes");
                    var secondsLabel = document.getElementById("seconds");
                    var timer1 = document.getElementById("timer1");
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
                        setvaluest();
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
            });
        </script>
    </body>
</html>
<?php
}
?>
