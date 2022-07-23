<?php
require "DataBase.php";
$db = new DataBase();
if ($db->dbConnect()) {
  $userID = getUserID("user_login", $_POST['username'])
  if ($db->getUserID("user_login", $_POST['username'])) {
      echo $userID;
  } else echo "";
} else echo "Error: Database connection";
?>
