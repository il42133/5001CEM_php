<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $username, $password)
    {
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where username = '" . $username . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            if ($dbusername == $username && password_verify($password, $dbpassword)) {
                $login = true;
            } else $login = false;
        } else $login = false;

        return $login;
    }

    function signUp($table, $fullname, $email, $username, $password)
    {
        $fullname = $this->prepareData($fullname);
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $email = $this->prepareData($email);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (fullname, username, password, email) VALUES ('" . $fullname . "','" . $username . "','" . $password . "','" . $email . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }

    
    function addActivity($table, $activity, $time, $username)
    {
        $activity = $this->prepareData($activity);
        $username = $this->prepareData($username);
        $time = $this->prepareData($time);
        $this->sql =
            "INSERT INTO " . $table . " (activity, time, username) VALUES ('" . $activity . "','" . $time . "','" . $username . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;

        return $login;
    }
    
    function getUserID($username)
    {
        $username = $this->prepareData($username);
        $result = mysqli_query($con,"SELECT id FROM user_login WHERE username='$username'");
        return $result;
    }
    
    function getActivityList($username)
    {
        $result = "SELECT activity FROM activities WHERE username='$username'";
        
        $rows = [];
        while ($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }
    }
    
    function updatePoints($username, $points)
    {
        $current_points = mysqli_query("SELECT points from user_points WHERE username='$username'");
        $update_points = $current_points + $points;
        $result = mysqli_query("UPDATE user_points SET points='$update_points' WHERE username='$username'");
    }

}

?>
