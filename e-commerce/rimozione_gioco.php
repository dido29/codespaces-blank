<?php
	print "<html>
    
    	<meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

    <head>
    </head>    
    <body>";
   
      $servername = "localhost";
      $username = "dido29";
      $password = "";
      $database = "my_dido29";

      //connessione database
      $mysqli = new mysqli($servername, $usermane, $password, $database);  
      if ($mysqli -> connect_errno ){
      echo "Failed to connect to MySQL: ". $mysqli ->connect_errno;
      exit();
      }

    $azione="";
    if (isset($_GET['azione'])) $azione=$_GET['azione']; 
    	
    	if($azione==""){
			print"<h1><a href='rimozione_gioco.php?azione=cancella&codice_prodotto=".$_GET['codice_prodotto']."'> SI </a><a href='javascript:history.back();'>   NO </a></h2>";
	}

      if($azione=="cancella"){
          $servername = "localhost";
          $username = "dido29";
          $password = "";
          $database = "my_dido29";

      $mysqli = new mysqli($servername, $usermane, $password, $database);

          if ($mysqli -> connect_errno ){
              echo "Failed to connect to MySQL: ". $mysqli ->connect_errno;
              exit();
          }
	
         $query="DELETE FROM`".$database."`.`prodotto` WHERE codice_prodotto='".$_GET['codice_prodotto']."';";
         $result = $mysqli -> query($query);
         $mysqli -> close();
         print "<h1>Cancellazione  effettuata</h1>";
         }
	print "</body></html>";
?>