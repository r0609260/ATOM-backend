<?php 

 	$json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $itemClassification = $obj['itemClassification'];
 
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
 	$sql = "SELECT pictureUrl FROM itemPicture 
 	      WHERE itemPictureClassification = '$itemClassification'";
 
 	//getting images 
 	$result = mysqli_query($conn,$sql);
 
	$row = mysqli_fetch_array($result);

	$arr = array ('pictureUrl'=> $row[0]); 
    echo json_encode($arr);

    $conn->close();

 ?>