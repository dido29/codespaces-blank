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
    $codice_prodotto = $_GET['codice_prodotto'];

    $action = $_GET['action'];
     
	if ($action === 'add') {
	$query="SELECT * FROM carrello WHERE codice_prodotto='".$codice_prodotto."' AND codice_cliente='".$_COOKIE['codice_cliente']."'"; 
   	if ($result = $mysqli -> query($query)) { 
    	while($row = $result->fetch_array(MYSQLI_BOTH)) {
          $n_pezzi_acq = $row['n_pezzi_acq']; 
          $smt3="SELECT * FROM prodotto WHERE codice_prodotto='".$codice_prodotto."'";
          $result2=$mysqli -> query($smt3);
          if ($row = $result2->fetch_assoc()){
            $pezzi_d_m=$row['pezzi_d_m'];
          }   
        }
        $result=$mysqli -> query($query);
    }
	
    $variables = array('id_cliente' => $_COOKIE['codice_cliente'] , 'codice_prodotto' => $codice_prodotto, 'pezzi_d_m' => $pezzi_d_m, 'n_pezzi_acq' => $n_pezzi_acq);
    echo json_encode($variables);
   }else{
	if ($action === 'remove') {
	$query="SELECT * FROM carrello WHERE codice_prodotto='".$codice_prodotto."' AND codice_cliente='".$_COOKIE['codice_cliente']."'"; 
   	if ($result = $mysqli -> query($query)) { 
    	while($row = $result->fetch_array(MYSQLI_BOTH)) {
          $n_pezzi_acq = $row['n_pezzi_acq']; 
          $smt3="SELECT * FROM prodotto WHERE codice_prodotto='".$codice_prodotto."'";
          $result2=$mysqli -> query($smt3);
          if ($row = $result2->fetch_assoc()){
            $pezzi_d_m=$row['pezzi_d_m'];
          }   
        }
        $result=$mysqli -> query($query);
    }
    $variables = array('id_cliente' => $_COOKIE['codice_cliente'] , 'codice_prodotto' => $codice_prodotto, 'pezzi_d_m' => $pezzi_d_m, 'n_pezzi_acq' => $n_pezzi_acq);
    echo json_encode($variables);
   	} 
   }
?>
