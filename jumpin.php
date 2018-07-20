<?php

    session_start();

    require_once("dbcon.php");
    require_once("include/conexion/conexion.php");

    if (isAjax()) {
    
    	$data = array();
    	$username = cleanInput($_POST['userid']);
    	
    	if (checkVar($username)) {
    	
    		$getUsers = "SELECT *
    					 FROM chat_users
    					 WHERE username = '$username'";
    					 
    		if (!hasData($getUsers,$base)) {
    		  $data['result'] = "<div class='message success'>Great! You found a username not in use</div>";
    		  $data['inuse'] = "notinuse";
    		} else {
    		  $data['result'] = "<div class='message warning'>That username is already in use. (Usernames take 2 minutes without use to expire)</div>";
    		  $data['inuse'] = "inuse";
    		}
    		
    		echo json_encode($data);
    			
    	}
    	
    } else {
    
        $username = cleanInput($_POST['userid']);
        
    	if (checkVar($username)) {
    	
    		$getUsers = "SELECT *
    					 FROM chat_users
    					 WHERE username = '$username'";
    		
    		if (!hasData($getUsers,$base)) {
    		
    			$now = time();
    		
    		    $postUsers = "INSERT INTO `chat_users` (
    					`id` ,
    					`username` ,
    					`status` ,
    					`time_mod`
    					)
    					VALUES (
    					NULL , '$username', '1', '$now'
    					)";
				
				$resultado = $base->prepare( $postUsers );
				$resultado->execute( array() );
    		    			
    			$_SESSION['userid'] = $username;
    		
    		    header('Location: ./chatrooms.php');
    	
    		} else {
    			
    		  header('Location: ./?error=1');
    			
    		}
    
    	}
    
    }

?>
