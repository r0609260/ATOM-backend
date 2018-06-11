<?php

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);

    $cardID = $obj['cardID'];
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


    $checkCardID  = "SELECT * FROM person
                    WHERE cardID = '$cardID'";
    if($cardExistResult = mysqli_query($conn,$checkCardID)){
            $row=mysqli_fetch_row($cardExistResult);
            if($row == NULL){

              //return 4 : the person is not added, please register
              $array['user'] = array ('error_message'=> 4);
            }
            else{

              if($row[1]!=$kuleuvenID)
              {
                //return 11" wrong kuleuven username, log in again
                $array['user'] = array ('error_message'=> 11, 'kuleuvenID'=>$kuleuvenID, 'kuleuvenID2'=>$row[1]);
              }
              else {
                $array['user'] = array ('error_message'=> 0,'userType'=>$row[4], 'state'=>$row[7]);
                $sql = "SELECT permissionType FROM permission;";

                $sql2 = "SELECT * FROM itemPicture;";

                $sql3 = "SELECT DISTINCT itemLocation FROM item;";

                $sql4 = "SELECT DISTINCT itemClassification FROM item;";

                $sql5 = "SELECT itemClassification, itemLocation, count(*), itemStatus
                        FROM item
                        GROUP BY itemClassification, itemLocation, itemStatus";

                  if($result = mysqli_query($conn,$sql)){

                      $array['permissionTypeList'] = array();

                      while ($row=mysqli_fetch_row($result)){
                          $array['permissionTypeList'][] = array('permissionType'=>$row[0]);
                      }
                  }


                  if($result2 = mysqli_query($conn,$sql2)){

                      $array['pictureList'] = array();

                      while ($row2=mysqli_fetch_row($result2)){
                          $array['pictureList'][] = array('itemPictureClassification'=>$row2[2], 'pictureUrl'=>$row2[1]);
                      }
                  }

                  if($result3 = mysqli_query($conn, $sql3)){

                    $array['locationList'] = array();

                    while($row3=mysqli_fetch_row($result3)){
                      $array['locationList'][] = array('itemLocation'=>$row3[0]);
                    }
                  }

                  if($result4 = mysqli_query($conn, $sql4)){

                    $array['classificationList'] = array();

                    while($row4=mysqli_fetch_row($result4)){
                      $array['classificationList'][] = array('itemClassification'=>$row4[0]);
                    }
                  }





                   if ($result5=mysqli_query($conn,$sql5))
                   {
                       $array['sorting'] = array();
                       // Fetch one and one row
                       while ($row5 = mysqli_fetch_row($result5))
                       {
                            $array['sorting'][] = array ('itemClassification'=>$row5[0],'itemLocation'=>$row5[1],'quantity'=>$row5[2], 'itemStatus'=>$row5[3]);
                       }
                   }
              }
            }
    }




    echo json_encode($array);
    $conn->close();

?>
