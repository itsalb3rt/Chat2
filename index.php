<?php 
    session_start();

    if (!isset($_SESSION['userid'])): 
?>
<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>Chat2</title>
    
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    
    <script src="js/jquery-latest.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/check.js"></script>
</head>

<body>

    <div id="page-wrap"> 
    
    	<div id="header">
        	<h1><a href="/examples/Chat2/">Chat v2</a></h1>
        </div>
        
    	<div id="section">
        	<form method="post" action="jumpin.php">
            	<label>Desired Username:</label>
                <div>
                	<input type="text" id="userid" name="userid" />
                    <input type="submit" value="Check" id="jumpin" />
            	</div>
            </form>
        </div>
        
        <div id="status">
        	<?php if (isset($_GET['error'])): ?>
        	<?php endif;?>
        </div>
        
    </div>
    
</body>

</html>

<?php 
    else:
        header("location:chatrooms.php");
    endif; 
?>