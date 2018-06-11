<?php

    $dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

 	//connection to database
    if(! $conn )
    {
       die('Could not connect: ' . mysqli_connect_error());
    }

 	$sql = "SELECT permissionType FROM permission;";

  $sql2 = "SELECT itemPictureClassification FROM itemPicture;";

  $sql3 = "SELECT DISTINCT itemLocation FROM item;";

    if($result = mysqli_query($conn,$sql)){

        $array['list'] = array();

        while ($row=mysqli_fetch_row($result)){
            $array['list'][] = array('permissionType'=>$row[0]);
        }

    }


    if($result2 = mysqli_query($conn,$sql2)){

        $array['list2'] = array();

        while ($row2=mysqli_fetch_row($result2)){
            $array['list2'][] = array('itemPictureClassification'=>$row2[0]);
        }


    }

    if($result3 = mysqli_query($conn, $sql3)){

      $array['list3'] = array();

      while($row3=mysqli_fetch_row($result3)){
        $array['list3'][] = array('itemLocation'=>$row3[0]);
      }
    }

    echo json_encode($array);
    // Free result set
    mysqli_free_result($result);
    mysqli_free_result($result2);




    $conn->close();

 ?>
