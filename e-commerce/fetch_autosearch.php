<?php
require_once "db_autosearch.php";

if (isset($_GET['term'])){
  $query = "SELECT nome,codice_prodotto FROM prodotto WHERE nome LIKE '" . mysqli_real_escape_string($conn, $_GET['term']) . "%'";
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $nome=$row['nome'];
    $id=$row['codice_prodotto'];
    $myObj = new stdClass(prod);
    $myObj-> name = $nome;
    $myObj->id = $id;
    $myJSON[] = $myObj;
    $res = json_encode($myJSON);
  }
  
  echo $res;
}

?>
