<?php session_start(); 
if(!isset($_SESSION['username']))
{
    header('location: index.php');
    exit();
}
// connecting to database
$conn = mysqli_connect("localhost", "root", "", "bot") or die("Database Error");
//checking user query to database query
$check_data = "SELECT * FROM replies";
$run_query = mysqli_query($conn, $check_data) or die("Error");
while ($row = mysqli_fetch_assoc($run_query)) {
    $option[] = $row['name'];
    $option_value[] = $row['id'];
}

//check for daytime
$hour = date('H');
$greet = ($hour > 17) ? "Good Evening" : (($hour > 12) ? "Good Afternoon" : "Good Morning");
$bye = ($greet == "Good Evening") ? "Good night" : (($greet == "Good Afternoon") ? "Enjoy your day" : "Have a great day");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software for Depresion Management | Fatai Azeezat</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
        function speak(word) {
          speechSynthesis.speak(new SpeechSynthesisUtterance(word));
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="title">TheraBot</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-zee"></i>
                </div>
                <div class="msg-header">
                    <p><?php echo $greet; ?> <?php echo $_SESSION['username']; ?>, I'm Therabot.</p>
                </div>
            </div>
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-zee"></i>
                </div>
                <div class="msg-header">
                    <p>Kindly answer the following questions, so we can determine your depresion severity level today.</p>
                </div>
            </div>
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-zee"></i>
                </div>
                <div class="msg-header">
                    <p>Would you like to proceed?</p>
                </div>
            </div>
            <br /><center>
            <div class="bot-inbox inbox" style="float: left; padding: 20px; width: 50px;">
                <div class="msg-header">
                    <a href="javascript:void(0);" onclick="return yesResponse();" style="text-decoration: none;"><p style="width: 70px;">Yes</p></a>
                </div>
            </div>
            <div class="bot-inbox inbox" style="padding: 20px; width: 50px; margin-left: 50px;">
                <div class="msg-header">
                    <a href="javascript:void(0);" onclick="return noResponse();" style="text-decoration: none;"><p style="width: 70px;">No</p></a>
                </div>
            </div>
            </center>
        </div>
        <a href="index.php">Try Again</a>
    </div>

    <script>
        var stage;
        var bye = "<?php echo $bye; ?>";
        function noResponse()
        {
            if(stage == "YES" || stage == "FINISH")
            {
                return false;
            }
            stage = 'NO';
            $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>No</p></div></div>';
            $(".form").append($msg);
            $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-zee"></i></div><div class="msg-header"><p>Thank you for using Therabot. See you next time! ' + bye + '.</p></div></div>';
            $(".form").append($replay);
            $(".form").scrollTop($(".form")[0].scrollHeight);
            stage = "FINISH";
        }
        var q = 1;
        function yesResponse()
        {
            if(stage == "NO" || stage == "FINISH")
            {
                return false;
            }
            stage = "YES";
            $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>Yes</p></div></div>';
            $(".form").append($msg);
            $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-zee"></i></div><div class="msg-header"><p>Over the last two weeks, how often have you been bothered by any of the following problems?</p></div></div>';
            $(".form").append($replay);
            response(q);
            $(".form").scrollTop($(".form")[0].scrollHeight);
        }
        function response(value, option_text_id = '', option_value = '')
        {
            if(stage == "FINISH")
            {
                return false;
            }
            q += 1;
            $opt1 = "<?php echo $option[0]; ?>";
            $opt2 = "<?php echo $option[1]; ?>";
            $opt3 = "<?php echo $option[2]; ?>";
            $opt4 = "<?php echo $option[3]; ?>";
            $opt_value1 = "<?php echo $option_value[0]; ?>";
            $opt_value2 = "<?php echo $option_value[1]; ?>";
            $opt_value3 = "<?php echo $option_value[2]; ?>";
            $opt_value4 = "<?php echo $option_value[3]; ?>";
            $.ajax({
                url: 'message.php',
                type: 'POST',
                data: 'text='+ value + '&answer=' + option_value,
                success: function(result){
                    if(q > 10)
                    {
                        stage = "FINISH";
                        all_result = result.split('|');
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-zee"></i></div><div class="msg-header"><p>Hi dear, '+ all_result[0] +'</p></div></div>';
                        $(".form").append($replay);
                        if(all_result[1] != "")
                        {
                            $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-zee"></i></div><div class="msg-header"><p>'+ all_result[1] +'</p></div></div>';
                            $(".form").append($replay);
                        }
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-zee"></i></div><div class="msg-header"><p>Thank you for using TheraBot, ' + bye + '.</p></div></div>';
                        $(".form").append($replay);
                    }
                    else
                    {
                        if(option_text_id !== '')
                        {
                            if(option_text_id == 1){ option_text = $opt1; }
                            if(option_text_id == 2){ option_text = $opt2; }
                            if(option_text_id == 3){ option_text = $opt3; }
                            if(option_text_id == 4){ option_text = $opt4; }
                            $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>' + option_text + '</p></div></div>';
                            $(".form").append($msg);
                        }

                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-zee"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        $answer = '<br /><center><div class="bot-inbox inbox" style="float: left; padding: 20px; width: 50px;"><div class="msg-header"><a href="javascript:void(0);" onclick="return response(' + q + ',1,' + $opt_value1 + ');" style="text-decoration: none;"><p style="width: 90px;">' + $opt1 + '</p></a></div></div>';
                        $answer += '<div class="bot-inbox inbox" style="padding: 20px; width: 50px; margin-left: 50px;"><div class="msg-header"><a href="javascript:void(0);" onclick="return response(' + q + ',2,' + $opt_value2 + ');" style="text-decoration: none;"><p style="width: 120px;">' + $opt2 + '</p></a></div></div></center>';
                        $answer += '<center><div class="bot-inbox inbox" style="float: left; padding: 20px; width: 50px;"><div class="msg-header"><a href="javascript:void(0);" onclick="return response(' + q + ',3,' + $opt_value3 + ');" style="text-decoration: none;"><p style="width: 200px;">' + $opt3 + '</p></a></div></div>';
                        $answer += '<div class="bot-inbox inbox" style="padding: 20px; width: 50px; margin-left: 50px;"><div class="msg-header"><a href="javascript:void(0);" onclick="return response(' + q + ',4,' + $opt_value4 + ');" style="text-decoration: none;"><p style="width: 150px;">' + $opt4 + '</p></a></div></div></center>';
                        $(".form").append($answer);
                    }
                    // when chat goes down the scroll bar automatically comes to the bottom
                    $(".form").scrollTop($(".form")[0].scrollHeight);
                }
            });
        }
        $(document).ready(function(){
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                // start ajax code
                $.ajax({
                    url: 'message.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-zee"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>
    
</body>
</html>