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

    $sql = "SELECT * FROM person 
            WHERE cardID = '$cardID'";     

    if ($result=mysqli_query($conn,$sql))
    {        
        $row=mysqli_fetch_row($result);
        
        if($row[0] == NULL){
            //the person is not existing
            $arr =array('error_message'=> 4) ; 
            echo json_encode($arr);
        }
        else{
            $arr = array ('error_message'=> 0,'userID'=>$row[0],'kuleuvenID'=>$row[1],'cardID'=>$row[2],'email'=>$row[3],'userType'=>$row[4],
                'userName'=>$row[5]); 
            echo json_encode($arr);
        }
 
        // Free result set
        mysqli_free_result($result);            
        
    }

    $conn->close();
?>