<?php

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $cardID = $obj['cardID'];
    $itemTag = $obj['itemTag'];
    $borrowLocation = $obj['borrowLocation'];

    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(! $conn )
    {
        die('Could not connect: ' . mysqli_connect_error());
    }

    $duplicate_borrow = "SELECT * FROM userBorrowItem
                            WHERE itemID_borrow = (SELECT itemID FROM item WHERE itemTag = '$itemTag')
                            AND borrowState = 'Borrowing'";



    if($duplicate_borrow1 = mysqli_query($conn,$duplicate_borrow)){

        $row=mysqli_fetch_row($duplicate_borrow1);

        //OK: No duplicate items
        if($row == NULL){

            $sql = "INSERT INTO userBorrowItem
                    (userID_borrow, itemID_borrow, borrowState,borrowLocation)
                    VALUES
                    ((SELECT userID FROM person WHERE cardID = '$cardID'),
                     (SELECT itemID FROM item WHERE itemTag = '$itemTag'),
                     'Borrowing','$borrowLocation')";

            $sql2 = "UPDATE item
                    SET itemStatus = 'borrowing'
                    WHERE itemTag = '$itemTag'";

            if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
              $sql3 = "SELECT itemClassification from item WHERE itemTag = '$itemTag'";
              if($result_class = mysqli_query($conn,$sql3)){
                      $row_class = mysqli_fetch_row($result_class);
                      if($row_class != NULL){
                        $arr = array ('error_message'=> 0, 'itemTag'=>$itemTag, 'itemLocation'=>$borrowLocation, 'itemClassification'=>$row_class[0]);
                      }
                      else {
                          $arr = array ('error_message'=> 0, 'itemTag'=>$itemTag, 'itemLocation'=>$borrowLocation, 'itemClassification'=>'unknown type');
                      }
              }

              echo json_encode($arr);
            } else {
                // echo "Error: " . $sql . "<br>" . $conn->error;
                $arr = array ('error_message'=> 20);

                echo json_encode($arr);

            }
        }

        else
        {
            //return 6 : the item has already been borrowed
            $arr = array ('error_message'=> 6);
            echo json_encode($arr);
        }

    }


    $conn->close();
?>
