<?php
/* 
Author: Kenrick Beckett
Author URL: http://kenrickbeckett.com
Name: Chat Engine 2.0

*/
require_once("../dbcon.php");
require_once("../include/conexion/conexion.php");

//Start Array
$data = array();
// Get data to work with
		$current = cleanInput($_GET['current']);
		$room = cleanInput($_GET['room']);
		$username = cleanInput($_GET['username']);
		$now = time();
// INSERT your data (if is not already there)
       	$findUser = "SELECT * FROM chat_users_rooms WHERE username = '$username' AND room ='$room' ";

		if(!hasData($findUser,$base)){
					$insertUser = "INSERT INTO chat_users_rooms (id, username, room, mod_time) VALUES ( NULL , '$username', '$room', '$now')";
					$resultado = $base->prepare( $insertUser );
					$resultado->execute( array() );
				}		
		 	$findUser2 = "SELECT * FROM chat_users WHERE username = '$username'";
			if(!hasData($findUser2,$base)){
					$insertUser2 = "INSERT INTO chat_users (id ,username , status ,time_mod)
					VALUES (NULL , '$username', '1', '$now')";
					$resultado = $base->prepare( $insertUser2 );
					$resultado->execute( array() );
					$data['check'] = 'true';
				}			
		$finish = time() + 7;
		$getRoomUsers = "SELECT * FROM chat_users_rooms WHERE room = '$room'";
		$getRoomUsers = $base->prepare( $getRoomUsers );
		$getRoomUsers->execute( array() );
		$check  = $getRoomUsers->rowCount();
        	
	    while(true){
			usleep(10000);
			$update = "UPDATE chat_users SET time_mod = '$now' WHERE username = '$username'";
			$resultado = $base->prepare( $update );
			$resultado->execute( array() );
			
			$olduser = time() - 5;
			$eraseuser = time() - 30;
			
			$delete = "DELETE FROM chat_users_rooms WHERE mod_time <  '$olduser'";
			$resultado = $base->prepare( $delete );
			$resultado->execute( array() );
			
			
			$delete2 = "DELETE FROM chat_users WHERE time_mod <  '$eraseuser'";
			$resultado = $base->prepare( $delete2 );
			$resultado->execute( array() );
			
			$check = "SELECT * FROM chat_users_rooms WHERE room = '$room' ";
			$resultado = $base->prepare( $check );
			$resultado->execute( array() );
			$check  = $resultado->rowCount();

			$now = time();
			if($now <= $finish){
				$update2 = "UPDATE chat_users_rooms SET mod_time = '$now' WHERE username = '$username' AND room ='$room'  LIMIT 1";
				$resultado = $base->prepare( $update2 );
				$resultado->execute( array() );
				
				if($check != $current){
				 break;
				}
			}
			else{
				 break;	
		    }
        }		 		
// Get People in chat
		$getRoomUsers = "SELECT * FROM chat_users_rooms WHERE room = '$room'";
		$getRoomUsers = $base->prepare( $getRoomUsers );
		$getRoomUsers->execute( array() );
		$getRoomUsers = $getRoomUsers->fetchAll( PDO::FETCH_OBJ );
		if($check != $current){
			$data['numOfUsers'] = $check;
			// Get the user list (Finally!!!)
			$data['userlist'] = array();
			
			foreach($getRoomUsers as $user){
				$data['userlist'][] = $user->username;
			}
			$data['userlist'] = array_reverse($data['userlist']);
		}else{
			$data['numOfUsers'] = $current;
			foreach($getRoomUsers as $user){
				$data['userlist'][] = $user->username;
			}
			$data['userlist'] = array_reverse($data['userlist']);
		}
		echo json_encode($data);

?>