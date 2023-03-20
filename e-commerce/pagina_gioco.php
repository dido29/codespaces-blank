<html>
<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  			<link rel="stylesheet" href="style.css">
          	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
            <link rel="stylesheet" href="stile_carrello.css">
                <style>
* {
  box-sizing: border-box;
}
/* Full Star Icon */
.star {
  background-image: url('https://img.icons8.com/color/48/null/filled-star--v1.png');
  background-repeat: no-repeat;
  display: inline-block;
  height: 48px;
  width: 48px;
}

/* Half Star Icon */
.half-voted {
  background-image: url('https://img.icons8.com/external-tal-revivo-shadow-tal-revivo/48/null/external-half-star-ratings-for-below-the-average-performance-votes-shadow-tal-revivo.png');
  background-repeat: no-repeat;
  display: inline-block;
  height: 48px;
  width: 48px;
}

/* Empty Star Icon */
.star:not(.voted):not(.half-voted) {
  background-image: url('https://img.icons8.com/external-those-icons-lineal-color-those-icons/48/null/external-Star-vote-and-reward-those-icons-lineal-color-those-icons-5.png');
  background-repeat: no-repeat;
  display: inline-block;
  height: 48px;
  width: 48px;
}

body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
}

.product-image {
  flex: 1 1 50%;
  padding: 20px;
}

.product-image img {
  margin-left:201px;
  width: 400px;
  height: 550px;
}

.product-info {
  flex: 1 1 50%;
  padding: 20px;
}

.product-info h1 {
  font-size: 2em;
  margin-top: 0;
}

.product-info p {
  font-size: 1.2em;
}

.product-info .price {
  color: red;
  font-weight: bold;
}

.product-info .description {
  margin-top:50px;
}
.product-info .description_r {
  margin-top:8px;
}
.product-info form {
  padding:30px;
  margin-top: 250px;
}

.product-info label {
  display: block;
  margin-bottom: 10px;
}

.product-info input[type="submit"] {
  width: auto;
  padding: 20px;
  margin-right: 10px;
  background-color: black;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}



.product-info input[type="submit"]:hover {
  background-color: gray;
}

    </style>
</head>
<body>
<?php
	if( isset($_GET['codice_prodotto']) || isset($_GET['n20'])) $codice_prodotto=$_GET['codice_prodotto']; {
        if(isset($_GET['n20']))  $codice_prodotto=$_GET['codice_prodotto'];
        print $codice_prodotto;
        //https://img.icons8.com/external-tal-revivo-shadow-tal-revivo/48/null/external-half-star-ratings-for-below-the-average-performance-votes-shadow-tal-revivo.png
?>
 <header>
    <h1 class="logo">GAME SCAM</h1>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Prodotti</a></li>
        <li><a href="#">Contatti</a></li>
        <li>
        	<div class="cart-dropdown">
            <a href="#" class="cart-icon" onclick="toggleCart()">
              <i class="fa fa-opencart"></i>
            </a>
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
            
            	if(isset($_GET['aggiungialcarrello'])){
                      //aggiungo al carrello
                      $codice_prodotto=$_GET["codice_prodotto"];
					  $pezzi_d_m=$_GET["pezzi_d_m"];
                      
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

                 }else{
                      $smt = "UPDATE `carrello` SET n_pezzi_acq = '$n_pezzi_acq' WHERE codice_prodotto = '$codice_prodotto' 
                      AND codice_cliente = '{$_COOKIE['codice_cliente']}'";
                      $mysqli ->query($smt);
                      }
                 }
   			}

			echo "<div class='cart-content' id='cart' style='display: none;' >
              		<ul class='cart-items'> ";
             $query="SELECT * FROM carrello INNER JOIN prodotto ON prodotto.codice_prodotto=carrello.codice_prodotto WHERE codice_cliente='".$_COOKIE['codice_cliente']."'"; 
              if ($result = $mysqli -> query($query)) { 
                  while($row = $result->fetch_array(MYSQLI_BOTH)) {
                    $nome_gioco = $row['nome']; 
                    $n_pezzi_acq = $row['n_pezzi_acq']; 
                    $codice_prodotto1 = $row['codice_prodotto']; 
                    $prezzo_tot = $row['prezzo']*$n_pezzi_acq; 
                    $totale+=$prezzo_tot;
					$immagine=$row['immagine'];
                    echo "
                    <div class='product'>
                    <li class='cart-item' id='prod_id".$codice_prodotto."'>
                    <img src='".$immagine."' alt='Item 1' widht=50%>
                      	<div class='cart-item-details'>
                          <h4 class='cart-item-title'>".$nome_gioco."</h4>
                          <p class='cart-item-price'>id prodotto: ".$codice_prodotto1."</p>
                          <p class='cart-item-price' id='price".$codice_prodotto1."'>prezzo $".$prezzo_tot."</p>";
                        
                        echo "<button class='add-to-cart' data-item-id='".$codice_prodotto1."' data-action='add'> +";
                        print "</button>";
                        echo "<span id='quantity".$codice_prodotto1."'>quantita: ".$n_pezzi_acq."</span>";
                        echo "<button class='remove-from-cart' data-item-id='".$codice_prodotto1."' data-action='remove'>-<br>";
                        echo "</button>
							  <button class='remove-prod cart-item-remove' data-item-id='".$codice_prodotto1."' data-action='remove_prod'>remove</button>
                        </div>
					</li>"
                    ;
                  }
                  $result->free();
                   echo "<script src='carrello.js'></script>
                   <span id='tot".$_COOKIE['codice_cliente']."' style='margin-bottom:4px;'>totale carrello $".$totale."</span>";
                        print "
                        <form action=pagamento.php method=post>
                        <input class='cart-checkout' type=submit name=n3 value='Checkout'>
                        </form>
                        </div>";
                        print "
                        </ul></div>";
                     
              }

            print '
            <script>
              function toggleCart() {
                    var cart = document.getElementById("cart");
                    if (cart.style.display === "block") {
                      cart.style.display = "none";
                    } else {
                      cart.style.display = "block";
                    }
            	}
                </script>';
            ?>
          </div>
        </li>
      </ul>
   </nav>
  </header>
<main>
<div class="container">
<?php	
            // cambia il codice
    $smt3="SELECT * FROM prodotto WHERE codice_prodotto='".$codice_prodotto."'";
    $result=$mysqli -> query($smt3);
      while($row = $result->fetch_array(MYSQLI_BOTH)) {
      $pezzi_d_m=$row['pezzi_d_m'];
      $codice_prodotto=$row['codice_prodotto'];
      $immagine=$row['immagine'];
      $prezzo=$row['prezzo'];
      $descrizione_b=$row['descrizione_b'];
      			
      print'
              <div class="product-image">
        		<img src= '.$immagine.'><br>
              </div>
            ';  
      print'                                    
              <div class="product-info">
              	<div style="margin-left:201px">
                  <h1>'.$row['nome'].'</h1>          
      ';
      
      $query = "SELECT * FROM recensioni WHERE codice_prodotto = ".$codice_prodotto."";
  	  $result2 = $mysqli -> query($query);
	  if ($result2->num_rows > 0) {
      	while($row = $result2->fetch_array(MYSQLI_BOTH)) {
        	$voto=$row['voto'];
            $cont+=1;
            $voto_tot+=$voto;
        }
        $voto_medio=$voto_tot/$cont;
      }
      
        print '<div class="stars" id="vote-123" data-idprod="'.$codice_prodotto.'" data-idcliente="'.$_COOKIE['codice_cliente'].'">';
        for($i=1; $i<=5; $i++) {
          $star_class = "star";
          if($i <= floor($voto_medio)) {
            $star_class .= " voted";
          } else if(($i - $voto_medio) <= 0.5) {
            $star_class .= " half-voted";
          }
          print '<span class="'.$star_class.'" data-value="'.$i.'"></span>';
        }
        print $voto_medio. '%';
        print '</div>';  
        
    print'
    					<p class="description_r">recensito da '.$cont.' persone</p>
                        <p class="price">Prezzo: €'.$prezzo.'</p>
                        <p class="description">Descrizione prodotto breve: '.$descrizione_b.'</p>
                        <form action=index.php method=post>
                        <input type=hidden name=aggiungialcarrello value=1>
                        <input type=hidden name=codice_prodotto value='.$codice_prodotto.'>
                        <input type=hidden name=pezzi_d_m value='.$pezzi_d_m.'>
                        <input type=submit name="n1" value="aggiungi al carrello" onclick="toggleCart()">
                        </form>
                      </div>
                    </div>
	';  
    }          
    // Retrieve the value of $cont for this product from the session, or initialize it to 0 if it doesn't exist
    print "
    <script>
    const stars = document.querySelectorAll('.star');

      stars.forEach(star => {
        star.addEventListener('click', () => {
          const voteId = star.parentElement.id;
          const idprod = star.parentElement.getAttribute('data-idprod');
          const idcliente = star.parentElement.getAttribute('data-idcliente');
          const voteValue = star.getAttribute('data-value');

          // mostra l'alert di conferma
          const confirmation = confirm('Sei sicuro di voler dare ' + voteValue + ' stelle?');

          if (confirmation) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'submit_vote.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
              if (xhr.status === 200 && xhr.responseText !== 'error') {
                const response = JSON.parse(xhr.responseText);
                console.log(xhr.responseText);
                if (response[0] === false) {
                  // user has already voted for this product
                  stars.forEach(star => star.classList.add('disabled'));
                  alert('Hai già votato per questo prodotto. Grazie per il tuo feedback!');
                } else {
                  // user has not voted for this product yet
                  alert('Voto registrato con successo!');
                  stars.forEach(s => {
                    s.style.pointerEvents = 'none'; // disabilita la possibilità di votare di nuovo
                  });
                    }
              } else {
                // handle error response
                alert('Si è verificato un errore durante la registrazione del voto.');
              }
            };
            xhr.send('vote_id=' + voteId + '&vote_value=' + voteValue + '&id_prod=' + idprod + '&id_cliente=' + idcliente);
          }
        });
      });

		
    </script>
  ";

  
  if(isset($_POST['n20'])){
        print "<hr>";
   		if($pezzi_d_m==0){
      print "esaurito<hr>";
    }
   } 
?>
</div>
</main>
<footer>
    <p>&copy; 2023 GAME SCAM. Tutti i diritti riservati.</p>
  </footer>
<?php
}
?>
</body>
</html>
