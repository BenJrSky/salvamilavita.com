<!DOCTYPE html>

<?php
  include "php/status.php";
?>

<html>
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Salvami la Vita - Check-up Prevenzione Online</title>
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
  <!-- Google Font: Source Sans Pro -->
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700' rel='stylesheet'>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- my style -->
  <link rel='stylesheet' href='dist/css/myStyle.css'>

  <link rel="stylesheet" href="plugins/Croppie-2.6.4/croppie.css" />
  <script src="plugins/Croppie-2.6.4/croppie.js"></script>

   <!-- My functions -->
  <script src='dist/js/myApp.js'></script>

</head>
<body class='hold-transition sidebar-mini' onload='loadScriptCheckup()'>

  <div id="containerAlert" class="containerAlert">
      <i class="fas fa-2x fa-sync-alt fa-spin loader"></i>
  </div> 

<div class='wrapper'>

  <div class="row">

    <div class="col-md-2">
      <a class="nav-link text-primary" href='index.html'><b>Salvami</b> la Vita</a>
    </div>

    <div class="col-md-4 offset-md-6 mt-2">
      
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
            <h1>Check-up prevenzione</h1>
          </div>
          <div class='col-sm-6'>
            <ol class='breadcrumb float-right'>
              <li class='breadcrumb-item'><a href='login.html'>Login</a></li>
              <li class='breadcrumb-item'><a href='profile.html'>Profilo</a></li>
              <li class='breadcrumb-item active'>Check-Up</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class='content'>
      <div class='container-fluid'>

        <div class='row'>
          
          <div class='col-md-3'>

            <!-- Profile Image -->
            <div style="height: 600px;" class='card card-primary card-outline'>
              <div class='card-body box-profile'>
                <div id="uploadDiv" class='text-center'>
                  <img id="userPicture" class='profile-user-img img-fluid img-circle'
                       src='dist/img/userMan.jpg'
                       alt='User profile picture'>
                       <input type="file" style="display:none;" id="inputUploadPhoto" name="userPhoto" accept="image/*">
                       <input type="text" style="display:none;" id="base64Photo">
                </div>

                <h3 id="profileUserName" class='profile-username text-center'></h3>

                <p id="profileUserProfession" class='text-muted text-center'>Front-End Developer</p>
              
                <ul class='list-group list-group-unbordered mb-3'>
                  <li class='list-group-item'>
                    <b>Gruppo Sanguigno</b> <a id="profileBloodGroup" class='float-right'>B+</a>
                  </li>
                  <li class='list-group-item'>
                    <b>Età</b> <a id="profileUserAge" class='float-right'>37</a>
                  </li>
                  <li class='list-group-item'>
                    <b>Messaggi</b> 
                    <a class="float-right text-secondary" data-toggle="dropdown" href="#">
                      <i class="far fa-comments"></i>
                      <span id="idMessageNumber" style="right:-5px;" class="badge badge-danger navbar-badge">3</span>
                    </a>
                  </li>
                </ul>

                <a href='profile.html' class='btn btn-primary btn-block'><i class="fas fa-user"></i><b> Profilo</b></a>
               
                <a href='scheda_sanitaria.html' class='btn btn-info btn-block'><i class="fa fa-address-card"></i><b> Scheda Sanitaria</b></a>

                <a href='diet.html' class='btn btn-success btn-block'><i class="fa fa-book" aria-hidden="true"></i><b> Diario alimentare</b></a>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <!-- /.col -->
          <div class='col-md-5'>
         
                <!-- DIRECT CHAT PRIMARY -->
                <div class="card card-prirary cardutline direct-chat direct-chat-primary">
                  <div class="card-header bg-primary">
                    <h3 class="card-title mt-1"><i class="fa fa-heartbeat"></i> Direct Check-Up</h3>
    
                    <div class="card-tools">
                      <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                      </button> -->
                      <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                        <i class="fas fa-comments"></i></button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">

                    <!-- Conversations are loaded here -->
                    <div style="height: 450px;" id="chatContainer" class="direct-chat-messages">


                    </div>
                    <!--/.direct-chat-messages-->
    
                    <!-- Contacts are loaded here -->
                    <div style="height: 450px;" class="direct-chat-contacts">
                      <ul class="contacts-list">
                        <li>
                          <a href="#">
                            <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg">
    
                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Count Dracula
                                <small class="contacts-list-date float-right">2/28/2015</small>
                              </span>
                              <span class="contacts-list-msg">How have you been? I was...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                      </ul>
                      <!-- /.contatcts-list -->
                    </div>

                    <!-- /.direct-chat-pane -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                      <div class="input-group">
                        <input id="directMessage" type="text" name="message" placeholder="Scrivi messaggio..." class="form-control">
                        <span class="input-group-append">
                          <button id="directChatSubmit" type="submit" class="btn btn-primary">invia</button>
                        </span>
                      </div>
                      <div id="chatHint" class="input-group mt-2">

                      </div>
                  </div>
                  <!-- /.card-footer-->
                </div>
                <!--/.direct-chat -->
          

            <div class='row col-md-12'>
              <div class='col-md-8'></div>
                <div class='col-md-4'>
                  <!-- <button id="dataSubmit" type='submit' class='btn btn-danger col mb-3'>Aggiorna</button> -->
                </div>
            </div>

      
          <!-- /.col -->

         </div>

         <div style="max-height: 600px;" class="col-md-4 overflow-auto">
            <div id="timeLineContainer" class='timeline timeline-inverse'>
            </div>
         </div>
         <!-- fine -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
<!-- AdminLTE App -->
<script src='dist/js/adminlte.min.js'></script>
<!-- AdminLTE for demo purposes -->
<script src='dist/js/demo.js'></script>
<!-- CHECKUP -->
<script src="plugins/jquery/jquery.imagemapster.min.js"></script>
<script src="dist/js/bodyImage.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
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
