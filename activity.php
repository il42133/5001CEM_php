<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['activity']) && isset($_POST['time']) &&isset($_POST['username'])) {
    if ($db->dbConnect()) {
        if ($db->addActivity("activities", $_POST['activity'], $_POST['time'], $_POST['username'])) {
            echo "Activity Successfully added";
        } else echo "";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
