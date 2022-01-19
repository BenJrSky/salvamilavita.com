<!DOCTYPE html>

  <?php
    include "php/status.php";
  ?>
  
<html>
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Salvami la Vita - Check-up Dieta - la dieta facile e veloce</title>
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

  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
   <!-- My functions -->
  <script src='dist/js/myApp.js'></script>

</head>

<body class='hold-transition sidebar-mini' onload='loadScriptDiet()'>

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
            <h1>Diario alimentare</h1>
          </div>
          <div class='col-sm-6'>
            <ol class='breadcrumb float-right'>
              <li class='breadcrumb-item'><a href='login.html'>Login</a></li>
              <li class='breadcrumb-item'><a href='profile.html'>Profilo</a></li>
              <li class='breadcrumb-item'><a href='checkup.html'>Check-Up</a></li>
              <li class='breadcrumb-item active'>Dieta</li>
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
            <div class='card card-primary card-outline'>
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
              
                <ul id="dietBoard" class='list-group list-group-unbordered mb-3'>
                  <li class='list-group-item'>
                    <b>Età</b> <a id="dietAge" class='float-right'>---</a>
                  </li>
                  <li class='list-group-item'>
                    <b>Peso iniziale</b> <a id="dietCurrentWeight" class='float-right'>---</a>
                  </li>
                  <li class='list-group-item'>
                    <b>Peso ideale</b> <a id="dietIdealWeight" class='float-right'>---</a>
                  </li>
                  <li class='list-group-item'>
                    <b>Forma fisica</b> <a id="dietClass" class='float-right'>---</a>
                  </li>
                  <li class='list-group-item'>
                    <b>Inizio dieta</b> <a id="dietStart" class='float-right'>---</a>
                  </li>

                </ul>

                <a href='profile.html' class='btn btn-primary btn-block'><i class="fas fa-user"></i><b> Profilo</b></a>
               
                <a href='checkup.html' class='btn btn-danger btn-block'><i class="fa fa-heartbeat"></i><b> Esegui Check-up</b></a>

                <a href='scheda_sanitaria.html' class='btn btn-info btn-block'><i class="fa fa-address-card"></i><b> Scheda Sanitaria</b></a>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <!-- /.col -->
          <div class='col-md-5'>
         
                <!-- DIRECT CHAT PRIMARY -->
                <div class="card card-primary card-outline">
                  <div class="card-header bg-primary">
                    <h3 id="eatenBox" class="card-title mt-1"><i class="fa fa fa-book"></i> Cosa ho mangiato oggi?</h3>
                  </div>
                  <!-- /.card-header -->

                  <div class="card-body">

                    <div class="row">
                      <h4 id="foodInfo" class="card-title text-muted ml-3 mr-3 mb-3 mt-0"></h4>
                      <canvas id="foodChart" style="min-height: 200px; height: 200px; max-height: 200px; max-width: 100%;"></canvas>
                    </div>

                    <div class="card-footer">
                      <div class="input-group">
                        <div class="row mt-2">
                            <div class="col-8">
                                <input id="foodInput" type="text" name="message" placeholder="Alimento..." class="form-control">
                                <small class="d-block text-muted text-center">nome dell'alimento</small>
                            </div>
                            <div class="col-4">
                                <input id="foodWeight" type="number" name="message" step='1' min='0' max='1000' placeholder="Grammi..." value="100" class="form-control">
                                <small class="d-block text-muted text-center">grammi</small>
                            </div>
                            <div class="col-sm-12 mt-2">
                              <button id="insertFood" class='btn btn-success btn-block white-color d-none'><i class='fa fa-chevron-circle-down'></i><b> Inserisci alimento</b></button>
                            </div>
                        </div>
                      </div>
                      <div id="foodHint" class="input-group mt-2">

                      </div>
                  </div>

                  <div class="row border-top my-3"></div>

                    <div class="row">
                      <h4 class="card-title text-muted ml-3 mt-0 mb-2">Il riepilogo di oggi:</h4>

                      <div id="eatenFoods" class="input-group mt-1 mb-3 pl-3 pr-3">

                      </div>

                      <canvas id="kcalChart" style="min-height: 200px; height: 200px; max-height: 200px; max-width: 100%;"></canvas>
                      <div class="col mt-2">
                        <table class="mx-auto">
                          <tr>
                            <td>
                              <small class="d-block text-muted text-left">Consentite</small>
                            </td>
                            <td>
                              <small id="kcalTotal" class="d-block text-muted text-right">0.00 g</small>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <small class="d-block text-muted text-left">Ingeriti</small>
                            </td>
                            <td>
                              <small id="kcalIngested" class="d-block text-muted text-right">0.00 g</small>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <small class="d-block text-muted text-left">Restanti</small>
                            </td>
                            <td>
                              <small id="kcalLeft" class="d-block text-muted text-right">0.00 g</small>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-6 col-md-4 mt-3">
                        <canvas id="carbChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
                        <div class="col mt-2">
                          <table class="mx-auto">
                            <tr>
                              <td>
                                <small class="d-block text-muted text-left">Consentiti</small>
                              </td>
                              <td>
                                <small id="carboTotal" class="d-block text-muted text-right">0.00 g</small>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <small class="d-block text-muted text-left">Ingeriti</small>
                              </td>
                              <td>
                                <small id="carboIngested" class="d-block text-muted text-right">0.00 g</small>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <small class="d-block text-muted text-left">Restanti</small>
                              </td>
                              <td>
                                <small id="carboLeft" class="d-block text-muted text-right">0.00 g</small>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-6 col-md-4 mt-3">
                        <canvas id="protChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
                        <div class="col mt-2">
                          <table class="mx-auto">
                            <tr>
                              <td>
                                <small class="d-block text-muted text-left">Consentiti</small>
                              </td>
                              <td>
                                <small id="protTotal" class="d-block text-muted text-right">0.00 g</small>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <small class="d-block text-muted text-left">Ingeriti</small>
                              </td>
                              <td>
                                <small id="protIngested" class="d-block text-muted text-right">0.00 g</small>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <small class="d-block text-muted text-left">Restanti</small>
                              </td>
                              <td>
                                <small id="protLeft" class="d-block text-muted text-right">0.00 g</small>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 mt-3">
                        <canvas id="grasChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
                        <div class="col mt-2">
                          <table class="mx-auto">
                            <tr>
                              <td>
                                <small class="d-block text-muted text-left">Consentiti</small>
                              </td>
                              <td>
                                <small id="grasTotal" class="d-block text-muted text-right">0.00 g</small>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <small class="d-block text-muted text-left">Ingeriti</small>
                              </td>
                              <td>
                                <small id="grasIngested" class="d-block text-muted text-right">0.00 g</small>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <small class="d-block text-muted text-left">Restanti</small>
                              </td>
                              <td>
                                <small id="grasLeft" class="d-block text-muted text-right">0.00 g</small>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 399px;" width="399" height="250" class="chartjs-render-monitor">
                        </canvas>
                      </div>
                    </div>

                    <!-- /.direct-chat-pane -->
                  </div>
                  <!-- /.card-body -->
                  
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

         <div style="max-height:800px;" class="col-md-4 overflow-auto">
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
<!-- jQuery Knob -->
<script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Page script -->


</body>
</html>
