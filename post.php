<?php
$sum=0;
$ques=0;
session_start();
date_default_timezone_set("America/Chicago");
if(isset($_SESSION['name']))
{
    $sname=$_SESSION['name'];
    if($sname=='Teacher')
    {
        $text = $_POST['text'];
        if (is_numeric($text))
        {
            $ans1 = (int)$text;
            $ans2 =(int)$_SESSION['sum'];
            $ques1=(int)$_SESSION['ques'];
            $sum=$ans1 + $ans2;
            $ques=$ques1 + 1;
            $avg=$sum/$ques;
            $_SESSION['sum']=$sum;
            $_SESSION['ques']=$ques;
            $full_message = "Score is $text Total: $sum Average: $avg";
            $text_message = "<div class='msgln'><span class='chat-time'>".date("h:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($full_message))."<br></div>";
            file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
        }
        else
        {
            $text_message = "<div class='msgln'><span class='chat-time'>".date("h:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
            file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
        }
    }
    else if($sname=='Student')
    {
        $text = $_POST['text'];
        $text_message = "<div class='msgln'><span class='chat-time'>".date("h:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
        file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
    }
    else if($sname=='Admin')
    {
        $text = $_POST['text'];
        $text_message = "<div class='msgln'><span class='chat-time'>".date("h:i A")."</span> <b class='user-name'>".$_SESSION['name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
        file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
    }  
}
?>