
<?php

  $json = file_get_contents('php://input');
  $obj = json_decode($json,true);

  $name = $obj['name'];
  $arr = array('name' => $name);
  echo json_encode($arr);

?>
