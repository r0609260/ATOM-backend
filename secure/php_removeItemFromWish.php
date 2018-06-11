<?php

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);


    $cardID = $obj['cardID'];
    $itemLocation = $obj['itemLocation'];
    $itemClassification = $obj['itemClassification'];


    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(! $conn )
    {
      die('Could not connect: ' . mysqli_connect_error());
    }

    $sql = "SELECT wishListID FROM  wishList WHERE
                  (userID_wishList = (SELECT userID FROM person WHERE cardID = '$cardID')
                   AND itemClassification_wishList ='$itemClassification'
                   AND itemLocation_wishList = '$itemLocation')";

    if ($result=mysqli_query($conn,$sql))
    {
          $row=mysqli_fetch_row($result);

          if($row[0] == NULL){
            $arr = array ('error_message'=> 8);
            echo json_encode($arr);
          }

          else{
            $id = $row[0];
            $sql = "DELETE FROM wishList WHERE wishListID = '$id' ";

            if ($conn->query($sql) === TRUE) {
                  $arr = array ('error_message'=> 0);
                  echo json_encode($arr);
            } else {
                  $arr = array('error_message' => 8);
                  echo json_encode($arr);
            }
          }
    }



    $conn->close();

?>
