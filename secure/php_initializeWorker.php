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

   $sql_overview="SELECT itemClassification, itemLocation, count(*), itemStatus
           FROM item
           GROUP BY itemClassification, itemLocation, itemStatus";

    if ($result_overview=mysqli_query($conn,$sql_overview))
    {
        $array['overview'] = array();
        // Fetch one and one row
        while ($row_overview=mysqli_fetch_row($result_overview))
        {
             $array['overview'][] = array ('itemClassification'=>$row_overview[0],'itemLocation'=>$row_overview[1],'quantity'=>$row_overview[2], 'itemStatus'=>$row_overview[3]);
        }
        mysqli_free_result($result_overview);
    }

    $sql_expire = "SELECT userID_borrow,itemID_borrow,TIMESTAMPDIFF(DAY,borrowTimestamp,now()),borrowTimestamp, borrowLocation FROM userBorrowItem
            WHERE borrowstate = 'borrowing'";


    if($result_expire = mysqli_query($conn,$sql_expire)){

        $array['expire'] = array();

        while ($row_expire = mysqli_fetch_row($result_expire)){

            $sqlGetUserPermission = "SELECT userType,userName,kuleuvenID,email,preferedEmail FROM person where userID = '$row_expire[0]'";
            $result_sqlGetUserPermission = mysqli_query($conn,$sqlGetUserPermission);
            $row_sqlGetUserPermission=mysqli_fetch_row($result_sqlGetUserPermission);

            $sqlGetItemClassification = "SELECT itemClassification,itemTag FROM item where itemID = '$row_expire[1]'";
            $result_GetItemClassification = mysqli_query($conn,$sqlGetItemClassification);
            $row_GetItemClassification=mysqli_fetch_row($result_GetItemClassification);

            $sqlExpiration = "SELECT permissionDay FROM permissionRelation
                            WHERE permissionUserType = '$row_sqlGetUserPermission[0]'
                            AND permissionItemClassification = '$row_GetItemClassification[0]'";
            $result_sqlExpiration = mysqli_query($conn,$sqlExpiration);
            $row_sqlExpiration=mysqli_fetch_row($result_sqlExpiration);

            if($row_expire[2] > $row_sqlExpiration[0]){
                 $array['expire'][] = array('userID'=>$row_expire[0],'itemID'=>$row_expire[1],'timeInterval'=>$row_expire[2],'borrowTimestamp'=>$row_expire[3],
                    'borrowLocation'=>$row_expire[4], 'itemTag'=>$row_GetItemClassification[1],'itemClassification'=>$row_GetItemClassification[0],
                    'userType'=>$row_sqlGetUserPermission[0],'userName'=>$row_sqlGetUserPermission[1],'kuleuvenID'=>$row_sqlGetUserPermission[2],
                    'email'=>$row_sqlGetUserPermission[3],'preferedEmail'=>$row_sqlGetUserPermission[4]);
            }

        }
      }
    echo json_encode($array);


    mysqli_close($conn);
    // echo 'Connected successfully';
?>
