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

    $sql_state="SELECT itemStatus from item
        WHERE itemTag = '$itemTag'";

    $result_state = mysqli_query($conn,$sql_state);
    $row_state=mysqli_fetch_row($result_state);

    if($row_state[0] == 'available'){

		$sql = "UPDATE  item
        SET itemStatus = 'maintaining'
        WHERE itemTag = '$itemTag'";

    }
    else if($row_state[0] == 'maintaining'){

		$sql = "UPDATE  item
        SET itemStatus = 'available'
        WHERE itemTag = '$itemTag'";

    }

    if ($conn->query($sql) === TRUE) {

        $arr = array ('error_message'=> 0); 
        echo json_encode($arr);
                
    } else {
        echo "Error: " . $sql_return . "<br>" . $conn->error;
    }

    mysqli_close($conn);
?>


