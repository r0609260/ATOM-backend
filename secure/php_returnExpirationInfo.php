<?php

    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(! $conn )
    {
      die('Could not connect: ' . mysqli_connect_error());
    }

    $sql = "SELECT userID_borrow,itemID_borrow,TIMESTAMPDIFF(DAY,borrowTimestamp,now()),borrowTimestamp, borrowLocation FROM userBorrowItem
            WHERE borrowstate = 'borrowing'";


    if($result = mysqli_query($conn,$sql)){

        $array['list'] = array();

        while ($row=mysqli_fetch_row($result)){

            $sqlGetUserPermission = "SELECT userType,userName,kuleuvenID,email,preferedEmail FROM person where userID = '$row[0]'";
            $result_sqlGetUserPermission = mysqli_query($conn,$sqlGetUserPermission);
            $row_sqlGetUserPermission=mysqli_fetch_row($result_sqlGetUserPermission);

            $sqlGetItemClassification = "SELECT itemClassification,itemTag FROM item where itemID = '$row[1]'";
            $result_GetItemClassification = mysqli_query($conn,$sqlGetItemClassification);
            $row_GetItemClassification=mysqli_fetch_row($result_GetItemClassification);

            $sqlExpiration = "SELECT permissionDay FROM permissionRelation
                            WHERE permissionUserType = '$row_sqlGetUserPermission[0]'
                            AND permissionItemClassification = '$row_GetItemClassification[0]'";
            $result_sqlExpiration = mysqli_query($conn,$sqlExpiration);
            $row_sqlExpiration=mysqli_fetch_row($result_sqlExpiration);

            if($row[2] > $row_sqlExpiration[0]){
                 $array['list'][] = array('userID'=>$row[0],'itemID'=>$row[1],'timeInterval'=>$row[2],'borrowTimestamp'=>$row[3],
                    'borrowLocation'=>$row[4], 'itemTag'=>$row_GetItemClassification[1],'itemClassification'=>$row_GetItemClassification[0],
                    'userType'=>$row_sqlGetUserPermission[0],'userName'=>$row_sqlGetUserPermission[1],'kuleuvenID'=>$row_sqlGetUserPermission[2],
                    'email'=>$row_sqlGetUserPermission[3],'preferedEmail'=>$row_sqlGetUserPermission[4]);
            }

        }
        echo json_encode($array);
        // Free result set
        mysqli_free_result($result);

    }

    $conn->close();

?>
