<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css">
    <title>Login e-commerce</title>
</head>
<body>
<?php
if(isset($_POST['AZIONE']))		$AZIONE=$_POST['AZIONE'];	
if ($AZIONE==""){
	echo "<div class='container'>";
    echo "<div class='front side'>";
    echo "<div class='content'>";
	echo "<h1>Benvenuto entra nel nostro sito di e-commerce</h1></em>";
    echo "<p>Benvenuti nel nostro sito di e-commerce di videogiochi! Siamo qui per fornirvi una vasta selezione di giochi per tutte le piattaforme, dai giochi per PC ai giochi per console, compresi gli ultimi titoli di successo e i classici intramontabili. Il nostro sito Ã¨ facile da navigare e potrete trovare ciÃ² che cercate in pochi clic. Siamo appassionati di videogiochi come voi, quindi ci impegniamo a fornirvi un'esperienza di acquisto eccezionale e a farvi divertire durante lo shopping. <br> Grazie per averci scelto e buon gioco!</p>";
   	echo "</div>";
    echo "</div>";
    echo "<div class='back side'>";
    echo "<div class='content'>";
    echo "<h1>Enter your credentials</h1>";
    echo "<form action='creazione_account.php' method='post'>";
    echo "<input type=hidden name=AZIONE value=INSERISCI>";
    echo "<label>Tuo cognome </label>";
    echo "<input type='text' placeholder='Cognome' name='cognome'>";
    echo "<label>Tuo nome</label>";
    echo "<input type='text' placeholder='Nome' name='nome'>";
    echo "<label>Tuo telefono</label>";
    echo "<input type='text' placeholder='Telefono' name='telefono'>";
    echo "<label>Tua via</label>";
    echo "<input type='text' placeholder='Via' name='via'>";
    echo "<label>Tua cittÃ </label>";
    echo "<input type='text' placeholder='CittÃ ' name='citta'>";
    echo "<label>Tuo CAP</label>";
    echo "<input type='text' placeholder='CAP' name='cap'>";
    echo "<label>Tua E-mail</label>";
    echo "<input type='text' placeholder='E-mail' name='email'>";
    echo "<label>Tua password</label>";
    echo "<input type='password' placeholder='Password' name='password'>";
    echo "<input type='submit' value='Done'>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    } if($AZIONE=="INSERISCI"){
    	$Cognome=$_POST["cognome"];
        $Nome=$_POST["nome"];
        $Telefono=$_POST["telefono"];
        $Via=$_POST["via"];
        $Citta=$_POST["citta"];
        $Cap=$_POST["cap"];
        $Email=$_POST["email"];
        $Password=$_POST["password"];
        if(($Cognome=='') || ($Nome=='') || ($Telefono=='') || ($Via=='') || ($Citta=='')|| ($Cap=='')|| ($Email=='')|| ($Password=='')){
        	print "<center><h2>Inserimento annullato. Dati non corretti</h2>";
            print "<a href='elenco.php' target='_blank'>Clicca qui per tornare nell'elenco</a>";
        } else {
    //verifico la correttezza degli username e password inseriti
    $servername = "localhost";
    $username = "dido29";
    $password = "";
    $database = "my_dido29";
   
    //connessione database
    $mysqli = new mysqli($servername, $username, $password, $database);  
    if ($mysqli -> connect_errno ){
    echo "Failed to connect to MySQL: ". $mysqli ->connect_errno;
    exit();
    }
   	
    // creo la domanda
    // creo la domanda
    $query="INSERT INTO `my_dido29`.`cliente` (`email`,`password`,`cognome`,`nome`,`telefono`,`citta`,`cap`,`via`) 
    VALUES('".$Email."','".$Password."','".$Cognome."','".$Nome."','".$Telefono."','".$Citta."','".$Cap."','".$Via."');";
   
     //se esiste il record, allora l'utente e autenticato
	$result=$mysqli -> query($query);
    
        setcookie("email",$_POST["email"],time()+(86400*30),"/");
        setcookie("password",$_POST["password"],time()+(86400*30),"/");
        print $query;
        $mysqli -> close();
      		echo '<script type="text/javascript">
              function redirezionamento() {
              location.href = "https://dido29.altervista.org/e-commerce/login.php";
              }
              window.setTimeout("redirezionamento()", 100);
              </script>';
				print "Inserimento Effettuato";
			}
           }
?>
</body>
</html>