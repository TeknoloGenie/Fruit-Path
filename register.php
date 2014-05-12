<?PHP
    if(isset($_GET['email']) && isset($_GET['type']) && isset($_GET['fruits']) && isset($_GET['password']) && isset($_GET['name']) && isset($_GET['zip']) && isset($_GET['address'])){
    	header("Content-Type: application/json");
        require_once 'core_sql.php';
        $email = $_GET['email'];
        $password = $_GET['password'];
        $name = $_GET['name'];
        $avatar = (isset($_GET["avatar"]) && $_GET["avatar"]!=false)?$_GET["avatar"]:false;
        $type = $_GET['type'];
        $fruits = $_GET['fruits'];
        $phone = $_GET['phone'];
        $zip = intval($_GET['zip']);
        $address = $_GET['address'];
        $class = new MySql_Con();
        $step01 = $class->register( $email, $password, $phone, $address, $zip, $type, $fruits, $name, $avatar);
        if ($step01 === false) {
            echo $_GET['callback'] . '(' . json_encode(array('code'=>'false')) . ')';
            return false;
        } elseif ($step01 === true){
            echo $_GET['callback'] . '(' . json_encode(array('code'=>'success')) . ')';
            return;
        } elseif ($step01 == "exists"){
            echo $_GET['callback'] . '(' . json_encode(array('code'=>'email exists')) . ')';
            return;
        } else {
            echo $_GET['callback'] . '(' . json_encode(array('code'=>'nothing')) . ')';
            return false;
        }
    } else {
        echo "nothing";
        return false;
    }
?>