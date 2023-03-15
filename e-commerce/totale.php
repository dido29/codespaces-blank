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

    		$action = $_GET['action'];
    
            if($action=='add'){  
   			$query="SELECT * FROM carrello INNER JOIN prodotto ON prodotto.codice_prodotto=carrello.codice_prodotto WHERE codice_cliente='".$_COOKIE['codice_cliente']."'"; 
                if ($result = $mysqli -> query($query)) {
                    while($row = $result->fetch_array(MYSQLI_BOTH)){
                        $n_pezzi_acq=$row['n_pezzi_acq'];
                        $prezzo_tot=$row['prezzo']*$n_pezzi_acq;
                        $totale+=$prezzo_tot;
                    }
                              $result->free();
                  $variables1 = array('totale' => $totale, 'id' => $_COOKIE['codice_cliente'], 'n_pezzi_acq' => $n_pezzi_acq);
                  echo json_encode($variables1);
                }
			}else{
            	if($action=='remove'){
                $query="SELECT * FROM carrello INNER JOIN prodotto ON prodotto.codice_prodotto=carrello.codice_prodotto WHERE codice_cliente='".$_COOKIE['codice_cliente']."'"; 
                if ($result = $mysqli -> query($query)) {
                    while($row = $result->fetch_array(MYSQLI_BOTH)){
                        $n_pezzi_acq=$row['n_pezzi_acq'];
                        $prezzo_tot=$row['prezzo']*$n_pezzi_acq;
                        $totale+=$prezzo_tot;
                    }
                              $result->free();
                  $variables = array('totale' => $totale , 'id' => $_COOKIE['codice_cliente'], 'n_pezzi_acq' => $n_pezzi_acq);
                  echo json_encode($variables);
                }
                
                
                }
            }
            	if($action=='remove_prod'){
                $query="SELECT * FROM carrello INNER JOIN prodotto ON prodotto.codice_prodotto=carrello.codice_prodotto WHERE codice_cliente='".$_COOKIE['codice_cliente']."'"; 
                if ($result = $mysqli -> query($query)) {
                    while($row = $result->fetch_array(MYSQLI_BOTH)){
                        $n_pezzi_acq=$row['n_pezzi_acq'];
                        $prezzo_tot=$row['prezzo']*$n_pezzi_acq;
                        $totale+=$prezzo_tot;
                    }
                              $result->free();
                  $variables2 = array('totale' => $totale , 'id' => $_COOKIE['codice_cliente'], 'n_pezzi_acq' => $n_pezzi_acq);
                  echo json_encode($variables2);
                }
                
                
                }
			
?>