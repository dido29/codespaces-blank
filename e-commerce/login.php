<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://dido29.altervista.org/e-commerce/style2.css">
    <title>Login cliente</title>
</head>
<body>
<?php
function Intestazione(){
	echo "<center>";
	echo "<em><h1>Benvenuto entra nel nostro sito</h1></em>";
    echo "<em><h1>Inserisci un account</h1></em>";
   	echo "</center>";
    }
    if (!isset($_cookie["email"])){ //mi sono gia autenticato?
    //Devo autenticarmi. creo il form di ingresso oppure memorizzo i cookie
    if(!isset($_POST["azione"])){
    //creo il form di ingresso
    Intestazione();
    //echo "<form class='login-form' action='login.php' method='post'>";
    echo "<div class='login-card'>";
    echo "<h2>Login</h2>";
    echo "<h3>Enter your credentials</h3>";
    echo "<form class='login-form' action='login.php' method='post'>";
    echo "<input type='text' placeholder='Email' name='email'><INPUT TYPE=hidden NAME=azione VALUE=inserisci>";
    echo "<input type='password' placeholder='Password' name='password'>";
    //echo "<a href='#'>Forget your password?</a>";
    echo "<button type='submit' name='login_submit' VALUE='entra'>LOGIN</button>";
    //echo "</div>";
    echo "</form>";
    echo "</div>";
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
    $query="SELECT * FROM cliente WHERE email='".$_POST["email"]."'AND password='".$_POST["password"]."'";
   
     //se esiste il record, allora l'utente e autenticato
	$result=$mysqli -> query($query);
    if ($row = $result->fetch_array(MYSQLI_BOTH)){
     // setcookie*
            setcookie("username",$_POST["email"],time()+(86400*30),"/");
            setcookie("password",$_POST["password"],time()+(86400*30),"/");
			setcookie("codice_cliente",$row["codice_cliente"],time()+(86400*30),"/");

      		echo '<script type="text/javascript">
              function redirezionamento() {
              location.href = "https://dido29.altervista.org/e-commerce/index.php";
              }
              window.setTimeout("redirezionamento()", 100);
              </script>';

	
           } else {
        echo "errore autenticazione.";
        }
    }
  } else {
  print "sei già autenticato con l'username ".$_COOKIE["username"];
}
?>
</body>
</html>
