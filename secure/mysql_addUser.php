<?php
    include('Net/SSH2.php');
    $ssh_server = "labtools.groept.be";
    $remote_port = "3306";
    $ssh_user = "inventoryweb";
    $ssh_pass = "inventorydb";
    $pub_key = "/home/inventoryweb/.ssh/id_rsa_labtools.pub";
    $pri_key = "/home/inventoryweb/.ssh/id_rsa_labtools";
    if (!($connection = ssh2_connect("labtools.groept.be", 22, array('hostkey'=>'ssh-rsa, ssh-dss')))) {
               throw new Exception('Cannot connect to server');
    }
  //  ssh2_auth_pubkey_file($connection, $ssh_user, $pub_key, $pri_key)
    //
    // if()
    // {
    //   echo "Authentication succeeded";
    // }
    // else
    // {
    //  echo "Authentication failed";
    // }

    // $auth = ssh2_auth_password($connection, $ssh_user, $ssh_pass);
    // $tunnel = ssh2_tunnel($connection, '127.0.0.1', 3306);
    // if (false === $tunnel) {
    //   die('authentication failed');
    // }
    // else {
    //   echo $tunnel;
    // }
    // $con = mysqli_connect("127.0.0.1","inventorydb","thesis-2017","inventorydb");
    // echo $con;


    // $sql="INSERT INTO table1 (FirstName, LastName, Age) VALUES ('admin', 'admin','adminstrator')";
    // if (mysqli_query($con,$sql)) {
    // echo "Values have been inserted successfully";
    // }
?>
