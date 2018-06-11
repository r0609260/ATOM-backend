<?php

	$json = file_get_contents('php://input');
  $obj = json_decode($json,true);

  $cardID = $obj['cardID'];
  $kuleuvenID = $obj['kuleuvenID'];


  $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
  $dbuser = 'inventorydb';      //mysql用户名
  $dbpass = 'inventorydb';//mysql用户名密码
  $dbname = 'inventorydb';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

	if(! $conn )
	{
		die('Could not connect: ' . mysqli_connect_error());
	}


	$removeFromBlacklist = "UPDATE 'inventorydb'.'person' SET 'state'='normal' WHERE 'cardID' = '$cardID'";
	if ($conn->query($removeFromBlacklist) === TRUE) {

			$arr = array ('error_message'=> 0);
			echo json_encode($arr);

	} else {
			echo "Error: " . $sql_return . "<br>" . $conn->error;
	}

	mysqli_close($conn);
?>

	
