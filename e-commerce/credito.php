<?php

	

print "<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Credit Card Form</title>
    <link href='https://fonts.googleapis.com/css?family=Lato|Liu+Jian+Mao+Cao&display=swap' rel='stylesheet'>
    <link rel='stylesheet' href='CreditoStyle.css'>
</head>";

print "<body>

    <div class='container' >

        <section class='card' id='card'>
        
            <div class='front'>

                <div class='brand-logo' id='brand-logo'>
                    <img src='https://60f999bacb.cbaul-cdnwnd.com/668a2c82a51d973a7ed0a3e5d9adb0fe/200000682-6586966841/Visa_logo.png?ph=60f999bacb' alt=''>
                </div>

                <img src='https://raw.githubusercontent.com/falconmasters/formulario-tarjeta-credito-3d/master/img/chip-tarjeta.png' class='chip'>

                <div class='details'>

                    <div class='group' id='number'>
                        <p class='label'>Card Number</p>
                        <p class='number'>#### #### #### ####</p>
                    
                </div>
                    
                    <div class='flexbox'>

                        <div class='group' id='name'>
                            <p class='label'> Card's Holder </p>
                            <p class='name'>John Doe</p>
                        </div>

                        <div class='group' id='expiration'>
                            <p class='label'>Expiration</p>
                            <p class='expiration'> <span class='month'>MM</span> / <span class='year'>YY</span> </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class='back'>
                <div class='magnetic-bar'></div>
                
                <div class='details'>
                    <div class='group' id='signature'>
                        <p class='label'>Signature</p>
                        <div class='signature'>
                            <p></p>
                        </div>
                    </div>

                    <div class='group' id='ccv'>
                        <p class='label'>CCV</p>
                        <p class='ccv'></p>
                    </div>

                </div>

                <p class='legend'>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda dicta quos quas porro fuga, accusamus necessitatibus expedita illo, ipsum blanditiis quaerat deserunt illum minima ex distinctio veritatis aliquid, ipsam ut.</p>
                <a href='#' class='bank-link'>http://dabank.onion</a>

            </div>

        </section>

        <!-- Container Button to open the form -->

        <div class='container-btn'>
            <button class='btn-open-form' id='btn-open-form'>
                <i class='fas fa-plus'></i>
            </button>
        </div>

        <!-- Form -->
        <form action='credito.php' id='card-form' class='card-form' method=post>

            <div class='group'>
                <label for='inputNumber'>Card Number</label>
                <input type='text' id='inputNumber' name=inputNumber maxlength='19' autocomplete='off'>
            </div>

            <div class='group'>
                <label for='inputHolder'>Card's Holder Name</label>
                <input type='text' id='inputHolder' name=inputHolder maxlength='19' autocomplete='off'>
            </div>

            <div class='flexbox'>
                <div class='group expire'>
                    <label for='selectMonth'>Expiration</label>
                    <div class='flexbox'>
                        <div class='group-select'>
                            <select name='month' id='selectMonth' >
                                <option disabled selected> Month </option>                               
                            </select>
                            <i class='fas fa-angle-down'></i>
                        </div>
                        <div class='group-select'>
                            <select name='year' id='selectYear'>
                                <option disabled selected> Year </option>
                            </select>
                            <i class='fas fa-angle-down'></i>
                        </div>
                    </div>
                </div>
                <div class='group ccv'>
                    <label for='inputCCV'>CVV</label>
                    <input type='text' id='inputCCV' name=inputCCV maxlength='3'>
                </div>
            </div>
            <input type='submit' class='btn-submit'>
            <input type=hidden name=azione value=inserisci>";

 

$AZIONE="";

if(isset($_POST['azione']))                           $AZIONE=$_POST['azione'];      

if($AZIONE=="inserisci"){

		$N_carta=$_POST["inputNumber"];
        $intestatario=$_POST["inputHolder"];
        $selectMonth=$_POST["month"];
        $selectYear=$_POST["year"];
        $cvv=$_POST["inputCCV"];

        if(($intestatario == '') || ($N_carta == '') || ($selectMonth == '') || ($selectYear == '') || ($cvv == '')){
               print "<center><h2>Inserimento annullato. Dati non corretti</h2>";
        } else {

        //dati connessione database altervista

         $servername = "localhost";
         $username = "dido29";
         $password = "";
         $database = "my_dido29";

        //connetto al database

        $mysqli = new mysqli($servername,$username,$password,$database);

        //verifico la connesssione

        if ($mysqli -> connect_errno){
               echo"Failied to connect to MYSQL: " . $mysqli -> connect_error;
            exit();
        }
        
        $query="SELECT * FROM cliente WHERE email='".$_COOKIE["email"]."'AND password='".$_COOKIE["password"]."'";
        $result=$mysqli -> query($query);
        if ($row = $result->fetch_assoc()){
          $id_utente=$row['codice_cliente'];
		}
        
		setcookie("codice_cliente",$id_utente,time()+(86400*30),"/");

        //creo la querry
        $query="INSERT INTO `my_dido29`.`carta_credito1` (`intestatario`,`N_carta`,`selectMonth`,`selectYear`,`cvv`,`codice_cliente`) VALUES

        ('".$intestatario."','".$N_carta."','".$selectMonth."','".$selectYear."','".$cvv."','".$id_utente."');";
        print $query;

        $result =$mysqli -> query($query);
        
        $smt3="SELECT * FROM carta_credito1 WHERE codice_cliente='".$id_utente."'";
        $result=$mysqli -> query($smt3);
        if ($row = $result->fetch_assoc()){
          $id_carta=$row['id_carta'];
		}

        $smt1="UPDATE `cliente` SET cartacredito='".$id_carta."' WHERE codice_cliente='".$id_utente."'";
        print $smt1;
		$mysqli -> query($smt1);
        $mysqli -> close();
        
		

       	echo '<script type="text/javascript">
              function redirezionamento() {
              location.href = "login.php";
              }
              window.setTimeout("redirezionamento()", 113100);
              </script>';

        
    };
    };
        print"</form>
        <script src='https://kit.fontawesome.com/2c36e9b7b1.js' crossorigin='anonymous'></script>
                    <script src='Credito.js'></script>
    </div>

</body>
</html>";

?>
