<?php
session_start();
// connecting to database
$conn = mysqli_connect("localhost", "root", "", "bot") or die("Database Error");

// getting user message through ajax
$getMesg = mysqli_real_escape_string($conn, $_POST['text']);
$getAnswer = mysqli_real_escape_string($conn, $_POST['answer']);
$msg = $getMesg;
$answer = $getAnswer;
$user_id = $_SESSION['user_id'];

if($answer != "")
{
	$query_id = intval($msg) - 1;
	$reply_id = $answer;
	$date_created = date('Y-m-d H:i:s');
	$sql = "INSERT INTO user_response (user_id, query_id, reply_id, date_created) VALUES ('$user_id', '$query_id', '$reply_id', '$date_created')";
	$run_sql = mysqli_query($conn, $sql) or die("Error");
}

if($msg >= 10)
{
	//do the calculation
	$get_data = "SELECT replies.reply_value, user_response.user_id, user_response.query_id FROM user_response LEFT JOIN replies ON user_response.reply_id = replies.id WHERE user_response.user_id =" . $user_id;
	$get_query = mysqli_query($conn, $get_data) or die("Error");
	$reply_sum = 0;
	while ($row = mysqli_fetch_assoc($get_query)) {
	    $reply_sum += intval($row['reply_value']);
	    $ques[$row['query_id']] = intval($row['reply_value']);
	}
	$result = getResult($reply_sum, $ques);
	echo $result;
}
else
{
	//checking user query to database query
	$check_data = "SELECT query FROM chatbot WHERE id =" . $msg;
	$run_query = mysqli_query($conn, $check_data) or die("Error");

	// if user query matched to database query we'll show the reply otherwise it go to else statement
	if(mysqli_num_rows($run_query) > 0){
	    //fetching replay from the database according to the user query
	    $fetch_data = mysqli_fetch_assoc($run_query);
	    //storing replay to a varible which we'll send to ajax
	    $replay = $fetch_data['query'];
	    echo $replay;
	}else{
	    echo "Sorry can't be able to understand you!";
	}
}

function getResult($value, $ques)
{
	$vote['CBT'] = 0;
	$vote['BT'] = 0;
	$vote['MT'] = 0;
	$vote['DBT'] = 0;
	$vote['IPT'] = 0;
	if($value <= 4)
	{
		$res = "Based on your responses today, you have No Depression";
	}
	else if($value > 4 && $value <= 9)
	{
		$res = "Based on your responses today, it is possible that you could be suffering from a mild form of depression.|Kindly retake the test every 2 weeks.";
	}
	else if($value > 9 && $value <= 14)
	{
		$from_where = " or PT";
		foreach ($ques as $question => $answer) {
			$sug = getSuggestion($question, $answer);
			if($sug != "")
			{
				$vote[$sug] += 1;
			}
		}
		$max_value = max($vote);
		$max_value_key = array_search($max_value, $vote);
		$sugestion = "I suggest you go for " . $max_value_key . $from_where;
		$res = "Based on your responses today, it is possible that you could be suffering from a moderate form of depression.|" . $sugestion;
	}
	else if($value > 14 && $value <= 19)
	{
		$from_where = " or PT";
		foreach ($ques as $question => $answer) {
			$sug = getSuggestion($question, $answer);
			if($sug != "")
			{
				$vote[$sug] += 1;
			}
		}
		$max_value = max($vote);
		$max_value_key = array_search($max_value, $vote);
		$sugestion = "I suggest you go for " . $max_value_key . $from_where;
		$res = "Based on your responses today, it is possible that you could be suffering from a moderately severe form of depression.|" . $sugestion;
	}
	else if($value > 19 && $value <= 27)
	{
		$from_where = " and PT";
		foreach ($ques as $question => $answer) {
			$sug = getSuggestion($question, $answer);
			if($sug != "")
			{
				$vote[$sug] += 1;
			}
		}
		$max_value = max($vote);
		$max_value_key = array_search($max_value, $vote);
		$sugestion = "I suggest you go for " . $max_value_key . $from_where;
		$from_where = " and ";
		$res = "Based on your responses today, it is possible that you could be suffering from a severe form of depression.|" . $sugestion;
	}
	else
	{
		$res = "No Result Found";
	}

	return $res;
}

function getSuggestion($question, $answer)
{
	$xresult = "";
	if($question == 1 && $answer > 1)
	{
		$xresult = "CBT";
	}
	else if($question == 2 && $answer > 1)
	{
		$xresult = "CBT";
	}
	else if($question == 3 && $answer > 1)
	{
		$xresult = "BT";
	}
	else if($question == 4 && $answer > 1)
	{
		$xresult = "MT";
	}
	else if($question == 5 && $answer > 1)
	{
		$xresult = "DBT";
	}
	else if($question == 6 && $answer > 1)
	{
		$xresult = "IPT";
	}
	else if($question == 7 && $answer > 1)
	{
		$xresult = "DBT";
	}
	else if($question == 8 && $answer > 1)
	{
		$xresult = "BT";
	}
	else if($question == 9 && $answer > 1)
	{
		$xresult = "DBT";
	}

	return $xresult;
}
?>