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

    $duplicateWishList = "SELECT * FROM wishList
            WHERE userID_wishList = (SELECT userID FROM person WHERE cardID = '$cardID')
            AND itemClassification_wishList = '$itemClassification'
            AND itemLocation_wishList = '$itemLocation'";

    if($duplicateWishList1 = mysqli_query($conn,$duplicateWishList)){

        $row=mysqli_fetch_row($duplicateWishList1);

        if($row == NULL){
            //return 4 : the wishlist is not added
            
            $sql = "INSERT INTO wishList
                          (userID_wishList, itemClassification_wishList, itemLocation_wishList)
                          VALUES
                          ((SELECT userID FROM person WHERE cardID = '$cardID'),
                           '$itemClassification',
                           '$itemLocation')";

            if ($conn->query($sql) === TRUE) {
                  $arr = array ('error_message'=> 0);
                  echo json_encode($arr);
            } else {
                      echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        else
        {
            //return 0 : the person has already been added
            $arr = array ('error_message'=> 10); 
            echo json_encode($arr);
        }

    }





    $conn->close();

?>




