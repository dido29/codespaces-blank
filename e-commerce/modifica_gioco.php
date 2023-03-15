<?php

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
    
	print '<html>
    <head>
    </head>   
    <body>';
    
    $azione="";
    if(isset($_POST["azione"])) $azione=$_POST['azione'];
    
    if($azione==""){
    //connessione database
    	$mysqli = new mysqli($servername, $usermane, $password, $database);   
    if ($mysqli -> connect_errno ){
    	echo "Failed to connect to MySQL: ". $mysqli ->connect_errno;
    	exit();
    }
   
   $codice_prodotto=$_GET["codice_prodotto"];
	$query="SELECT * FROM prodotto WHERE codice_prodotto='".$codice_prodotto."'";   
  	
  if($result= $mysqli -> query($query)){
  	$row = $result->fetch_array(MYSQLI_BOTH);
    $nome_gioco=$row['nome'];
    $prezzo=$row['prezzo'];
    $descrizione_b=$row['descrizione_b'];
    $descrizione_e=$row['descrizione_e'];
    $pezzi_d_m=$row['pezzi_d_m'];
    $immagine=$row['immagine'];
    
  	$mysqli -> close();
    print "<form  name=inser method=post action='modifica_gioco.php'>";
    print "<input type=hidden name=azione value='modifica'>";
    print "<input type=hidden name=codice_prodotto value=".$codice_prodotto.">";
    print "nome gioco <input type=text name=nome value='".$nome_gioco."'><br><br>";
    print "prezzo <input type=text name=prezzo value=".$prezzo."><br><br>";
    print "descrizione breve <input type=text name=descrizione_b value=".$descrizione_b."><br><br>";
    print "descrizione estesa <input type=text name=descrizione_e value=".$descrizione_e."><br><br>";
    print "pezzi disponibili in magazzino <input type=text name=pezzi_d_m value=".$pezzi_d_m."><br><br>";
    print "percosso immagine<input type=text name=immagine value=".$immagine."><br><br>";
    print "<input type=submit value='modifica'></form></div></div>";
    
  }
 }
 
 if($azione=="modifica"){
 	$nome_gioco=$_POST['nome'];
    $prezzo=$_POST['prezzo'];
    $descrizione_b=$_POST['descrizione_b'];
    $descrizione_e=$_POST['descrizione_e'];
    $codice_prodotto=$_POST['codice_prodotto'];
    $pezzi_d_m=$_POST['pezzi_d_m'];
    $immagine=$_POST['immagine'];
    
 if(($nome_gioco=='') || ($prezzo=='') || ($descrizione_b=='')|| ($descrizione_e=='')|| ($pezzi_d_m=='')|| ($immagine=='')){
 	print"<h1>inserimento annullato. Dati non corretti<br><br>";
 }else{
 	$mysqli = new mysqli($servername, $usermane, $password, $database); 
    if ($mysqli -> connect_errno ){
    	echo "Failed to connect to MySQL: ". $mysqli ->connect_errno;
    	exit();
    }
      $query="UPDATE ".$database.".`prodotto` SET nome='".$nome_gioco."', prezzo='".$prezzo."', descrizione_b='".$descrizione_b."', descrizione_e='".$descrizione_e."' ,
      pezzi_d_m='".$pezzi_d_m."', immagine='".$immagine."' WHERE codice_prodotto=".$codice_prodotto;
      $result= $mysqli -> query($query);
      print $query;

      $mysqli -> close();
      print "<h1>Modifica Effettuata<br><br>";
 	}
   }  
  		print "</body></html>";

?>