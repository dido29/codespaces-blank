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