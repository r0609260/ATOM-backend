<?php
    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $kuleuvenID = $obj['kuleuvenID'];

    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(! $conn )
    {
      die('Could not connect: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM userBorrowItem
            WHERE userID_borrow = (SELECT userID FROM person
                      WHERE kuleuvenID = '$kuleuvenID')
            AND borrowState = 'Borrowing'
            ORDER BY borrowTimestamp DESC";

    

    if ($result=mysqli_query($conn,$sql))
    {
        $array['list'] = array();
                            echo('////////////');
                            reset($result);

                    echo json_encode($result);
                                                echo('////////////');



        if($result== NULL){
            //error _message7: the user is not borrowing item
            $array1= array('error_message'=>7);
            echo json_encode($array1);

        }

        else{
            // Fetch one and one row
            echo json_encode('here');

            while ($row=mysqli_fetch_row($result))
            {

                            echo json_encode('here1');

                $sqlPicture = "SELECT pictureUrl FROM itemPicture
                WHERE itemPictureClassification = (SELECT itemClassification FROM item
                          WHERE itemID = '$row[2]')";

                $sqlItem = "SELECT itemTag,itemClassification FROM item
                WHERE itemID = '$row[2]'";

                if ($resultPicture = mysqli_query($conn,$sqlPicture) && $resultItem = mysqli_query($conn,$sqlItem)){

                    $rowPicture = mysqli_fetch_row($resultPicture);
                    $rowItem = mysqli_fetch_row($resultItem);

                    $array['list'][] = array('error_message'=>0,'borrowID'=>$row[0],'userID_borrow'=>$row[1],'itemID_borrow'=>$row[2],
                        'borrowTimestamp'=>$row[3],'preferedEmail'=>$row[4],'returnTimestamp'=>$row[5],'returnLocation'=>$row[6],'borrowState'=>$row[7],
                        'borrowLocation'=>$row[8], 'pictureUrl'=>$rowPicture[0],'itemTag'=>$rowItem[0],'itemClassification'=>$rowItem[1]);
                }     
            }

            echo json_encode($array);
        }

        
        
        // Free result set
        mysqli_free_result($result);
    }

    $conn->close();
?>
