<?php
header("Content-Type: application/json");
require_once 'core_sql.php';
if (isset($_GET['bounds'])){
$class = new MySql_Con();
$bound = $_GET['bounds'];
$step01 = $class->grabmarkers($bound);
if ($step01 == false){
    echo $_GET['callback'] . '(' . json_encode(array('code'=>'false')).')';
} else {
    echo $_GET['callback'] . '(' . json_encode($step01).')';
}
}
?>