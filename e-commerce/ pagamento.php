<html>
<head>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<style>
		/* definizione stile div principale */
    #main {
      width: 80%;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ccc;
    }

    /* definizione stile div header */
    #header {
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      padding: 10px;
      background-color: #f0f0f0;
      border-bottom: 1px solid #ccc;
    }

    /* definizione stile div contenuto */
    #content {
      font-size: 16px;
      line-height: 1.5;
      padding: 10px;
      background-color: #fff;
    }

    /* definizione stile div footer */
    #footer {
      font-size: 14px;
      text-align: center;
      padding: 10px;
      background-color: #f0f0f0;
      border-top: 1px solid #ccc;
    }
    </style>
</head>
<body>
<div id="main">
  <a href='index.php'><div id="header">
    Pagamento
  </div></a>
  <div id="content">
  <?php		
  $totale=0;
  
    session_start();
    if(isset($_POST['n3'])){

          print "<hr>";

              $servername = "localhost";
              $username = "dido29";
              $password = "";
              $database = "my_dido29";

              $mysqli = new mysqli($servername, $usermane, $password, $database);  
              if ($mysqli -> connect_errno ){
                echo "Failed to connect to MySQL: ". $mysqli ->connect_errno;
                exit();
              }
   			$query="SELECT * FROM carrello INNER JOIN prodotto ON prodotto.codice_prodotto=carrello.codice_prodotto WHERE codice_cliente='".$_COOKIE['codice_cliente']."'"; 
                if ($result = $mysqli -> query($query)) {
                    while($row = $result->fetch_array(MYSQLI_BOTH)){
                        $nome_gioco=$row['nome'];
                        $n_pezzi_acq=$row['n_pezzi_acq'];
                        $prezzo_tot=$row['prezzo']*$n_pezzi_acq;
                        $codice_prodotto=$row['codice_prodotto'];
                        $totale+=$prezzo_tot;
						echo "<div class='product'>
                        <hr>codice prodotto: ".$codice_prodotto."<br>gioco :".$nome_gioco."<br>
                        <span id='price".$codice_prodotto."'>prezzo: ".$prezzo_tot."<br></span>";
                        echo "<button class='add-to-cart' data-item-id='".$codice_prodotto."' data-action='add'> +";
                        print "</button>";
                        echo "<span id='quantity".$codice_prodotto."'>quantita: ".$n_pezzi_acq."</span>";
                        echo "<button class='remove-from-cart' data-item-id='".$codice_prodotto."' data-action='remove'>-";
                        echo "</button><hr>";
                    }
                              $result->free();
                              print "<span id='tot".$_COOKIE['codice_cliente']."'>totale carrello: ".$totale."</span></div>
                              <form action=pagamento.php method=POST>
                              <input type=submit name=n10 value=paga>
                              </form>
                              ";
                              $_SESSION['totale']=$totale;
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
                });

      </script>
    ";
    
		if(isset($_POST['n10'])){	
        
        	  $servername = "localhost";
              $username = "dido29";
              $password = "";
              $database = "my_dido29";

              $mysqli = new mysqli($servername, $usermane, $password, $database);  
              if ($mysqli -> connect_errno ){
                echo "Failed to connect to MySQL: ". $mysqli ->connect_errno;
                exit();
              }
             $codice_movimento=0;
            $smt="SELECT codice_movimento FROM acquisti WHERE codice_movimento=(SELECT MAX(codice_movimento) FROM acquisti)";
            $result=$mysqli -> query($smt);
            if ($row = $result->fetch_array(MYSQLI_BOTH)){
              $codice_movimento=$row['codice_movimento'];
              $codice_movimento=$codice_movimento+1;
            }

                  
                    
                    
            $totale=0;
   			$query="SELECT * FROM carrello INNER JOIN prodotto ON prodotto.codice_prodotto=carrello.codice_prodotto WHERE codice_cliente='".$_COOKIE['codice_cliente']."'"; 
              if ($result = $mysqli -> query($query)) {
                  while($row = $result->fetch_array(MYSQLI_BOTH)){
                      $prezzo_p=$row['prezzo'];
                      $nome_gioco=$row['nome'];
                      $n_pezzi_acq=$row['n_pezzi_acq'];
                      $codice_prodotto=$row['codice_prodotto'];
                      $pezzi_d_m=$row['pezzi_d_m'];
                      $totale+=$$n_pezzi_acq*$prezzo_tot;
						
                       	 $smt = "INSERT INTO acquisti (codice_movimento, codice_prodotto, prezzo_p, codice_cliente, nome_prod, n_pezzi_acq,data_orario) 
                         VALUES ($codice_movimento,$codice_prodotto,$prezzo_p,'{$_COOKIE['codice_cliente']}','$nome_gioco',$n_pezzi_acq,NOW())";
                         $result2 =$mysqli -> query($smt);
                         print $smt;
                      
                       if($pezzi_d_m>0){
                        $tm=$pezzi_d_m-$n_pezzi_acq;
                      }else{
                        print "esaurito<hr>";
                      }
                      
                      $query4="UPDATE `prodotto` SET pezzi_d_m='".$tm."' WHERE codice_prodotto='".$codice_prodotto."'";
                      print "<br>".$query4;
                      $mysqli -> query($query4);
                      
                  }
                            $result->free();
                          }
          

                    $query = "DELETE FROM carrello WHERE codice_cliente ='".$_COOKIE['codice_cliente']."'";
                    $result = $mysqli->query($query);
                    if ($result) {
                      // la query di eliminazione è stata eseguita con successo
                      echo "Dati eliminati con successo.";
                    } else {
                      // la query di eliminazione non è stata eseguita con successo
                      echo "Errore durante l'eliminazione dei dati: " . $mysqli->error;
                    }
                    
			$query="SELECT * FROM acquisti INNER JOIN carta_credito1 ON carta_credito1.codice_cliente=acquisti.codice_cliente WHERE 
            acquisti.codice_movimento='".$codice_movimento."'";
            if ($result = $mysqli -> query($query)) {
                  while($row = $result->fetch_array(MYSQLI_BOTH)){
						 $codice_movimento=$row['codice_movimento']	;
                         $id_carta=$row['id_carta'];
                  }
                  		 $result->free();
                         $totale=$_SESSION['totale'];
                  		 $smt = "INSERT INTO pagamento (codice_movimento,data_orario,totale,codice_cliente,id_carta) 
                         VALUES ($codice_movimento,NOW(),$totale,'{$_COOKIE['codice_cliente']}',$id_carta)";
                         $result2 =$mysqli -> query($smt);
                         print $smt;
            }
		}
            
  ?>
  </div>
  <div id="footer">
    Copyright © 2023 Nome del sito
  </div>
</div>
</body>
</html>