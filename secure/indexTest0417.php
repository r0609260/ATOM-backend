<?php
    $arr = array('user' => $_SERVER["user"]);
    echo json_encode($arr);
    echo('</br>');

    $arr1 = array('HomeOrganization' => $_SERVER["HomeOrganization"]);
    echo json_encode($arr1);
    echo('</br>');

        $arr2 = array('KULAssocMigrateID' => $_SERVER["KULAssocMigrateID"]);
    echo json_encode($arr2);
    echo('</br>');

            $arr3 = array('KULMoreUnifiedUID' => $_SERVER["KULMoreUnifiedUID"]);
    echo json_encode($arr3);
    echo('</br>');


    $arr4 = array('HomeOrganization' => $_SERVER["HomeOrganization"]);
    echo json_encode($arr4);
    echo('</br>');

    $arr5 = array('Shib-EP-OrgDN' => $_SERVER["Shib-EP-OrgDN"]);
    echo json_encode($arr5);
    echo('</br>');

    $arr6 = array('Shib-EP-OrgUnitDN' => $_SERVER["Shib-EP-OrgUnitDN"]);
    echo json_encode($arr6);
    echo('</br>');

    $arr7 = array('Shib-EP-ScopedAffiliation' => $_SERVER["Shib-EP-ScopedAffiliation"]);
    echo json_encode($arr7);
    echo('</br>'); 


    $arr8 = array('Shib-EP-UnscopedAffiliation' => $_SERVER["Shib-EP-UnscopedAffiliation"]);
    echo json_encode($arr8);
    echo('</br>');   

    $arr9 = array('Shib-Person-givenName' => $_SERVER["Shib-Person-givenName"]);
    echo json_encode($arr9);
    echo('</br>');   

// Shib-Person-givenName: 1 value(s)
// Shib-Person-mail: 1 value(s)
// Shib-Person-surname: 1 value(s)
// Shib-logoutURL: 1 value(s)
// affiliation: 2 value(s)
// eduPersonAffiliation: 2 value(s)
// eduPersonOrgDN: 1 value(s)
// eduPersonOrgUnitDN: 3 value(s)
// eduPersonScopedAffiliation: 2 value(s)
// eppn: 1 value(s)
// givenName: 1 value(s)
// logoutURL: 1 value(s)
// mail: 1 value(s)
// org-dn: 1 value(s)
// orgunit-dn: 3 value(s)
// sn: 1 value(s)
// unscoped-affiliation: 2 value(s)
// user: 1 value(s)
    
    
   //   echo '<script>window.location.href = "json.php";</script>';
   // $json = array();
   // $itemObject = new stdClass();
   // $itemObject->email = $_SERVER["mail"];
   // $itemObject->user = $_SERVER["user"];

   // array_push($json, $itemObject);
   // $json = json_encode($json, JSON_PRETTY_PRINT);
   // echo $json;
?>
