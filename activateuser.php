<?php
/**
 * Created by Franklin Russell.
 * Date: 4/5/13
 * Time: 5:53 AM
 */
	if (isset($_GET['usr']) && isset($_GET['token'])){
		require_once 'core_sql.php';
    		$class = new MySql_Con();
		$user = $_GET['usr'];
		$token = $_GET['token'];
		$step01 = $class->activate($user, $token);
		if ($step01 == true) {
				echo "Activated";
	            return;
       	 	}  else {
	    	    echo "Failed";
	    	    return;
        	}
	} else {
        exit();
    }
?>