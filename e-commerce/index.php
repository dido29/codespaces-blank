<html>
<head>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  			<link rel="stylesheet" href="style.css">
          	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
			<link rel="stylesheet" href="stile_carrello.css">
           	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
            <style>
            .font{
            font-family: 'Noto Sans JP', sans-serif;
            }
            </style>
</head>
<body>
 <header>
    <h1 class="logo">GAME SCAM</h1>
    
    <!--Inserisce la nav bar-->
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expandend="false" aria-label="Toggle navigation">
            <span class="navbat-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <br><br>
                <div class="container mt-5">
                    <div class="form-row">
                        <div class="form-grop col-md-6 offset-md-3">
                            <label><b>Cosa stai cercando? </b></label>
                              <form id="search-form" action="prodotti.php" method="get" style="display:flex;">
                                  <input type="text" name="username" id="mainresponsible" placeholder="Cerca il tuo gioco..." class="form-control actions" required>
                                  <input type="hidden" name="codice_prodotto" id="codice_prodotto" value="">
                                  <input type="submit" name="n20" value="cerca" style="margin-left:3px;">
                              </form>
                              <script>
                              $(function() {
                                $(function() {
                                $('#mainresponsible').autocomplete({
                                  source: function(request, response) {
                                    $.getJSON('fetch_autosearch.php', { term: request.term }, function(products) {
                                      response($.map(products, function(product) {
                                        return {
                                          label: product.name,
                                          value: product.name,
                                          codice_prodotto: product.id
                                        }
                                      }));
                                    });
                                  },
                                  select: function(event, ui) {
                                    window.location.href = 'pagina_gioco.php?codice_prodotto=' + ui.item.codice_prodotto;
                                  }
                                }).data('ui-autocomplete')._renderItem = function(ul, item) {
                                  return $('<li>').append('<div>' + item.label + '</div>').appendTo(ul);
                                };
                              });

                              });
                              
                             $(function() {
  $("#codice_prodotto").on("change", function() {
    // Aggiorna il valore dell'input hidden quando l'utente seleziona un'opzione dall'autocomplete
    $("#codice_prodotto").val(this.value);
  });

  $("#search-form").on("submit", function() {
    // Aggiorna il valore dell'input hidden quando l'utente invia il form
    $("#codice_prodotto").val(getSearchValue());
  });

  function getSearchValue() {
    var searchValue = $("#mainresponsible").val();
    return searchValue;
  }

  // Inizializza il plugin jQuery Autocomplete
  $("#codice_prodotto").autocomplete({
    source: 'fetch_autosearch1.php',
    select: function(event, ui) {
      // Aggiorna il valore dell'input text quando l'utente seleziona un'opzione dall'autocomplete
      $("#mainresponsible").val(ui.item.label);
      // Aggiorna il valore dell'input hidden
      $("#codice_prodotto").val(ui.item.value);
      return false;
    }
  });
});


                              </script>
                        </div>
                    </div>
                </div>
            <script type="text/javascript">
                $(function(){
                $( "#codice_prodotto").autocomplete({
                    source: 'fetch_autosearch1.php',
                });   
                });
            </script>
        </div>	
      <ul>
        <li><a href="index.php">Home</a></li>
        <li>
        <form action=prodotti.php method=post>
        <input type=submit name=invio_p1 value='Prodotti'>
        </form>
        </li>
        <li><a href="#">Contatti</a></li>
        <li>
        <!--crea l'oggetto della carta-->
        	<div class="cart-dropdown">
            <a href="#" class="cart-icon" onclick="toggleCart()">
              <i class="fa fa-opencart"></i>
            </a>
            <?php
            // inserisco i dati del server
             $servername = "localhost";
             $username = "dido29";
             $password = "";
             $database = "my_dido29";
             
            // controllo se ho l'accesso al server sennò non funziona
             $mysqli = new mysqli($servername, $usermane, $password, $database);  
             if ($mysqli -> connect_errno ){
               echo "Failed to connect to MySQL: ". $mysqli ->connect_errno;
               exit();
             }
			
            // incomincio la sessione
            session_start();
            	
                //controllo se è stato premuto aggiungi ala carello
            	if(isset($_POST['aggiungialcarrello'])){
                      //aggiungo al carrello il codice del prodotto e i pezzi disponibili in magazzino
                      $codice_prodotto=$_POST["codice_prodotto"];
					  $pezzi_d_m=$_POST["pezzi_d_m"];
                      
                      // verifico presenza nel carrello del cliente il prodotto che sto inserendo e eventualmente ne prelevo il numero e il risultato lo rimando alla query
                      $query = "SELECT * FROM carrello WHERE codice_cliente='".$_COOKIE['codice_cliente']."' AND codice_prodotto='".$codice_prodotto."' "; 
                    $result = $mysqli -> query($query);
                    
                    // come numero dei pezzi acquistati parte da zero 
                    $n_pezzi_acq=0;
                    
                    // se il numero delle righe è maggiore di zero
                    if ($result->num_rows > 0) {
                    
                        // Il gioco è già nel carrello: aggiorna la quantità
                        $row = $result->fetch_assoc();
                        
                        // Associa il numero dei pezzi acquistati nella variabile dei numeri pezzi 
                        $n_pezzi_acq = $row['n_pezzi_acq'];
                    }
                    
                    // Se invece il numero è maggiore di zero il numero dei pezzi viene incrementato di 1
                    $n_pezzi_acq+=1;
			
            // se il numero dei pezzi in magazzino è maggiore o uguale al numero dei pezzi acquistati
			if ($pezzi_d_m >= $n_pezzi_acq) {
            
            	  // se il numero dei pezzi acquistati è uguale a 1
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
                    $codice_prodotto = $row['codice_prodotto']; 
                    $prezzo_tot = $row['prezzo']*$n_pezzi_acq; 
                    $totale+=$prezzo_tot;
                    $immagine=$row['immagine'];
                    
                    echo "
                    <div class='product'>
                    <li class='cart-item' id='prod_id".$codice_prodotto."'>
                    <img src='".$immagine."' alt='Item 1' widht=50%>
                      	<div class='cart-item-details'>
                          <h4 class='cart-item-title'>".$nome_gioco."</h4>
                          <p class='cart-item-price'>id prodotto: ".$codice_prodotto."</p>
                          <p class='cart-item-price' id='price".$codice_prodotto."'>prezzo $".$prezzo_tot."</p>";
                        
                        echo "<button class='add-to-cart' data-item-id='".$codice_prodotto."' data-action='add'> +";
                        print "</button>";
                        echo "<span id='quantity".$codice_prodotto."'>quantita: ".$n_pezzi_acq."</span>";
                        echo "<button class='remove-from-cart' data-item-id='".$codice_prodotto."' data-action='remove'>-<br>";
                        echo "</button>";
                        print "<button class='remove-prod cart-item-remove' data-item-id='".$codice_prodotto."' data-action='remove_prod'>remove</button>

                        </div>
					</li>";
                  }
                  $result->free();
                   echo "<span id='tot".$_COOKIE['codice_cliente']."' style='margin-bottom:4px;'>totale carrello $".$totale."</span>";
                        print "
                        <form action=pagamento.php method=post>
                        <input class='cart-checkout' type=submit name=n3 value='Checkout'>
                        </form>
                        </div>";
                        print "
                        </ul></div>";
                     
              }

            print '<script>
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
  <div class="subheader">
    <h2>Benvenuto nel nostro negozio online!</h2>
  </div>
<main>
<?php	
//prodotti
    $smt3="SELECT * FROM prodotto";
    $result=$mysqli -> query($smt3);
	print "<ul class='product-list'>";
      while($row = $result->fetch_array(MYSQLI_BOTH)) {
      $pezzi_d_m=$row['pezzi_d_m'];
      $codice_prodotto=$row['codice_prodotto'];
      $immagine=$row['immagine'];
      	print "<li>";
        print "<img src= ".$immagine."><br>";
      	//print $row['nome']."<br>";
        print "<span class='font'>".$row['nome']."</span><br>";
        print "<form action=pagina_gioco.php method=get>
        	   <input type=hidden name=codice_prodotto value='".$codice_prodotto."'>
               <input type=submit name=n20 value='ciao'>
               </form>";
        print  $row['prezzo']."<hr>";
        print "<form action=index.php method=post>
        		<input type=hidden name=aggiungialcarrello value=1>
        		<input type=hidden name=codice_prodotto value='".$codice_prodotto."'>
                <input type=hidden name=pezzi_d_m value='".$pezzi_d_m."'>
        		<input type=submit name='n1' value='aggiungi al carrello' onclick='toggleCart()'>
                </form>
                </li>";
    	}
	print "</ul>";
    // Retrieve the value of $cont for this product from the session, or initialize it to 0 if it doesn't exist
    
  if(isset($_POST['n1'])){
        print "<hr>";
   		if($pezzi_d_m==0){
      print "esaurito<hr>";
    }
   } 
     
 	print "
      <script>
      
           $(document).ready(function() {

	$('.add-to-cart').click(function() {
       var button = $(this);
       var codice_prodotto = button.data('item-id');
       var action = button.data('action');
         console.log(codice_prodotto);
            $.ajax({
                 url: 'get_variables.php',
                 method: 'get',
                 data: { codice_prodotto: codice_prodotto, action: action},
                 success: function(data) {
                   var variables = JSON.parse(data);
                   var pezzi_d_m = parseInt(variables.pezzi_d_m.replace(/\D/g, ''), 10);
                   var n_pezzi_acq = parseInt(variables.n_pezzi_acq.replace(/\D/g, ''), 10);
                   console.log(pezzi_d_m);
                     console.log(n_pezzi_acq);
                   if (pezzi_d_m > n_pezzi_acq) { // controllo della quantità di pezzi
                     $.ajax({
                       url: 'add_to_cart.php',
                       method: 'post',
                       data: { codice_prodotto: codice_prodotto, action: action},
                       success: function(data) {
                         // Aggiorna il contenuto del carrello
                         $('#carrello').load(location.href + ' #carrello');
                         console.log(data);
                         var response;
                         try {
                           var response = JSON.parse(data);
                         } catch (e) {
                           console.error('Errore di parsing JSON: ' + e);
                           return;
                         }
                         document.getElementById('price'+response.id).innerHTML = 'prezzo $' + response.prez + '<br>';
                         document.getElementById('quantity'+response.id).innerHTML = 'quantità: ' + response.q;
                       },
                       error: function(jqXHR, textStatus, errorThrown) {
                         console.log(textStatus, errorThrown);
                       },
                       complete: function() {
                        $.ajax({
                            url: 'totale.php',
                            method: 'get',
                            data: { codice_prodotto: codice_prodotto, action: action},
                            success: function(data) {
                                var variables1 = JSON.parse(data);
                                var totale = parseInt(variables1.totale, 10);
                                document.getElementById('tot'+variables1.id).innerHTML ='totale carrello $' + variables1.totale + '<br>';
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                    }
                     });
                   }
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                 },
            });
         });


      $('.remove-from-cart').click(function() {
       var button = $(this);
       var codice_prodotto = button.data('item-id');
       var action = button.data('action');
         console.log(codice_prodotto);
       $.ajax({
         url: 'get_variables.php',
         method: 'get',
         data: { codice_prodotto: codice_prodotto, action: action},
         success: function(data) {
           var variables = JSON.parse(data);
           var pezzi_d_m = parseInt(variables.pezzi_d_m.replace(/\D/g, ''), 10);
           var n_pezzi_acq = parseInt(variables.n_pezzi_acq.replace(/\D/g, ''), 10);
           console.log(pezzi_d_m);
             console.log(n_pezzi_acq);
           if (n_pezzi_acq > 1) {
             $.ajax({
               url: 'remove-from-cart.php',
               method: 'post',
               data: { codice_prodotto: codice_prodotto, action: action},
               success: function(data) {
                 // Aggiorna il contenuto del carrello
                 $('#carrello').load(location.href + ' #carrello');
                 console.log(data);
                 var response;
                 try {
                   var response = JSON.parse(data);
                 } catch (e) {
                   console.error('Errore di parsing JSON: ' + e);
                   return;
                 }
                 document.getElementById('price'+response.id).innerHTML = 'prezzo $' + response.prez + '<br>';
                 document.getElementById('quantity'+response.id).innerHTML = 'quantità: ' + response.q;
               },
               error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
               },
               complete: function() {
                $.ajax({
                    url: 'totale.php',
                    method: 'get',
                    data: { codice_prodotto: codice_prodotto, action: action},
                    success: function(data) {
                        var variables1 = JSON.parse(data);
                        var totale = parseInt(variables1.totale, 10);
                        document.getElementById('tot'+variables1.id).innerHTML ='totale carrello $' + variables1.totale + '<br>';
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
             });
           }else{
               console.log('devi avere al meno un pezzo nel tuo carrello per acquistare questo prodotto')
           }
         },
         error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
         },
       });
     });
     
     $('.remove-prod').click(function() {
       var button = $(this);
       var codice_prodotto = button.data('item-id');
       var action = button.data('action');
         console.log(codice_prodotto);
          $.ajax({
            url: 'rimozione_gioco_carrello.php',
            method: 'post',
            data: { codice_prodotto: codice_prodotto, action: action},
            success: function(data) {
              // Aggiorna il contenuto del carrello
              $('#carrello').load(location.href + ' #carrello');
              console.log(data);
              var response;
              try {
                var response = JSON.parse(data);
              } catch (e) {
                console.error('Errore di parsing JSON: ' + e);
                return;
              }
              // prendi l'elemento con id 'prod_id' + codice_prodotto
              var itemToRemove = document.getElementById('prod_id' + codice_prodotto);

              // rimuovi l'elemento figlio
              itemToRemove.parentNode.removeChild(itemToRemove);

            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            },
            complete: function() {
             $.ajax({
                 url: 'totale.php',
                 method: 'get',
                 data: { codice_prodotto: codice_prodotto, action: action},
                 success: function(data) {
                     var variables2 = JSON.parse(data);
                     var totale = parseInt(variables2.totale, 10);
                     document.getElementById('tot'+variables2.id).innerHTML ='totale carrello $' + variables2.totale + '<br>';
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     console.log(textStatus, errorThrown);
                 }
                   });
               }
                });
        });

                });

      </script>
    ";
  
?>
</main>
<footer>
    <p>&copy; 2023 GAME SCAM. Tutti i diritti riservati.</p>
  </footer>
</body>
</html>
