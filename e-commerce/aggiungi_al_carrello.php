<?php
            
             $servername = "localhost";
             $username = "dido29";
             $password = "";
             $database = "my_dido29";

             $mysqli = new mysqli($servername, $usermane, $password, $database);  
             if ($mysqli -> connect_errno ){
               echo "Failed to connect to MySQL: ". $mysqli ->connect_errno;
               exit();
             }
			
            session_start();
            
            	if(isset($_POST['aggiungialcarrello'])){
                      //aggiungo al carrello
                      $codice_prodotto=$_POST["codice_prodotto"];
					  $pezzi_d_m=$_POST["pezzi_d_m"];
                      
                      // verifico presenza nel carrello del cliente il prodotto che sto inserendo e eventualmente ne prelevo il numero
                      $query = "SELECT * FROM carrello WHERE codice_cliente='".$_COOKIE['codice_cliente']."' AND codice_prodotto='".$codice_prodotto."' "; 
                    $result = $mysqli -> query($query);
                    $n_pezzi_acq=0;
                    if ($result->num_rows > 0) {
                        // Il gioco è già nel carrello: aggiorna la quantità
                        $row = $result->fetch_assoc();
                        $n_pezzi_acq = $row['n_pezzi_acq'];
                    }
                    $n_pezzi_acq+=1;

			if ($pezzi_d_m >= $n_pezzi_acq) {
                  if($n_pezzi_acq==1){
                  $query = "INSERT INTO `carrello` (codice_prodotto, codice_cliente, n_pezzi_acq) 
                  VALUES ($codice_prodotto, '{$_COOKIE['codice_cliente']}',$n_pezzi_acq)";
                    $mysqli -> query($query);
                    $response = array('success' => true, 'message' => 'Prodotto aggiunto al carrello.');
                 }else{
                    $smt = "UPDATE `carrello` SET n_pezzi_acq = '$n_pezzi_acq' WHERE codice_prodotto = '$codice_prodotto' 
                      AND codice_cliente = '{$_COOKIE['codice_cliente']}'";
                    $mysqli ->query($smt);
                    $response = array('success' => true, 'message' => 'Quantità aggiornata.');
                      }
                 }
   			}
            echo json_encode($response);

?>