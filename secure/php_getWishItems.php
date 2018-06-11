
<?php
   $json = file_get_contents('php://input');
   $obj = json_decode($json,true);

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

   $sql = "SELECT userID FROM person WHERE cardID = '$cardID'";

   if ($result=mysqli_query($conn,$sql))
   {
          $row = mysqli_fetch_row($result);

          $sql2="SELECT * FROM wishList WHERE userID_wishList = '$row[0]'";

          if ($result2=mysqli_query($conn,$sql2))
          {
               $array['wishlist']= array();
               // Fetch one and one row
               while ($row2=mysqli_fetch_row($result2))
               {
                   $array['wishlist'][] = array('error_message'=> 0,'itemClassification'=>$row2[2], 'itemLocation'=>$row2[3]);         
               }

               echo json_encode($array);
          }
         
      mysqli_free_result($result);
   }
   

    $conn->close();
  // echo 'Connected successfully';


?>
