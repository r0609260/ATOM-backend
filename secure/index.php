<?php
    $arr = array('email' => $_SERVER["mail"], 'user' => $_SERVER["user"], 'role'=> $_SERVER["unscoped-affiliation"]);

    echo json_encode($arr);
    //  echo '<script>window.location.href = "json.php";</script>';
//    $json = array();
//    $itemObject = new stdClass();
//    $itemObject->email = $_SERVER["mail"];
//    $itemObject->user = $_SERVER["user"];
//
//    array_push($json, $itemObject);
//    $json = json_encode($json, JSON_PRETTY_PRINT);
//    echo $json;
?>
