<!DOCTYPE html>
<html>

    <?php
      include "php/config_stripe.php";
    ?>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Salvami la Vita</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name='viewport' content='width=device-width, initial-scale=1'>

  <link rel="apple-touch-icon" sizes="57x57" href="dist/img/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="dist/img/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="dist/img/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="dist/img/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="dist/img/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="dist/img/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="dist/img/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="dist/img/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="dist/img/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="dist/img/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="dist/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="dist/img/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="dist/img/favicon-16x16.png">
  <link rel="manifest" href="dist/img/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="dist/img/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <!-- Font Awesome -->
  <link rel='stylesheet' href='plugins/fontawesome-free/css/all.min.css'>
  <!-- Ionicons -->
  <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
  <!-- daterange picker -->
  <link rel='stylesheet' href='plugins/daterangepicker/daterangepicker.css'>
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel='stylesheet' href='plugins/icheck-bootstrap/icheck-bootstrap.min.css'>
  <!-- Bootstrap Color Picker -->
  <link rel='stylesheet' href='plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'>
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel='stylesheet' href='plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'>
  <!-- Select2 -->
  <link rel='stylesheet' href='plugins/select2/css/select2.min.css'>
  <link rel='stylesheet' href='plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'>
  <!-- Bootstrap4 Duallistbox -->
  <link rel='stylesheet' href='plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'>
  <!-- Theme style -->
  <link rel='stylesheet' href='dist/css/adminlte.min.css'>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700' rel='stylesheet'>
  <!-- my style -->
  <link rel='stylesheet' href='dist/css/myStyle.css'>

  <link rel="stylesheet" href="plugins/Croppie-2.6.4/croppie.css" />
  <script src="plugins/Croppie-2.6.4/croppie.js"></script>

   <!-- My functions -->
  <script src='dist/js/myApp.js'></script>

</head>
<body class='hold-transition sidebar-mini' onload='loadPricing()'>

  <script src="https://www.paypal.com/sdk/js?client-id=ATcnwlVkJFvtr8GRdjkfIJ9-I7BrTbrVAnaeZ9jV6FLyfv6UgO0FIx5lnO1E9l--XUS_BRLs0gRdhadV"> // Replace YOUR_SB_CLIENT_ID with your sandbox client ID
  </script>

  <div id="containerAlert" class="containerAlert">
      <i class="fas fa-2x fa-sync-alt fa-spin loader"></i>
  </div> 

<div class='wrapper'>

  <div class="row">

    <div class="col-md-6">
      <a class="nav-link text-primary" href='index.html'><p class="d-inline"></p><b>Salvami</b> la Vita</a> 
    </div>

    <div class="col-md-2 offset-md-6 mt-2">
      
    </div>

  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class='content'>
    <!-- Content Header (Page header) -->
    <section class='content-header'>
      <div class='container-fluid'>
        <div class='row mb-2'>
          <div class='col-sm-6'>
            <!-- <h1>Profile</h1> -->
            <h1>Abbonamento</h1>
          </div>
          <div class='col-sm-6'>
            <ol class='breadcrumb float-right'>
              <li class='breadcrumb-item'><a href='login.html'>Login</a></li>
              <li class='breadcrumb-item active'>Abbonamento</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class='content'>

      <div class='container-fluid'>

        <div class='row'>

          <div class='col'>

              <div class='row col'>

                  <div id="user_box_base" class="col-12 col-lg-4 d-none">
                    <div class="card card-primary card-outline">
                      <div class="card-body box-profile">
                    
                        <h3 class="text-center">BASE</h3>

                        <p class="text-center text-muted">Abbonamento base per un singolo anno</p>
        
                        <ul class="list-group list-group-unbordered mb-3">

                            <li class="list-group-item">
                              <b>Check-up</b> <a class="float-right">illimitati</a>
                            </li>
                            <li class="list-group-item">
                              <b>Scheda sanitaria</b> <a class="float-right">attivata</a>
                            </li>
                            <li class="list-group-item">
                              <b>Social</b> <a class="float-right">illimitato</a>
                            </li>
                            <li class="list-group-item">
                              <b>Durata</b> <a class="float-right">1 anno</a>
                            </li>

                        </ul>

                        <h1 class="price text-center text-primary font-weight-bold mb-0">14.99 ???</h1>
                        <p class="text-center text-muted mb-3">14.99 ???/anno</p>
 
                        <form action="php/subscription.php" method="post">
                          <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                              data-key="<?echo($stripe['publishable_key']);?>"
                              data-amount="1499"
                              data-currency="eur"
                              data-name="salvamilavita.com"
                              data-description="Abbonamento per anni 1"
                              data-email="service@salvamilavita.com"
                              data-image="dist/img/apple-icon.png"
                              data-locale="auto">
                          </script>
                          <script>
                            document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';
                          </script>
                            <input type="hidden" name="data-key" value="<?echo($stripe['publishable_key']);?>">
                            <input type="hidden" name="data-amount" value="1499" />
                            <input type="hidden" name="data-currency" value="eur" />
                            <input type="hidden" name="data-subscription" value="1" />
                            <input type="hidden" name="data-name" value="Abbonamento per anni 1" />
                            <input type="hidden" name="data-email" value="service@salvamilavita.com" />
                            <input type="hidden" name="" value="" />
                            <input id="baseCustomData" type="hidden" name="custom" value="" />
                            <input class="btn btn-primary btn-block font-weight-bold" type="submit" value="acquista" />
                        </form>

                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
                    
                  <div id="user_box_medium" class="col-12 col-lg-4 d-none">

                    <div class="ribbon-wrapper ribbon-lg">
                      <div class="ribbon bg-danger text-bg">
                        pi?? usato
                      </div>
                    </div>

                    <div class="card card-primary card-outline">
                      <div class="card-body box-profile">
                    
                        <h3 class="text-center">MEDIUM</h3>

                        <p class="text-center text-muted">Abbonamento medium per cinque anni</p>
        
                        <ul class="list-group list-group-unbordered mb-3">

                            <li class="list-group-item">
                              <b>Check-up</b> <a class="float-right">illimitati</a>
                            </li>
                            <li class="list-group-item">
                              <b>Scheda sanitaria</b> <a class="float-right">attivata</a>
                            </li>
                            <li class="list-group-item">
                              <b>Social</b> <a class="float-right">illimitato</a>
                            </li>
                            <li class="list-group-item">
                              <b>Durata</b> <a class="float-right">5 anni</a>
                            </li>

                        </ul>

                        <h1 class="price text-center text-primary font-weight-bold mb-0">54.99 ???</h1>
                        <p class="text-center text-muted mb-3">10.99 ???/anno</p>
 
                        <form action="/php/subscription.php" method="post">
                          <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                              data-key="<?echo($stripe['publishable_key']);?>"
                              data-amount="5499"
                              data-currency="eur"
                              data-name="salvamilavita.com"
                              data-description="Abbonamento per anni 5"
                              data-email="service@salvamilavita.com"
                              data-image="dist/img/apple-icon.png"
                              data-locale="auto">
                          </script>
                          <script>
                            document.getElementsByClassName("stripe-button-el")[1].style.display = 'none';
                          </script>
                            <input type="hidden" name="data-key" value="<?$stripe['publishable_key'];?>">
                            <input type="hidden" name="data-amount" value="5499" />
                            <input type="hidden" name="data-currency" value="eur" />
                            <input type="hidden" name="data-subscription" value="5" />
                            <input type="hidden" name="data-name" value="Abbonamento per anni 5" />
                            <input type="hidden" name="data-email" value="service@salvamilavita.com" />
                            <input type="hidden" name="" value="" />
                            <input id="baseCustomData" type="hidden" name="custom" value="" />
                            <input class="btn btn-primary btn-block font-weight-bold" type="submit" value="acquista" />
                        </form>
                                           
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>

                  <div id="user_box_premium" class="col-12 col-lg-4 d-none">
                    <div class="card card-primary card-outline">
                      <div class="card-body box-profile">
                    
                        <h3 class="text-center">PREMIUM</h3>

                        <p class="text-center text-muted">Abbonamento premium per dieci anni</p>
        
                        <ul class="list-group list-group-unbordered mb-3">

                            <li class="list-group-item">
                              <b>Check-up</b> <a class="float-right">illimitati</a>
                            </li>
                            <li class="list-group-item">
                              <b>Scheda sanitaria</b> <a class="float-right">attivata</a>
                            </li>
                            <li class="list-group-item">
                              <b>Social</b> <a class="float-right">illimitato</a>
                            </li>
                            <li class="list-group-item">
                              <b>Durata</b> <a class="float-right">10 anni</a>
                            </li>

                        </ul>

                        <h1 class="price text-center text-primary font-weight-bold mb-0">74.99 ???</h1>
                        <p class="text-center text-muted mb-3">7.50 ???/anno</p>
                        
                        <form action="/php/subscription.php" method="post">
                          <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                              data-key="<?echo($stripe['publishable_key']);?>"
                              data-amount="7499"
                              data-currency="eur"
                              data-name="salvamilavita.com"
                              data-description="Abbonamento per anni 10"
                              data-email="service@salvamilavita.com"
                              data-image="dist/img/apple-icon.png"
                              data-locale="auto">
                          </script>
                          <script>
                            document.getElementsByClassName("stripe-button-el")[2].style.display = 'none';
                          </script>
                            <input type="hidden" name="data-key" value="<?$stripe['publishable_key'];?>">
                            <input type="hidden" name="data-amount" value="7499" />
                            <input type="hidden" name="data-currency" value="eur" />
                            <input type="hidden" name="data-subscription" value="10" />
                            <input type="hidden" name="data-name" value="Abbonamento per anni 10" />
                            <input type="hidden" name="data-email" value="service@salvamilavita.com" />
                            <input type="hidden" name="" value="" />
                            <input id="baseCustomData" type="hidden" name="custom" value="" />
                            <input class="btn btn-primary btn-block font-weight-bold" type="submit" value="acquista" />
                        </form>

                    </div>
                      <!-- /.card-body -->
                    </div>
                  </div>

                  <div id="affilate_box" class="col-12 col-lg-4 d-none">

                    <div class="ribbon-wrapper ribbon-lg">
                      <div class="ribbon bg-warning text-bg">
                        nuovo
                      </div>
                    </div>

                    <div class="card card-danger card-outline">
                      <div class="card-body box-profile">
                    
                        <h3 class="text-center">AFFILIAZIONE</h3>

                        <p class="text-center text-muted">Servizio pubblicitario dedicato agli affiliati</p>
        
                        <ul class="list-group list-group-unbordered mb-3">

                            <li class="list-group-item">
                              <b>Annunci</b> <a class="float-right">illimitati</a>
                            </li>
                            <li class="list-group-item">
                              <b>Visibilit??</b> <a class="float-right">tutta Italia</a>
                            </li>
                            <li class="list-group-item">
                              <b>Social</b> <a class="float-right">illimitato</a>
                            </li>
                            <li class="list-group-item">
                              <b>Durata</b> <a class="float-right">1 anno</a>
                            </li>

                        </ul>

                        <h1 class="price text-center text-danger font-weight-bold mb-0">144.99 ???</h1>
                        <p class="text-center text-muted mb-3">144.99 ???/anno</p>
                        
                        <form action="/php/subscription.php" method="post">
                          <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                              data-key="<?echo($stripe['publishable_key']);?>"
                              data-amount="14499"
                              data-currency="eur"
                              data-name="salvamilavita.com"
                              data-description="Affiliazione per anni 1"
                              data-email="service@salvamilavita.com"
                              data-image="dist/img/apple-icon.png"
                              data-locale="auto">
                          </script>
                          <script>
                            document.getElementsByClassName("stripe-button-el")[3].style.display = 'none';
                          </script>
                            <input type="hidden" name="data-key" value="<?$stripe['publishable_key'];?>">
                            <input type="hidden" name="data-amount" value="14499" />
                            <input type="hidden" name="data-currency" value="eur" />
                            <input type="hidden" name="data-subscription" value="1" />
                            <input type="hidden" name="data-name" value="Servizio pubblicitario per anni 1 dedicato agli affiliati" />
                            <input type="hidden" name="data-email" value="service@salvamilavita.com" />
                            <input type="hidden" name="" value="" />
                            <input id="baseCustomData" type="hidden" name="custom" value="" />
                            <input class="btn btn-danger btn-block font-weight-bold" type="submit" value="acquista" />
                        </form>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>

                  <div id="affilate_info" class="col-12 col-lg-8 d-none">

                    <div class="row col mb-4 text-left text-md-justify">

                      <div class="col-md-6 h-100">
          
                        <div class="card trasparent">
                          <div class="card-header">
                            <h5 class="m-0">Affiliazione a 'Salvami la vita'</h5>
                          </div>
                          <div class="card-body">
                            <h6 class="card-title mb-1">La prima rete Sanitaria in Italia</h6>
            
                            <p class="card-text">
                              <strong>Salvami la Vita</strong> ?? una rete sociale dove migliaia di iscritti interagiscono e partecipano all'<a href="banca_dati_sanitaria.html" target="_blank" class="d-inline link">omonimo progetto</a>.
                            </p>
          
                            <p class="card-text">
                              Iscriviti, compila la <strong>scheda professionale</strong>, inserisci i tuoi contatti ed inizia subito l'affiliazione, partecipa con noi al progetto 'Salvami la Vita' e raggiungi subito tanti nuovi clienti.
                            </p>
          
                            <p class="card-text">
                              La <strong>rete sociale</strong> conta centinaia di iscritti ogni settimana e ogni giorno, decine di professionisti vengono scelti e suggeriti ad ogni singolo iscritto. 
                            </p>
          
                            <p class="card-text">
                              Unisciti anche tu alla nostra rete, aumenta la tua visibilit?? e connettiti con migliai di potenzili clienti. Aiuta, lavora e contribuisci anche tu a <strong>Salvare una Vita</strong>.
                            </p>
                    
                          </div>
                        </div>
          
                      </div>
          
                      <div class="col-md-6 h-100">
          
                          <div class="card trasparent">
                            <div class="card-header">
                              <h5 class="m-0">Come funziona l'affiliazione</h5>
                            </div>
                            <div class="card-body">
              
                              <p class="card-text">
                                <strong>Salvami la Vita</strong> ha al suo interno, un soffisticato software realizzato con la tecnologia I.A. (Intelligenza Artificiale), il quale rappresenta il cuore del sistema <a href="banca_dati_sanitaria.html" target="_blank" class="d-inline link">Check-up Prevenzione</a>.
                              </p>
            
                              <p class="card-text">
                                <strong>Il Check-Up Prevenzione</strong> ?? in grado di dialogare con gli iscritti ed ?? capace di individuare le correlazioni tra sintomi e patologie e suggerire all'utente, una vera e propria consulenza medica con un <strong>medico specialista affiliato</strong> presente nella stessa citt??.
                              </p>
            
                              <p class="card-text">
                                L'inteligenza artificiale, oltre al suggerire eventuali consulenze mediche, ?? in grado di indicare altri <strong>professionisti affiliati</strong> (CAF, patronati, Avvocati, Farmacisti), presenti nella stessa citt??, mostrando agli iscritti la relativa scheda professionale interessata.
                              </p>
            
                            </div>
                          </div>
                      
                      </div>
          
                    </div>
  
                  
                  </div>

              </div>

              <div id="affilate_bottom" class='row col-12 d-none'>
                  <div class="card trasparent col-12">
                    <div class="card-header">
                      <h5 class="m-0">Affrettati!!!</h5>
                    </div>
                    <div class="card-body">
      
                      <p class="card-text font-italic">
                        Tutti gli affiliati: Medici, Cliniche, Avvocati, CAF e patronati, saranno ben visibili ed in contatto con migliaia di iscritti.
                      </p>
    
                      <p class="card-text">
                        Non perdere l'opportunit?? di raggiungere migliaia di persone, registrati e compila la tua scheda professionale.
                      </p>
                
                    </div>
                  </div>
              </div>

              <div class='row col-12 mb-3'>
                  <div class="offset-md-8 col-md-4 ">
                      <img class="d-block mx-auto w-50 w-md-75 float-none float-md-right" src="dist/img/payments.png">
                  </div>
              </div>

          <!-- /.col -->

          </div>

      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class='main-footer ml-0'>
    <div class='float-right d-none d-sm-block'>
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2019-2020 <a href='index.html'>Salvami la Vita</a>.</strong> All rights
    reserved.
  </footer>

</div>

<!-- ./wrapper -->

<!-- jQuery -->
<script src='plugins/jquery/jquery.min.js'></script>
<!-- Bootstrap 4 -->
<script src='plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
<!-- Select2 -->
<script src='plugins/select2/js/select2.full.min.js'></script>
<!-- Bootstrap4 Duallistbox -->
<script src='plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'></script>
<!-- InputMask -->
<script src='plugins/moment/moment.min.js'></script>
<script src='plugins/inputmask/min/jquery.inputmask.bundle.min.js'></script>
<!-- date-range-picker -->
<script src='plugins/daterangepicker/daterangepicker.js'></script>
<!-- bootstrap color picker -->
<script src='plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src='plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'></script>
<!-- Bootstrap Switch -->
<script src='plugins/bootstrap-switch/js/bootstrap-switch.min.js'></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src='dist/js/adminlte.min.js'></script>
<!-- AdminLTE for demo purposes -->
<script src='dist/js/demo.js'></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $('input[data-bootstrap-switch]').each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>

</body>
</html>
