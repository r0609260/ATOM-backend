<?php

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $cardID = $obj['cardID'];
    $preferedEmail = $obj['preferedEmail'];


    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(! $conn )
    {
      die('Could not connect: ' . mysqli_connect_error());
    }

    $sql = "UPDATE  person
        SET perferedEmail = '$preferedEmail'
        WHERE cardID = '$cardID'";
        if ($conn->query($sql) === TRUE) {

            $arr = array ('error_message'=> 0);
            echo json_encode($arr);

        } else {
            echo "Error: " . $sql_return . "<br>" . $conn->error;
        }


    $conn->close();

?>
