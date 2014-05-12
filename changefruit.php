<?php
/**
 * Created by Franklin Russell.
 * Date: 2/24/13
 * Time: 5:22 AM
 */
require_once 'core_sql.php';
$fruit = $_POST['fruits'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$class = new MySql_Con();
$step01 = $class->changefruit($fruit, $email, $pass);
if ($step01 == false) {
    return false;
} else {
    return true;
}
?>