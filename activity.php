<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['activity']) && isset($_POST['time'])) {
    if ($db->dbConnect()) {
        if ($db->addActivity("activities", $_POST['activity'], $_POST['time'])) {
            echo "Activity Successfully added";
        } else echo "";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
