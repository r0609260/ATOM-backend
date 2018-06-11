<?php 
 
    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

 	//connection to database 
    if(! $conn )
    {
       die('Could not connect: ' . mysqli_connect_error());
    }
 
 	//sql query to fetch all images 
 	$sql = "SELECT COUNT(*) FROM itemPicture;";
 
 	//getting images 
 	$result = mysqli_query($conn,$sql);
 
	$row = mysqli_fetch_array($result);

	$arr = array ('pictureNumber'=> $row[0]); 
    echo json_encode($arr);

    $conn->close();

 ?>