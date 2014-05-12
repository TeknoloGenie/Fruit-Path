<?php
session_start();
/**
 * Created by Franklin Russell.
 * Date: 3/28/13
 * Time: 8:13 PM
 */
require_once 'core_sql.php';
if(!isset($_POST['address']) || !isset($_POST['zip']) || !isset($_SESSION['id'])){
    return false;
    exit();
} else {
    $address = $_POST['address'];
    $zip = intval($_POST['zip']);
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $class = new MySql_Con();
    $step01 = $class->updateaddress($address, $zip, $email, $pass);
    if ($step01 == false) {
        return false;
    } elseif ($step01 == true){
        echo "success";
        return;
    } else {
        echo $step01;
        return false;
    }
}
?>