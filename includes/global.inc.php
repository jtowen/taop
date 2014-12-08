<?php
//
// global.inc.php
//
// Start the session
session_name("TAOP");
session_start();
// Includes
require_once 'class/User.class.php';
require_once 'class/Db.class.php';
// Open the database connection
$db = new DB;
// If someone is logged in, set $userID
// and $user globals.
if(isset($_SESSION['logged_in'])) {
$userID = $_SESSION["userID"];
$user = $db->buildUser($userID, 'true');
}
else {
$userID = "";
$user = null;

}
?>
