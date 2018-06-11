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

   $sql="SELECT itemClassification, itemLocation, count(*), itemStatus
           FROM item
           GROUP BY itemClassification, itemLocation, itemStatus";

    if ($result=mysqli_query($conn,$sql))
    {
        $arr['list'] = array();
        // Fetch one and one row
        while ($row=mysqli_fetch_row($result))
        {
             $arr['list'][] = array ('itemClassification'=>$row[0],'itemLocation'=>$row[1],'quantity'=>$row[2], 'itemStatus'=>$row[3]);
        }
        echo json_encode($arr);
        // Free result set
        mysqli_free_result($result);
    }

    mysqli_close($conn);
    // echo 'Connected successfully';
?>
