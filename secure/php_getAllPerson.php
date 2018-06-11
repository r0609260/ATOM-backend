<html>
<head>
<meta charset="utf-8"> 
<title>Connecting MySQL Serve--Linuxdaxue.comr</title>
</head>
<body>
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

   $sql="SELECT * FROM person";

if ($result=mysqli_query($conn,$sql))
  {
  // Fetch one and one row
  while ($row=mysqli_fetch_row($result))
    {
        //printf ("%s (%s)\n",$row[0]);

         $arr = array ('userID'=>$row[0],'kuleuvenID'=>$row[1],'cardID'=>$row[2],'email'=>$row[3],'userType'=>$row[4]); 

         echo json_encode($arr);

    }
  // Free result set
   mysqli_free_result($result);
}

   mysqli_close($conn);
  // echo 'Connected successfully';


?>
</body>
</html>