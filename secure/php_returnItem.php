<?php

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $cardID = $obj['cardID'];
    $itemTag = $obj['itemTag'];
    $returnLocation = $obj['returnLocation'];
    $blacklist = $obj['blacklist'];

    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(! $conn )
    {
        die('Could not connect: ' . mysqli_connect_error());
    }

    $borrowTimeStamp_MAX = "SELECT MAX(borrowTimeStamp) FROM userBorrowItem
                                           WHERE borrowState = 'Borrowing'
                                           AND userID_borrow = (SELECT userID FROM person WHERE cardID = '$cardID')
                                           AND itemID_borrow = (SELECT itemID FROM item WHERE itemTag = '$itemTag')";

    if($borrowTimeStamp_MAX1 = mysqli_query($conn,$borrowTimeStamp_MAX)){

        $row = mysqli_fetch_row($borrowTimeStamp_MAX1);

        if($row[0] == NULL){
             //return 1 : the item has already been returned
            $arr = array ('error_message'=> 1);
            echo json_encode($arr);
        }

        else{

            $borrowTimeStamp_MAX2 = $row[0];

            $sql_return = "UPDATE userBorrowItem
                    SET returnLocation = '$returnLocation', returnTimestamp= now(),borrowState='Returned'
                    WHERE borrowState = 'Borrowing'
                    AND borrowTimeStamp = '$borrowTimeStamp_MAX2'
                    AND userID_borrow = (SELECT userID FROM person WHERE cardID = '$cardID')
                    AND itemID_borrow = (SELECT itemID FROM item WHERE itemTag = '$itemTag')";

            $sql_blacklist = "UPDATE person
                    SET state = '$blacklist'
                    WHERE cardID = '$cardID'";

            if ($conn->query($sql_return) === TRUE  && $conn->query($sql_blacklist) === TRUE) {
              $arr = array ('error_message'=> 0, 'itemTag'=>$itemTag, 'itemLocation'=>$returnLocation);
              echo json_encode($arr);



            } else {
                echo "Error: " . $sql_return . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();
?>
