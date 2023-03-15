<?php	

session_start();

  if (!isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = array();
  }
  $_SESSION['cont']=$_POST['contValue'];
  $codice_prodotto = $_POST['codice_prodotto'];
  $action = $_POST['action'];
  
  // Connessione al database
  $servername = "localhost";
  $username = "dido29";
  $password = "";
  $database = "my_dido29";
  $mysqli = new mysqli($servername, $username, $password, $database);

  // Aggiungi il prodotto al carrello
  if ($action === 'add') {
    $smt3 = "SELECT * FROM prodotto WHERE codice_prodotto='$codice_prodotto'";
    $result = $mysqli->query($smt3);
    if ($row = $result->fetch_assoc()) {
      $prezzo = $row['prezzo'];
      $nome_gioco = $row['nome'];
      $pezzi_d_m = $row['pezzi_d_m'];
      }
   $query="SELECT * FROM carrello INNER JOIN prodotto ON prodotto.codice_prodotto=carrello.codice_prodotto WHERE codice_cliente='".$_COOKIE['codice_cliente']."' AND carrello.codice_prodotto='".$codice_prodotto."'"; 
      $result = $mysqli->query($query);

      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $n_pezzi_acq = $row['n_pezzi_acq'] + 1;
          $prezzo_totale = $prezzo * $n_pezzi_acq;
          $smt = "UPDATE `carrello` SET n_pezzi_acq = '$n_pezzi_acq' WHERE codice_prodotto = '$codice_prodotto' AND codice_cliente = '{$_COOKIE['codice_cliente']}'";
          $mysqli -> query($smt); 


      }

      //echo "<script>document.getElementById('quantita').innerHTML = '{$n_pezzi_acq}';</script>";
      $response = array('id' => $codice_prodotto , 'q' => $n_pezzi_acq , 'prez' => $prezzo_totale);
      echo json_encode($response);
      }
?>