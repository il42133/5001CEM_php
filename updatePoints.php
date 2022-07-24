<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['username']) && isset($_POST['points'])) {
    if ($db->dbConnect()) {
        if ($db->updatePoints("user_points", $_POST['username'], $_POST['points'])) {
            echo "Points added";
        } else echo "Error";
    } else echo "Error: Database connection";
} else echo "All fields are required test";
?>
