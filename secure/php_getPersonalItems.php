<?php
    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $kuleuvenID = $obj['kuleuvenID'];
    $cardID = $obj['cardID'];

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
        // Fetch one and one row
        while ($row=mysqli_fetch_row($result))
        {


            $sqlItem = "SELECT itemTag,itemClassification FROM item
            WHERE itemID = '$row[2]'";

            if ($resultItem = mysqli_query($conn,$sqlItem)){

                $rowItem = mysqli_fetch_row($resultItem);

                $array['list'][] = array('borrowID'=>$row[0],'userID_borrow'=>$row[1],'itemID_borrow'=>$row[2],'borrowTimestamp'=>$row[3],
                    'preferedEmail'=>$row[4],'returnTimestamp'=>$row[5],'returnLocation'=>$row[6],'borrowState'=>$row[7],
                    'borrowLocation'=>$row[8],'itemTag'=>$rowItem[0],'itemClassification'=>$rowItem[1]);
            }
        }
        // Free result set
        mysqli_free_result($result);
    }


    $sql_wish = "SELECT userID FROM person WHERE cardID = '$cardID'";

    if ($result_wish=mysqli_query($conn,$sql_wish))
    {
           $row_wish = mysqli_fetch_row($result_wish);

           $sql_wish2="SELECT * FROM wishList WHERE userID_wishList = '$row_wish[0]'";

           if ($result_wish2=mysqli_query($conn,$sql_wish2))
           {
                $array['wishlist']= array();
                // Fetch one and one row
                while ($row_wish2=mysqli_fetch_row($result_wish2))
                {
                    $array['wishlist'][] = array('error_message'=> 0,'itemClassification'=>$row_wish2[2], 'itemLocation'=>$row_wish2[3]);
                }
           }

       mysqli_free_result($result_wish2);
    }


    $sql_items ="SELECT itemClassification, itemLocation, count(*), itemStatus
            FROM item
            GROUP BY itemClassification, itemLocation, itemStatus";

     if ($result_items =mysqli_query($conn,$sql_items))
     {
         $array['overview'] = array();
         // Fetch one and one row
         while ($row_items = mysqli_fetch_row($result_items))
         {
              $array['overview'][] = array ('itemClassification'=>$row_items[0],'itemLocation'=>$row_items[1],'quantity'=>$row_items[2], 'itemStatus'=>$row_items[3]);
         }
         mysqli_free_result($result_items);
     }
    echo json_encode($array);


    $conn->close();
?>
