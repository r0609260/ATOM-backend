<?php
    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $itemTag = $obj['itemTag'];

    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(! $conn )
    {
      die('Could not connect: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM item
            WHERE itemTag = '$itemTag'";

    if ($result=mysqli_query($conn,$sql))
    {
        $row=mysqli_fetch_row($result);

        if($row[0] == NULL){
            //the person is not existing
            $arr =array('error_message'=> 4) ;
            echo json_encode($arr);
        }
        else{
            $arr = array ('error_message'=> 0,'itemLocation'=>$row[2],'itemStatus'=>$row[4],'itemClassification'=>$row[5],'itemPermission'=>$row[6]);
            echo json_encode($arr);
        }

        // Free result set
        mysqli_free_result($result);

    }

    $conn->close();
?>
