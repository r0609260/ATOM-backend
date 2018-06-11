<?php

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $itemTag = $obj['itemTag'];
    $itemLocation = $obj['itemLocation'];
    $boughtTime = $obj['boughtTime'];
    $itemClassification = $obj['itemClassification'];
    $itemPermission = $obj['itemPermission'];
    
    $pictureUrl = $obj['pictureUrl'];


    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(! $conn )
    {
      die('Could not connect: ' . mysqli_connect_error());
    }

    $duplicateItem = "SELECT * FROM item
                        WHERE itemTag = '$itemTag'";


    if($duplicateItem1 = mysqli_query($conn,$duplicateItem)){

        $row=mysqli_fetch_row($duplicateItem1);

        //OK: No duplicate items
        if($row == NULL){

            $duplicateItemClassification = "SELECT * FROM itemPicture
                        WHERE itemPictureClassification = '$itemClassification'";

            if($duplicateItemClassification1 = mysqli_query($conn,$duplicateItemClassification)){

                $rowPicture=mysqli_fetch_row($duplicateItemClassification1);

                //OK: No duplicate pictures
                if($rowPicture == NULL){

                    $sql = "INSERT INTO item 
                    (itemTag, itemLocation, boughtTime, itemStatus, itemClassification, itemPermission) 
                    VALUES
                    ('$itemTag','$itemLocation','$boughtTime','available', '$itemClassification', '$itemPermission')";

                    $sql2 = "INSERT INTO itemPicture 
                    (itemPictureClassification, pictureUrl) 
                    VALUES
                    ('$itemClassification', '$pictureUrl')";
              

                    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
                        $arr = array ('error_message'=> 0); 
                        echo json_encode($arr);
                    } else {
                      echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                }

                else{

                    $sql = "INSERT INTO item 
                    (itemTag, itemLocation, boughtTime, itemStatus, itemClassification, itemPermission) 
                    VALUES
                    ('$itemTag','$itemLocation','$boughtTime','available', '$itemClassification', '$itemPermission')";


                    $sql = "UPDATE  itemPicture
                    SET pictureUrl = 'pictureUrl'
                    WHERE itemPictureClassification = '$itemClassification'";
                 

                    if ($conn->query($sql) === TRUE) {
                        $arr = array ('error_message'=> 0); 
                        echo json_encode($arr);
                    } else {
                      echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }          
        }

        else
        {
             //return 2 : the item has already been added  
            $arr = array ('error_message'=> 2); 
            echo json_encode($arr);
        }

    }

    $conn->close();

?>
