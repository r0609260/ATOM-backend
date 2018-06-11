<?php

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $kuleuvenID = $obj['kuleuvenID'];
    $cardID = $obj['cardID'];
    $email = $obj['email'];
    $userType = $obj['userType'];
    $userName = $obj['userName'];

    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(! $conn )
    {
      die('Could not connect: ' . mysqli_connect_error());
    }


    $duplicatePerson = "SELECT * FROM person
                        WHERE cardID = '$cardID'";


    if($duplicatePerson1 = mysqli_query($conn,$duplicatePerson)){

        $row=mysqli_fetch_row($duplicatePerson1);

        //OK: No duplicate person
        if($row == NULL){

            $sql = "INSERT INTO person
                 (kuleuvenID, cardID, email, userType,userName, state)
                  VALUES
                 ('$kuleuvenID','$cardID','$email','$userType','$userName', 'normal')";


            if ($conn->query($sql) === TRUE) {
                $arr = array ('error_message'=> 0);
                echo json_encode($arr);
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }

        }

        else
        {
            //return 3 : the person has already been added
            $arr = array ('error_message'=> 3);
            echo json_encode($arr);
        }

    }

    $conn->close();

?>
