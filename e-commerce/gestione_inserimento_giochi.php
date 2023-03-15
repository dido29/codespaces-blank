<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Seleziona azione:</h1><hr>
<form action=gestione_inserimento_giochi.php method=post style='float: left;'>
inserisci il numero di giochi da aggiungere<input type=int name=n_giochi><br>
<input type=submit name=n1 value='Inserisci giochi'>
</form>
<form action=gestione_inserimento_giochi.php method=post style='float: right;'>
<input type=submit name=n2 value='modifica giochi'>
</form>
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

     
if(isset($_POST['n1'])){
	
    $n_giochi=$_POST['n_giochi'];
    
    if (isset($_POST['azione'])) $azione=$_POST['azione'];
    
      if ($azione==""){
      for($i=0; $i<$n_giochi; $i++){
      		 print'
            <form style="margin-top:10%;" action="gestione_inserimento_giochi.php" method="post">
            <input type="hidden" name="azione" value="inserisci">
            Nome gioco<input type="text" name="nome[]"><br>
            Prezzo gioco<input type="int" name="prezzo[]"><br>
            Descrizione breve<textarea name="descrizione_b[]" rows="10">.....</textarea><br>
            Descrizione estesa<textarea name="descrizione_e[]" rows="10">.....</textarea><br>
            Pezzi del gioco<input type="int" name="pezzi_d_m[]"><br>
            percosso immagine<input type="text" name="immagine[]"><br>
			';
			}
            print'
            <input type=hidden name=n_giochi value='.$n_giochi.'>      
            <input type=submit name=n1 value=inserisci>
            </form><hr>';
      }
      
      if ($azione=="inserisci"){
      	$n_giochi=$_POST['n_giochi'];
        $nome_gioco=$_POST['nome'];
        $prezzo=$_POST['prezzo'];
        $descrizione_b=$_POST['descrizione_b'];
        $descrizione_e=$_POST['descrizione_e'];
        $pezzi_d_m=$_POST['pezzi_d_m'];
        $immagine=$_POST['immagine'];
        
      	if(($nome_gioco=='') || ($prezzo=='') || ($descrizione_b=='') || ($descrizione_e=='') || ($pezzi_d_m=='') || ($immagine=='')){
          	print "<h2>inserimento annullato. Dati non corretti</h2>";
        	
                    print '<form style="margin-top:10%;" action="gestione_inserimento_giochi.php" method="post">
                    <input type="hidden" name="azione" value="inserisci">
                    Nome gioco<input type="text" name="nome[]"><br>
                    Prezzo gioco<input type="int" name="prezzo[]"><br>
                    Descrizione breve<textarea name="descrizione_b[]" rows="10">.....</textarea><br>
                    Descrizione estesa<textarea name="descrizione_e[]" rows="10">.....</textarea><br>
                    Pezzi del gioco<input type="int" name="pezzi_d_m[]"><br>
                    percosso immagine<input type="text" name="immagine[]"><br>
                    <input type=submit name=n1 value=inserisci>
                    </form>';
                    
      	}else{
        
        $n_giochi=$_POST['n_giochi'];
        
      	$severname='localhost';
        $username='dido29';
        $password='';
        $database='my_dido29';
        $mysqli= new mysqli($servername,$username,$database);
        
        if($mysqli->connect_errno){
        	echo "failed to connect to MySQL:".$mysqli->connect_error;
            exit();
        }
        
          if ($_POST['azione'] == 'inserisci') {
              $nome_giochi = $_POST['nome'];
              $prezzi_giochi = $_POST['prezzo'];
              $descrizioni_brevi = $_POST['descrizione_b'];
              $descrizioni_esterne = $_POST['descrizione_e'];
              $pezzi_d_m = $_POST['pezzi_d_m'];
              $immagine=$_POST['immagine'];
              
              for ($i = 0; $i < count($nome_giochi); $i++) {
                  $nome_gioco = $mysqli->real_escape_string($nome_giochi[$i]);
                  $prezzo = $mysqli->real_escape_string($prezzi_giochi[$i]);
                  $descrizione_b = $mysqli->real_escape_string($descrizioni_brevi[$i]);
                  $descrizione_e = $mysqli->real_escape_string($descrizioni_esterne[$i]);
                  $pezzi = $mysqli->real_escape_string($pezzi_d_m[$i]);
				  $immagine = $mysqli->real_escape_string($immagine[$i]);
                  $query = "INSERT INTO `my_dido29`.`prodotto`(`nome`,`prezzo`,`descrizione_b`,`descrizione_e`,`pezzi_d_m`,`immagine`,)
                      VALUES('$nome_gioco', '$prezzo', '$descrizione_b', '$descrizione_e', '$pezzi')";
                  $result = $mysqli->query($query);
              }
          }
            print "<br><h2>inserimento effettuato con successo</h2></div>";
      }
     }
  }
  
  if(isset($_POST['n2'])){
  
    $smt3="SELECT * FROM prodotto";
    $result=$mysqli -> query($smt3);
	print "<ul class='product-list'>";
      while($row = $result->fetch_array(MYSQLI_BOTH)) {
      $pezzi_d_m=$row['pezzi_d_m'];
      $codice_prodotto=$row['codice_prodotto'];
      $immagine=$row['immagine'];
      	print "<li>";
        print "<img src=".$immagine."><br>";
      	print $row['nome']."<br>";
        print  $row['prezzo']."<hr>";
        print "<form action=modifica_gioco.php method=get>
        		<input type=hidden name=codice_prodotto value=".$codice_prodotto.">
        		<input type=submit name=n5 value=modifica>
                </form>
                <form action=rimozione_gioco.php method=get>
        		<input type=hidden name=codice_prodotto value=".$codice_prodotto.">
        		<input type=submit name=n6 value=elimina>
                </form>
                </li>";
    	}
	print "</ul>";
    
  }
?>    
            

</body>
</html>