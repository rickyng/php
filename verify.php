<?php
// core configuration
include_once "config/core.php";
 
// include classes
include_once 'config/database.php';
include_once 'objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$user = new User($db);
 
// set access code
$request = array();
$request['access_code'] = isset($_GET['access_code']) ? $_GET['access_code'] : "";
$result = $user->search($request, 0, 5); 
// verify if access code exists
if ( sizeof($result) == 0 ){
    die("ERROR: Access code not found.");
}
 
// redirect to login
else{
     
    // update status
    $user->status=1;
    $user->update($result['id'], $request);
     
    // and the redirect
    header("Location: {$home_url}login.php?action=email_verified");
}
?>