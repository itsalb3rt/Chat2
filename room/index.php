<?php
    session_start();

    if (isset($_GET['name']) && isset($_SESSION['userid'])): 
    
      require_once("../dbcon.php");
      require_once("../include/conexion/conexion.php");
  
      $name = cleanInput($_GET['name']);

      $getRooms = "SELECT *
  			           FROM chat_rooms
  		             WHERE name = '$name'";
		
		$resultado = $base->prepare( $getRooms );
		$resultado->execute( array() );
		$roomResults = $resultado->rowCount();
		$resultado = $resultado->fetchAll( PDO::FETCH_OBJ );
		
	  	if ($roomResults < 1) {
  			header("Location: ../chatrooms.php");
  		}
       foreach($resultado as $rooms){
		  $file =  $rooms->file; 
	   }
          

?>
<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>Welcome to: <?php echo $name; ?></title>
    
    <link rel="stylesheet" type="text/css" href="../css/main.css"/>
    
    <script src="../js/jquery-latest.js" type="text/javascript"></script>
    <script type="text/javascript" src="chat.js?v2"></script>
    <script type="text/javascript">
    	var chat = new Chat('<?php echo $file; ?>');
    	chat.init();
    	chat.getUsers(<?php echo "'" . $name ."','" .$_SESSION['userid'] . "'"; ?>);
    	var name = '<?php echo $_SESSION['userid'];?>';
    </script>
    <script type="text/javascript" src="settings.js"></script>

</head>

<body>

    <div id="page-wrap"> 
    
    	<div id="header">
    	
        	<h1><a href="/examples/Chat2/">Chat v2</a></h1>
        	
        	<div id="you"><span>Logged in as:</span> <?php echo $_SESSION['userid']?></div>
        	
        </div>
        
    	<div id="section">
    
            <h2><?php echo $name; ?></h2>
                     
            <div id="chat-wrap">
                <div id="chat-area"></div>
            </div>
            
            <div id="userlist"></div>
                
                <form id="send-message-area" action="">
                    <textarea id="sendie" maxlength='100'></textarea>
                </form>
        </div>
    </div>
</body>
</html>

<?php
    else:
           header("location:../index.php");
    endif; 
?>
