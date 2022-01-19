<!DOCTYPE html>

  <?php
    include "php/status.php";
  ?>

<html>
<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Salvami la Vita - Profilo Utente</title>
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
<body class='hold-transition sidebar-mini' onload='loadScripts()'>

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
            <h1>Profilo </h1>
          </div>
          <div class='col-sm-6'>
            <ol class='breadcrumb float-right'>
              <li class='breadcrumb-item'><a href='login.html'>Login</a></li>
              <li class='breadcrumb-item active'>Profilo</li>
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

                <p id="profileUserProfession" class='text-muted text-center'>--------------------</p>
                
                <!-- CROP MODAL -->
                <div id="cropModal" class="card mt-2 mb-2">
                  <div id="mainCropper"></div>
                  <button id="cropDone" class="btn btn-primary btn-block">Ritaglia</button>
                  <button id="cropCancel" class="btn btn-danger btn-block">Cancella</button>
                </div>
                <!-- END CROP MODAL -->

                <ul class='list-group list-group-unbordered mb-3'>
                  <li class='list-group-item'>
                    <b>Gruppo Sanguigno</b> <a id="profileBloodGroup" class='float-right'>--</a>
                  </li>
                  <li class='list-group-item'>
                    <b>Età</b> <a id="profileUserAge" class='float-right'>--</a>
                  </li>
                  <li id="idLinkToMessages" class='list-group-item'>
                    <b>Messaggi</b> 
                    <a class="float-right text-secondary d-block d-md-none" href="#chatContainer">  
                      <i class="far fa-comments"></i>
                      <span id="idMessageNumberA" style="right:-5px;" class="badge badge-danger navbar-badge"></span>
                    </a>
                    <a class="float-right text-secondary d-none d-sm-none d-md-block"> 
                      <i class="far fa-comments"></i>
                      <span id="idMessageNumberB" style="right:-5px;" class="badge badge-danger navbar-badge"></span>
                    </a>
                  </li>
                </ul>

                <a href='scheda_sanitaria.html' class='btn btn-info btn-block'><i class="fa fa-address-card"></i><b> Scheda Sanitaria</b></a>
              
                <a href='checkup.html' class='btn btn-danger btn-block'><i class="fa fa-heartbeat"></i><b> Esegui Check-up</b></a>
                
                <a href='diet.html' class='btn btn-success btn-block'><i class="fa fa-book" aria-hidden="true"></i><b> Diario alimentare</b></a>
              
                <a id="dataSubmit" href='#' class='btn btn-primary btn-block'><i class="fa fa-archive"></i><b> Aggiorna</b></a>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class='card card-primary'>
              <div class='card-header'>
                <!-- <h3 class='card-title'>About Me</h3> -->
                <h3 class='card-title'>Su di me...</h3>
              </div>
              <!-- /.card-header -->

              <div class='card-body'>
                <strong><i class='fas fa-book mr-1'></i> Istruzione</strong>

                <p id='sideInfoEducation' class='text-muted'>
                  -------
                </p>

                <hr>

                <strong><i class='fas fa-map-marker-alt mr-1'></i> Indirizzo</strong>

                <p id='sideInfoLocation' class='text-muted'>
                  -------
                </p>

              </div>

            </div>

            <div class='card card-primary'>
              <div class='card-header'>
                <!-- <h3 class='card-title'>About Me</h3> -->
                <h3 class='card-title'>Il mio account...</h3>
              </div>
              <!-- /.card-header -->

              <div class='card-body'>

                  <div class='row p-2'>
                    <strong><i class='fa fa-hourglass-half mr-1'></i> Abbonamento scade il </strong>
                    <p id='sideInfoExpiration' class='text-muted ml-1'>-------</p>
                  </div>

                  <div id='updatePaypent'></div>

              </div>

            </div>

            <!-- /.card -->
          </div>

          <!-- /.col -->
          <div class='col-md-9'>
            <div class='card'>
              <div class='card-header p-2'>
                <ul class='nav nav-pills'>
                  <li class='nav-item'><a id="SocialDataTab" class='nav-link' href='#SocialData' data-toggle='tab'>Social</a></li>
                  <li class='nav-item'><a id="personalDataTab" class='nav-link active' href='#personalData' data-toggle='tab'>Dati personali</a></li>
                  <li class='nav-item'><a id="lifeStyleDataTab" class='nav-link' href='#lifeStyleData' data-toggle='tab' >Stile di vita</a></li>
                  <li class='nav-item'><a id="additionalDataTab" class='nav-link' href='#additionalData' data-toggle='tab'>Dati integrativi</a></li>
                  <li class='nav-item'><a id="allergyDataTab" class='nav-link' href='#allergyData' data-toggle='tab'>Allergie</a></li>
                  <li class='nav-item'><a id="diseasesDataTab" class='nav-link' href='#diseasesData' data-toggle='tab'>Patologie</a></li>
                  <li class='nav-item'><a id="vaccinationsDataTab" class='nav-link' href='#vaccinationsData' data-toggle='tab'>Vaccinazioni</a></li>
                  <li class='nav-item'><a id="missingOrgansDataTab" class='nav-link' href='#missingOrgansData' data-toggle='tab'>Organi mancanti</a></li>
                  <li class='nav-item'><a id="timelineTab" class='nav-link' href='#timeline' data-toggle='tab'>Timeline</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class='card-body'>

                <div class='tab-content'>

                  <!-- SOCIAL DATA -->
                  <div class='tab-pane' id='SocialData'>

                    <div class="card px-0 pz-0">
                      <div class="card-header mx-0 mz-0 social-nav">
                        <nav class="float-md-right float-left">
                          <!-- Right navbar links -->
                          <ul style="font-size:1.3em" class='nav nav-bar'>
                            <li class='nav-item'><a id="idTabSocialHome" class='nav-link text-secondary active' href='#idSocialHome' data-toggle='tab'><i class="fa fa-home" aria-hidden="true"></i></a></li>
                            <li class='nav-item'><a id="idTabSocialPost" class='nav-link text-secondary' href='#idSocialPost' data-toggle='tab'><i class="fa fa-puzzle-piece" aria-hidden="true"></i></a></li>
                            <li class='nav-item'><a id="idTabSocialMessages" class='nav-link text-secondary' href='#idSocialMessages' data-toggle='tab'><i class="fa fa-comments" aria-hidden="true"></i></a></li>
                          </ul>

                        </nav>
                      </div>
                      
                      <div class="px-0 pz-0">

                        <div class='tab-content'>

                          <div class='tab-pane active' id='idSocialHome'>

                              <div class="card">
                                <div class="card-header">
                                  <div class="row">
                                    <div class="col-2 mt-1">
                                      <h4 class="m-0 text-primary"><i class="fa fa-home" aria-hidden="true"></i></h4>
                                    </div>
                                    <div class="col-10 mt-1">
                                      
                                      <div class="input-group input-group-sm">
                                        <input id="idFilterPost" class="form-control form-control-navbar no-form-check" type="search" placeholder="Ricerca..." aria-label="Search">
                                        <div class="input-group-append">
                                          <button class="btn btn-navbar bg-primary" type="submit" onclick="getPost()">
                                            <i class="fas fa-search"></i>
                                          </button>
                                        </div>
                                      </div> 

                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="card-body">

                                  <div id="socialContainer" style="max-height: 800px;" class="overflow-auto">
                                    <div id="postContainer" class='timeline timeline-inverse'>

                                        <div class='row'>
                                          <div class='loader'>
                                            <i class='fas fa-2x fa-sync-alt fa-spin img-fluid'></i>
                                          </div>
                                        </div> 

                                    </div>
                                 </div>
                                 
                                </div>
                                <!-- end card body -->
                              </div>

                          </div>

                          <div class='tab-pane' id='idSocialPost'>

                            <div class="card">
                              <div class="card-header">
                                <div class="row">
                                  <div class="col-2 col-md-4 mt-1">
                                    <h4 class="m-0 text-primary"><i class="fa fa-puzzle-piece" aria-hidden="true"></i></h4>
                                  </div>
                                  <div class="col-10 col-md-8 mt-1 input-group-sm">
                                    <input  id='inputTitoloPost' type='text' class='form-control capital no-form-check float-right' maxlength="150" placeholder='Titolo...'>
                                  </div>
                                </div>
                              </div>
                              <div class="card-body">

                                <div class="row">
                                  <div class="col-md-4">

                                    <div class="w-100 mx-0 mx-md-auto mb-3 overflow-hidden">
                                      <!-- CROP MODAL -->
                                      <div id="cropModalPost" class="card mt-2 mb-2">
                                        <div id="mainCropperPost"></div>
                                        <button id="cropDonePost" class="btn btn-primary btn-block">Ritaglia</button>
                                        <button id="cropCancelPost" class="btn btn-danger btn-block">Cancella</button>
                                      </div>
                                      <!-- END CROP MODAL -->
                                      <div class="uploadPostDiv">
                                          <div id="idDeletePhoto" class="x-delete">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                          </div>
                                          <img id="userPost" src="dist/img/logoDefault.jpg" class="w-md-75 w-100 img-fluid rounded-lg" onclick="uploadPhotoPost()">
                                          <input type="file" style="display:none;" id="inputUploadPost" name="Post" accept="image/*">
                                          <input type="text" style="display:none;" id="base64Post">               
                                      </div>

                                    </div>  

                                  </div>
                                  <div class="col-md-8">

                                      <div class='col'>
                                        <textarea id='inputTextPost' class="form-control no-form-check" placeholder="Testo del post..." maxlength="300" style="resize:none; margin-top: 0px; margin-bottom: 0px; height: 200px;"></textarea>                        
                                      </div>
      
                                      <div class='col mt-2'>
                                          <div class='row'>
                                            <div class='col-md-8 col-sm-0'>
                                            </div>
                                            <div class='col-md-4 col-sm-12' onclick="collectPostData()">
                                              <a id="submitPost" href="#" class="btn btn-primary btn-block"><i class="fa fa-puzzle-piece"></i><b> Pubblica</b></a>
                                            </div>
                                          </div>
                                      </div>
                                    
                                  </div>
                                </div>

                               
                               
                              </div>
                              <!-- end card body -->
                            </div>
                            
                          </div>

                          <div class='tab-pane' id='idSocialMessages'>

                            <div class="card">
                              <div class="card-header">
                                <div class="row">
                                  <div class="col-2 col-md-4 mt-1">
                                    <h4 class="m-0 text-primary"><i class="fa fa-comments" aria-hidden="true"></i></h4>
                                  </div>
                                  <div class="col-10 col-md-8 mt-1 input-group-sm">
                                  </div>
                                </div>
                              </div>
                              <div class="card-body p-0">

                                <!-- DIRECT CHAT PRIMARY -->
                                <div id="idDirectcPrimary" class="card card-primary card-outline direct-chat direct-chat-primary direct-chat-contacts-open">
                                  <div class="card-header bg-primary">
                                    <h3 class="card-title mt-1"><i class="fa fa-comment-o"></i> Direct Messaggi</h3>
                    
                                    <div class="card-tools">
                                      <button id="togleMessagesIndex" type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                                        <i class="fas fa-comments"></i>
                                      </button>
                                    </div>
                                  </div>
                                  <!-- /.card-header -->
                                  <div class="card-body h-400">

                                    <!-- Conversations are loaded here -->
                                    <div id="chatContainer" dataUserId="" dataUserType="" class="direct-chat-messages h-400">


                                    </div>
                                    <!--/.direct-chat-messages-->
                    
                                    <!-- Contacts are loaded here -->
                                    <div id="contactsContainer" class="direct-chat-contacts h-400">
                                      <ul id="contactMessages" class="contacts-list">
                                        <li>
                                          <div class='row'>
                                            <div class='loader'>
                                              <i class='fas fa-2x fa-sync-alt fa-spin img-fluid'></i>
                                            </div>
                                          </div> 
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
                                        <input id="directMessage" type="text" name="message" placeholder="Scrivi messaggio..." class="form-control no-form-check">
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

                              </div>
                              <!-- end card body -->
                            </div>
                            
                          </div>

                        </div>


                      </div>
                      <!-- End Card Body -->

                    </div>

                  </div>

                   <!-- PERSONAL DATA -->
                   <div class='active tab-pane' id='personalData'>

                      <div class='form-group row'>
                        <label for='inputEmail' class='col-sm-2 col-form-label'>E-mail personale</label>
                        <div class='col-sm-10'>
                          <p class='form-control-plaintext textLowercase' id='inputEmail'></p>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputFiscalCode' class='col-sm-2 col-form-label'>Codice fiscale</label>
                        <div class='col-sm-10'>
                          <input type='text' class='form-control textUppercase' id='inputFiscalCode' placeholder=''>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputName' class='col-sm-2 col-form-label'>Nome</label>
                        <div class='col-sm-10'>
                          <input type='text' class='form-control capital' id='inputName' placeholder='Nome...'>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputSurname' class='col-sm-2 col-form-label'>Cognome</label>
                        <div class='col-sm-10'>
                          <input type='text' class='form-control capital' id='inputSurname' placeholder='Cognome...'>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputGender' class='col-sm-2 col-form-label'>Sesso</label>
                        <div class='col-sm-10'>
                          <select  class='form-control' id='inputGender'>
                            <option value='male' selected>Maschio</option>
                            <option value='female'>Femmina</option>
                          </select>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputBirthDay' class='col-sm-2 col-form-label'>Data di nascita</label>
                        <div class='input-group col-sm-10'>
                          <div class='input-group-prepend'>
                            <span class='input-group-text'><i class='far fa-calendar-alt'></i></span>
                          </div>
                          <input id='inputBirthDay' type='text' class='form-control' data-inputmask-alias='datetime' data-inputmask-inputformat='dd/mm/yyyy' data-mask='' im-insert='false'>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputBirthPlace' class='col-sm-2 col-form-label'>Nato a</label>
                        <div class='col-sm-10'>
                          <input type='text' class='form-control' id='inputBirthPlace' placeholder='Luogo di nascita...'>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputPersonalPhone' class='col-sm-2 col-form-label'>N. Telefonico</label>
                        <div class='input-group col-sm-10'>
                          <div class='input-group-prepend'>
                            <span class='input-group-text'><i class='fas fa-phone'></i></span>
                          </div>
                          <input id='inputPersonalPhone' type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                        </div>
                        <!-- /.input group -->
                      </div>

                      <div class='form-group row'>
                        <label for='inputAddress' class='col-sm-2 col-form-label'>Indirizzo</label>
                        <div class='col-sm-10'>
                          <input type='text' class='form-control' id='inputAddress' placeholder='Indirizzo di residenza...'>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputZip' class='col-sm-2 col-form-label'>C.a.p.</label>
                        <div class='col-sm-10'>
                          <p class='form-control-plaintext textLowercase' id='inputZip'></p>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputTown' class='col-sm-2 col-form-label'>Comune</label>
                        <div class='col-sm-10'>
                          <input type='text' class='form-control text-capitalize' id='inputTown' placeholder='Comune di residenza...'>
                        </div>
                      </div>

                      <div  id='townHint' class='form-group row'>
                        
                      </div>
                      
                      <div class="raw mt-5">
                        <div class="callout callout-info">
                          <h5><i class="fas fa-info"></i> </h5>
                          Indica tutti i tuoi dati personali sopra richiesti.
                        </div>
                      </div>  


                  </div>
                  <!-- END PERSONAL DATA-->

                   <!-- LIFE STYLE -->
                   <div class='tab-pane' id='lifeStyleData' >

                      <div class='form-group row'>
                        <label for='inputWeight' class='col-sm-2 col-form-label'>Peso in Kg</label>
                        <div class='col-sm-10'>
                          <input type='number' class='form-control' id='inputWeight' step='0.50' min='1.00' max='400.00' placeholder='50.00'>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputHeight' class='col-sm-2 col-form-label'>Altezza in cm</label>
                        <div class='col-sm-10'>
                          <input type='number' class='form-control' id='inputHeight' step='1' min='1.00' max='230' placeholder='175'>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputSmoke' class='col-sm-2 col-form-label'>Fumo...</label>
                        <div class='col-sm-10'>
                          <select  class='form-control' id='inputSmoke'>
                            <option value='noSmoke'>Non fumo</option>
                            <option value='rarelySmoke'>Fumo raramente</option>
                            <option value='constantlySmoke'>Fumo costantemente</option>
                          </select>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputDrink' class='col-sm-2 col-form-label'>Alcool...</label>
                        <div class='col-sm-10'>
                          <select  class='form-control' id='inputDrink'>
                            <option value='noDrink'>Non bevo</option>
                            <option value='rarelyDrink'>Bevo raramente</option>
                            <option value='constantlyDrink'>Bevo costantemente</option>
                          </select>
                        </div>
                      </div>

                      <div class='form-group row'>
                          <label for='checkboxAddictions' class='col-sm-2 col-form-label'>Dipendenze</label>
                        <div class='col-sm-10'>
                          <div class='checkbox'>
                            <label>
                              <input class="checkInfo" id='checkboxAddictions' type='checkbox' style='margin-top: 13px;'><span style='margin-left: 5px;font-weight: normal;'> Sono dipendente a sostanze...</span>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class='form-group row' id='checkboxAddictionsDescription'>
                        <div id='checkboxAddictionsDescription' class='offset-sm-2 col-sm-10'>
                          <input type='text' class='form-control' id='inputAddictionsDescriptions' placeholder='A quali sostanze sei dipendente?'>
                        </div>
                      </div>
  
                      <div class='form-group row'>
                        <label for='inputEducation' class='col-sm-2 col-form-label'>Istruzione</label>
                        <div class='col-sm-10'>
                          <select  class='form-control' id='inputEducation'>
                            <option value='noEducation'>Nessuna</option>
                            <option value='elementaryEducation'>Elementare</option>
                            <option value='middleEducation'>Media</option>
                            <option value='highSchoolEducation'>Superiore</option>
                            <option value='graduateEducation'>Laurea</option>
                          </select>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputProfession' class='col-sm-2 col-form-label'>Professione</label>
                        <div class='col-sm-10'>
                          <select  class='form-control' id='inputProfession'>
                            <option value='Disoccupato'>Disoccupato</option>
                            <option value='Impiegato'>Impiegato</option>
                            <option value='Imprenditore'>Imprenditore</option>
                            <option value='Libero professionista'>Libero professionista</option>
                            <option value='Pensionato'>Pensionato</option>
                            <option value='Studente'>Studente</option>
                          </select>
                        </div>
                      </div>
  
                      <div class='form-group row'>
                        <label for='inputMaritalStatus' class='col-sm-2 col-form-label'>Stato civile</label>
                        <div class='col-sm-10'>
                          <select  class='form-control' id='inputMaritalStatus'>
                            <option value='noEducation'>Celibe/Nubile</option>
                            <option value='elementaryEducation'>Coniugato/a</option>
                            <option value='middleEducation'>Separato/a</option>
                            <option value='highSchoolEducation'>Divorziato/a</option>
                            <option value='graduateEducation'>Vedovo/a</option>
                          </select>
                        </div>
                      </div>
  
                  </div>
                  <!-- END LIFE STYLE -->

                   <!-- ADDITIONAL DATA -->
                   <div class='tab-pane' id='additionalData'>

                      <div class='form-group row'>
                        <label for='inputBloodGroup' class='col-sm-2 col-form-label'>Gruppo sanguigno</label>
                        <div class='col-sm-10'>
                          <select  class='form-control' id='inputBloodGroup'>
                            <option value='0'>0</option>
                            <option value='Ap'>A+</option>
                            <option value='An'>A-</option>
                            <option value='Bp'>B+</option>
                            <option value='Bn'>B-</option>
                            <option value='ABp'>AB+</option>
                            <option value='ABn'>AB-</option>
                          </select>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputMemebershipAsl' class='col-sm-2 col-form-label'>Asl di...</label>
                        <div class='col-sm-10'>
                          <input type='text' class='form-control' id='inputMemebershipAsl' placeholder='Asl di appartenenza...'>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputDoctorName' class='col-sm-2 col-form-label'>Nome medico</label>
                        <div class='col-sm-10'>
                          <input type='text' class='form-control' id='inputDoctorName' placeholder='Cognome e Nome del tuo medico'>
                        </div>
                      </div>

                      <div class='form-group row'>
                        <label for='inputDoctorPhone' class='col-sm-2 col-form-label'>Tel. medico</label>
                        <div class='input-group col-sm-10'>
                          <div class='input-group-prepend'>
                            <span class='input-group-text'><i class='fas fa-phone'></i></span>
                          </div>
                          <input id='inputDoctorPhone' type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                        </div>
                        <!-- /.input group -->
                      </div>

                      <div class="raw mt-5">
                        <div class="callout callout-info">
                          <h5><i class="fas fa-info"></i> </h5>
                          Indica i dati ed i recapiti del tuo medico curante.
                        </div>
                      </div>  

                  </div>
                  <!-- END ADDITINAL DATA-->

                  <!-- ALLERGY DATA -->
                  <div class='tab-pane' id='allergyData'>

                      <div class="card card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">

                          <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">

                              <li class="nav-item">
                                <a class="nav-link active" id="TabDrugs" data-toggle="pill" href="#idDrugs" role="tab" aria-controls="idDrugs" aria-selected="true">Da farmaci</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#idFoods" role="tab" aria-controls="idFoods" aria-selected="false">Alimentari</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#idRespiratory" role="tab" aria-controls="idRespiratory" aria-selected="false">Respiratorie</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#idOthers" role="tab" aria-controls="idOthers" aria-selected="false">Altre allergie</a>
                              </li>
                            
                          </ul>

                        </div>

                        <div class="card-body">
                          <div class="tab-content" id="">

                            <div class="tab-pane fade show active" id="idDrugs" role="tabpanel" aria-labelledby="idDrugs">
                                  
                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsAntibiotics">
                                    <label class="form-check-label" for="drugsAntibiotics">Antibiotici</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsAcetilsalicilic">
                                    <label class="form-check-label" for="drugsAcetilsalicilic">Acido acetilsalicilico</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsAllopurinol">
                                    <label class="form-check-label" for="drugsAllopurinol">Allopurinolo</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsAntiaritmics">
                                    <label class="form-check-label" for="drugsAntiaritmics">Antiaritmici</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsAntipsicotics">
                                    <label class="form-check-label" for="drugsAntipsicotics">Antipsicotici</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input type="checkbox" id="drugsAnticancers">
                                    <label class="form-check-label" for="drugsAnticancers">Chemioterapici antitumorali</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsContrast">
                                    <label class="form-check-label" for="drugsContrast">Mezzi di contrasto</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsAntihypertensive">
                                    <label class="form-check-label" for="drugsAntihypertensive">Antipertensivi</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsAnticonvulsants">
                                    <label class="form-check-label" for="drugsAnticonvulsants">Anticonvulsivanti</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsAntituberculars">
                                    <label class="form-check-label" for="drugsAntituberculars">Antitubercolari</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="drugsRelaxants">
                                    <label class="form-check-label" for="drugsRelaxants">Miorilassanti</label>
                                  </div>
                                  
                            </div>

                            <div class="tab-pane fade" id="idFoods" role="tabpanel" aria-labelledby="idFoods">
                            
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="foodsEgg">
                                  <label class="form-check-label" for="foodsEgg">Uova</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="foodsMilk">
                                  <label class="form-check-label" for="foodsMilk">Latte</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="foodsPeanuts">
                                  <label class="form-check-label" for="foodsPeanuts">Arachidi</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="foodsWalnuts">
                                  <label class="form-check-label" for="foodsWalnuts">Noci</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="foodsFish">
                                  <label class="form-check-label" for="foodsFish">Pesce</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="foodsClams">
                                  <label class="form-check-label" for="foodsClams">Molluschi</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="foodsWheat">
                                  <label class="form-check-label" for="foodsWheat">Grano</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="foodsSoy">
                                  <label class="form-check-label" for="foodsSoy">Soia</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="foodsFruits">
                                  <label class="form-check-label" for="foodsFruits">Frutta e Verdura</label>
                                </div>  

                            </div>

                            <div class="tab-pane fade" id="idRespiratory" role="tabpanel" aria-labelledby="idRespiratory">
                            
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="respiratoryRhinitis">
                                  <label class="form-check-label" for="respiratoryRhinitis">Rinite allergica</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="respiratoryConjunctivitis">
                                  <label class="form-check-label" for="respiratoryConjunctivitis">Congiuntivite allergica</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="respiratoryAsthma">
                                  <label class="form-check-label" for="respiratoryAsthma">Asma</label>
                                </div> 

                            </div>

                            <div class="tab-pane fade" id="idOthers" role="tabpanel" aria-labelledby="idOthers">
                            
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="othersHymenoptera">
                                  <label class="form-check-label" for="othersHymenoptera">Imenotteri (api, vespe, calabrone)</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="othersDermatitis">
                                  <label class="form-check-label" for="othersDermatitis">Dermatite - Allergia da contatto</label>
                                </div>  

                            </div>

                          </div>

                        </div>
                        <!-- /.card -->
                      </div>

                      <div class="raw mt-5">
                        <div class="callout callout-info">
                          <h5><i class="fas fa-info"></i> </h5>
                          Seleziona le allergie di cui è sei a conoscenza.
                        </div>
                      </div>  

                  </div>
                  <!-- END ALLERGY DATA-->

                  <!-- DISEASES DATA -->
                  <div class='tab-pane' id='diseasesData'>

                      <div class="card card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">

                          <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">

                              <li class="nav-item">
                                <a class="nav-link active" id="" data-toggle="pill" href="#idCardiovascular" role="tab" aria-controls="idCardiovascular" aria-selected="true">Cardiovascolari</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idDigestiveSystem" role="tab" aria-controls="idDigestiveSystem" aria-selected="false">Apparato digerente</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idGenitalSystem" role="tab" aria-controls="idGenitalSystem" aria-selected="false">Apparato genitale</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idRespiratorySystem" role="tab" aria-controls="idRespiratorySystem" aria-selected="false">Apparato respiratorio</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idDermatological" role="tab" aria-controls="idDermatological" aria-selected="false">Dermatologiche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idHematologic" role="tab" aria-controls="idHematologic" aria-selected="false">Ematologiche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idEndocrinological" role="tab" aria-controls="idEndocrinological" aria-selected="false">Endocrinologiche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idGynecological" role="tab" aria-controls="idGynecological" aria-selected="false">Ginecologiche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idImmunological" role="tab" aria-controls="idImmunological" aria-selected="false">Immunologiche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idInfectious" role="tab" aria-controls="idInfectious" aria-selected="false">Infettive</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idMetabolic" role="tab" aria-controls="idMetabolic" aria-selected="false">Metaboliche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idNeurologic" role="tab" aria-controls="idNeurologic" aria-selected="false">Neurologiche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idEye" role="tab" aria-controls="idEye" aria-selected="false">Occulistiche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idOncologic" role="tab" aria-controls="idOncologic" aria-selected="false">Oncologiche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idOrthopedic" role="tab" aria-controls="idOrthopedic" aria-selected="false">Ortopediche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idOtorinolaringoiatriche" role="tab" aria-controls="idOtorinolaringoiatriche" aria-selected="false">Otorinolaringoiatriche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idPsychiatric" role="tab" aria-controls="idPsychiatric" aria-selected="false">Psichiatriche</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="" data-toggle="pill" href="#idRheumatic" role="tab" aria-controls="idRheumatic" aria-selected="false">Reumatiche</a>
                              </li>
                          </ul>

                        </div>

                        <!-- SCHEDE -->
                        <div class="card-body">
                          <div class="tab-content" id="">

                            <div class="tab-pane fade show active" id="idCardiovascular" role="tabpanel" aria-labelledby="idCardiovascular">
                                  
                                  <div class="card-header mb-3">
                                    <p class="card-title">
                                      <i class="fas fa-edit"></i>
                                      Principali malattie cardiovascolari:
                                    </p>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularHeartFailure">
                                    <label class="form-check-label" for="cardiovascularHeartFailure">Scompenso cardiaco</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularHeartAttack">
                                    <label class="form-check-label" for="cardiovascularHeartAttack">Infarto miocardico</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularHypertension">
                                    <label class="form-check-label" for="cardiovascularHypertension">Ipertensione arteriosa</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularAtrialFibrillation">
                                    <label class="form-check-label" for="cardiovascularAtrialFibrillation">Fibrillazione atriale</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularVentricularArrhythmias">
                                    <label class="form-check-label" for="cardiovascularVentricularArrhythmias">Aritmie ventricolari</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularIschemicHeart">
                                    <label class="form-check-label" for="cardiovascularIschemicHeart">Cardiopatia ischemica</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularValvulopatie">
                                    <label class="form-check-label" for="cardiovascularValvulopatie">Valvulopatie</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularAorta">
                                    <label class="form-check-label" for="cardiovascularAorta">Malattie dell'aorta</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularPericardio">
                                    <label class="form-check-label" for="cardiovascularPericardio">Malattie del pericardio</label>
                                  </div>

                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="cardiovascularCardiomiopatie">
                                    <label class="form-check-label" for="cardiovascularCardiomiopatie">Cardiomiopatie</label>
                                  </div>
                                  
                            </div>

                            <div class="tab-pane fade" id="idDigestiveSystem" role="tabpanel" aria-labelledby="idDigestiveSystem">
                            
                                <div class="card-header mb-3">
                                  <p class="card-title">
                                    <i class="fas fa-edit"></i>
                                    Principali malattie dell'apparato digerente:
                                  </p>
                                </div>

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveAmebiasi">
                                  <label class="form-check-label" for="digestiveAmebiasi">Amebiasi</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveAngina">
                                  <label class="form-check-label" for="digestiveAngina">Angina abdominis</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveAppendicite">
                                  <label class="form-check-label" for="digestiveAppendicite">Appendicite</label>
                                </div>  

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveCarcinoide">
                                  <label class="form-check-label" for="digestiveCarcinoide">Carcinoide</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveCirrosi">
                                  <label class="form-check-label" for="digestiveCirrosi">Cirrosi</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveColecistite">
                                  <label class="form-check-label" for="digestiveColecistite">Colecistite</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveColelitiasi">
                                  <label class="form-check-label" for="digestiveColelitiasi">Colelitiasi</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveColite">
                                  <label class="form-check-label" for="digestiveColite">Colite ulcerosa</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveDiverticolosi">
                                  <label class="form-check-label" for="digestiveDiverticolosi">Diverticolosi del colon</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveEpatite">
                                  <label class="form-check-label" for="digestiveEpatite">Epatite</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveEsofagite">
                                  <label class="form-check-label" for="digestiveEsofagite">Esofagite</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveFecaloma">
                                  <label class="form-check-label" for="digestiveFecaloma">Fecaloma</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveGastroenterite">
                                  <label class="form-check-label" for="digestiveGastroenterite">Gastroenterite</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveInfartoIntestinale">
                                  <label class="form-check-label" for="digestiveInfartoIntestinale">Infarto intestinale</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveIpertensione">
                                  <label class="form-check-label" for="digestiveIpertensione">Ipertensione portale</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveMorbo">
                                  <label class="form-check-label" for="digestiveMorbo">Morbo celiaco</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestivePancreatite">
                                  <label class="form-check-label" for="digestivePancreatite">Pancreatite</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestivePeritonite">
                                  <label class="form-check-label" for="digestivePeritonite">Peritonite</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestivePancreas">
                                  <label class="form-check-label" for="digestivePancreas">Tumori del pancreas</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveEsofago">
                                  <label class="form-check-label" for="digestiveEsofago">Tumori dell'esofago</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveIntestino">
                                  <label class="form-check-label" for="digestiveIntestino">Tumori dell'intestino</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveStomaco">
                                  <label class="form-check-label" for="digestiveStomaco">Tumori dello stomaco</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveUlcera">
                                  <label class="form-check-label" for="digestiveUlcera">Ulcera peptica</label>
                                </div> 

                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="digestiveVarici">
                                  <label class="form-check-label" for="digestiveVarici">Varici esofagee</label>
                                </div> 

                            </div>

                            <div class="tab-pane fade" id="idGenitalSystem" role="tabpanel" aria-labelledby="idGenitalSystem">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Malattie dell'apparato genitale maschile:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalBlenorragia">
                                <label class="form-check-label" for="genitalBlenorragia">Blenorragia</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalCriptorchidismo">
                                <label class="form-check-label" for="genitalCriptorchidismo">Criptorchidismo</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalEpididimite">
                                <label class="form-check-label" for="genitalEpididimite">Epididimite</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalFimosi">
                                <label class="form-check-label" for="genitalFimosi">Fimosi</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalIdrocele">
                                <label class="form-check-label" for="genitalIdrocele">Idrocele</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalImpotenza">
                                <label class="form-check-label" for="genitalImpotenza">Impotenza</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalIpertrofia">
                                <label class="form-check-label" for="genitalIpertrofia">Ipertrofia prostatica</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalOrchiepididimite">
                                <label class="form-check-label" for="genitalOrchiepididimite">Orchiepididimite</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalOrchite">
                                <label class="form-check-label" for="genitalOrchite">Orchite</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalSeminoma">
                                <label class="form-check-label" for="genitalSeminoma">Seminoma</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalSterilita">
                                <label class="form-check-label" for="genitalSterilita">Sterilità</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalTumore">
                                <label class="form-check-label" for="genitalTumore">Tumore della prostata</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="genitalVaricocele">
                                <label class="form-check-label" for="genitalVaricocele">Varicocele</label>
                              </div> 
                            </div>

                            <div class="tab-pane fade" id="idRespiratorySystem" role="tabpanel" aria-labelledby="idRespiratorySystem">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie dell'apparato respiratorio:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryAsma">
                                <label class="form-check-label" for="respiratoryAsma">Asma</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryAspergillosi">
                                <label class="form-check-label" for="respiratoryAspergillosi">Aspergillosi</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryBronchiolite">
                                <label class="form-check-label" for="respiratoryBronchiolite">Bronchiolite</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryBronchite">
                                <label class="form-check-label" for="respiratoryBronchite">Bronchite cronica</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryEmbolia">
                                <label class="form-check-label" for="respiratoryEmbolia">Embolia polmonare</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryEnfisema">
                                <label class="form-check-label" for="respiratoryEnfisema">Enfisema polmonare</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryFibrosi">
                                <label class="form-check-label" for="respiratoryEnfisema">Fibrosi polmonare</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryInsufficienza">
                                <label class="form-check-label" for="respiratoryInsufficienza">Insufficienza respiratoria</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryPleurite">
                                <label class="form-check-label" for="respiratoryPleurite">Pleurite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryPolmonite">
                                <label class="form-check-label" for="respiratoryPolmonite">Polmonite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryPneumoconiosi">
                                <label class="form-check-label" for="respiratoryPneumoconiosi">Pneumoconiosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryPneumotorace">
                                <label class="form-check-label" for="respiratoryPneumotorace">Pneumotorace</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryRinite">
                                <label class="form-check-label" for="respiratoryRinite">Rinite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratorySarcoidosi">
                                <label class="form-check-label" for="respiratorySarcoidosi">Sarcoidosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryApnee">
                                <label class="form-check-label" for="respiratoryApnee">Sindrome delle apnee notturne</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryTubercolosi">
                                <label class="form-check-label" for="respiratoryTubercolosi">Tubercolosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="respiratoryTumori">
                                <label class="form-check-label" for="respiratoryTumori">Tumori del polmone</label>
                              </div>

                            </div>

                            <div class="tab-pane fade" id="idDermatological" role="tabpanel" aria-labelledby="idDermatological">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie dermatologiche:
                                </p>
                              </div>

                              <div class="raw col">
                                  <div class="icheck-primary raw">
                                    <input class="checkInfo" type="checkbox" id="DermatologicalPapulo">
                                    <label class="form-check-label" for="DermatologicalPapulo">Papulo-squamose:</label>
                                    <p class="ml-4 font-italic">(dermatite atopica; dermatite da contatto; dermatite seborroica; eritrodermia; eruzione da farmaci;ittiosi; lichen ruber planus; orticaria; parapsoriasi; pityriasis rosea; psoriasi.)</p>
                                  </div>  
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="DermatologicalInfezioni">
                                  <label class="form-check-label" for="DermatologicalInfezioni">Infezioni della pelle da batteri e virus:</label>
                                  <p class="ml-4 font-italic">(acne e foruncolosi; candidosi; celluliti ed erisipela; condilomi; eritrasma;impetigine; mollusco contagioso; pityriasis versicolor; tigne; verruche.)</p>
                                </div>  
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="DermatologicalInfestazioni">
                                  <label class="form-check-label" for="DermatologicalInfestazioni">Infestazioni della pelle da parassiti:</label>
                                  <p class="ml-4 font-italic">(leishmaniosi; pediculosi; scabbia.)</p>
                                </div>  
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="DermatologicalVescicolo">
                                  <label class="form-check-label" for="DermatologicalVescicolo">Vescicolo-bollose:</label>
                                  <p class="ml-4 font-italic">(epidermolisi bollosa; eritema multiforme; pemfigo.)</p>
                                </div>  
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="DermatologicalAlterazioni">
                                  <label class="form-check-label" for="DermatologicalAlterazioni">Alterazioni della pigmentazione:</label>
                                  <p class="ml-4 font-italic">(vitiligine.)</p>
                                </div>  
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="DermatologicalTumoriBenigni">
                                  <label class="form-check-label" for="DermatologicalTumoriBenigni">Tumori benigni della pelle:</label>
                                  <p class="ml-4 font-italic">(angiomi; granuloma piogenico; nevi.)</p>
                                </div>  
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="DermatologicalTumoriMaigni">
                                  <label class="form-check-label" for="DermatologicalTumoriMaigni">Tumori maligni della pelle:</label>
                                  <p class="ml-4 font-italic">(epitelioma; melanoma; morbo di Kaposi.)</p>
                                </div>  
                              </div>
                          
                            </div>

                            <div class="tab-pane fade" id="idHematologic" role="tabpanel" aria-labelledby="idHematologic">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie ematologiche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicAnemia">
                                <label class="form-check-label" for="hematologicAnemia">Anemia</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicAnemiaFerro">
                                <label class="form-check-label" for="hematologicAnemiaFerro">Anemia da carenza di ferro</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicAnemiaB12">
                                <label class="form-check-label" for="hematologicAnemiaB12">Anemia da carenza di vitamina B12 e folati</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicAnemiaSangue">
                                <label class="form-check-label" for="hematologicAnemiaSangue">Anemia da perdita di sangue</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicAnemiaEmolitiche">
                                <label class="form-check-label" for="hematologicAnemiaEmolitiche">Anemie emolitiche</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicAnemiaDeficitG6pd">
                                <label class="form-check-label" for="hematologicAnemiaDeficitG6pd">Deficit G6PD (Favismo)</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicEmbolia">
                                <label class="form-check-label" for="hematologicEmbolia">Embolia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicLeucemiaAcuta">
                                <label class="form-check-label" for="hematologicLeucemiaAcuta">Leucemie acute</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicLeucemiaCronica">
                                <label class="form-check-label" for="hematologicLeucemiaCronica">Leucemie croniche</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicWerlhof">
                                <label class="form-check-label" for="hematologicWerlhof">Malattia di Werlhof</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicEmorragiche">
                                <label class="form-check-label" for="hematologicEmorragiche">Emorragiche</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicMieloma">
                                <label class="form-check-label" for="hematologicMieloma">Mieloma</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicPolicitemia">
                                <label class="form-check-label" for="hematologicPolicitemia">Policitemia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="hematologicTalassemia">
                                <label class="form-check-label" for="hematologicTalassemia">Talassemia</label>
                              </div>

                            </div>

                            <div class="tab-pane fade" id="idEndocrinological" role="tabpanel" aria-labelledby="idEndocrinological">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie endocrinologiche:
                                </p>
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="endocrinologicalTiroide">
                                  <label class="form-check-label" for="endocrinologicalTiroide">Tiroide:</label>
                                  <p class="ml-4 font-italic">(morbo di Basedow; gozzo; tiroidite; tumori.)</p>
                                </div>  
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="endocrinologicalParatiroidi">
                                  <label class="form-check-label" for="endocrinologicalParatiroidi">Paratiroidi:</label>
                                  <p class="ml-4 font-italic">(iperparatiroidismo; ipoparatiroidismo.)</p>
                                </div>  
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="endocrinologicalSurrene">
                                  <label class="form-check-label" for="endocrinologicalSurrene">Surrene:</label>
                                  <p class="ml-4 font-italic">(sindrome di Cushing; morbo di Addison)</p>
                                </div>  
                              </div>

                              <div class="raw col">
                                <div class="icheck-primary raw">
                                  <input class="checkInfo" type="checkbox" id="endocrinologicalIpofisi">
                                  <label class="form-check-label" for="endocrinologicalIpofisi">Ipofisi:</label>
                                  <p class="ml-4 font-italic">(acromegalia; diabete insipido; iperprolattinemia; ipersurrenalismo; ipogonadismo; iposurrenalismo; ipotiroidismo secondario; nanismo; pubertà precoce.)</p>
                                </div>  
                              </div>

                            </div>

                            <div class="tab-pane fade" id="idGynecological" role="tabpanel" aria-labelledby="idGynecological">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie ginecologiche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalAmenorre">
                                <label class="form-check-label" for="gynecologicalAmenorre">Amenorre</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalAnnessite">
                                <label class="form-check-label" for="gynecologicalAnnessite">Annessite</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalBlenorragia">
                                <label class="form-check-label" for="gynecologicalBlenorragia">Blenorragia</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalCandidosi">
                                <label class="form-check-label" for="gynecologicalCandidosi">Candidosi vaginale</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalDismenorrea">
                                <label class="form-check-label" for="gynecologicalDismenorrea">Dismenorrea</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalEndometrite">
                                <label class="form-check-label" for="gynecologicalEndometrite">Endometrite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalEndometriosi">
                                <label class="form-check-label" for="gynecologicalEndometriosi">Endometriosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalExtrauterina">
                                <label class="form-check-label" for="gynecologicalExtrauterina">Gravidanza extrauterina</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalMinacciaAborto">
                                <label class="form-check-label" for="gynecologicalMinacciaAborto">Minaccia d'aborto</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalMola">
                                <label class="form-check-label" for="gynecologicalMola">Mola vescicolare</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalPolicistosi">
                                <label class="form-check-label" for="gynecologicalPolicistosi">Policistosi ovarica (ovaio policistico)</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalSterilita">
                                <label class="form-check-label" for="gynecologicalSterilita">Sterilità</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalTricomoniasi">
                                <label class="form-check-label" for="gynecologicalTricomoniasi">Tricomoniasi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalUtero">
                                <label class="form-check-label" for="gynecologicalUtero">Tumori dell'utero</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="gynecologicalOvaio">
                                <label class="form-check-label" for="gynecologicalOvaio">Tumori dell'ovaio</label>
                              </div>

                              

                            </div>

                            <div class="tab-pane fade" id="idImmunological" role="tabpanel" aria-labelledby="idImmunological">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie immunologiche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalAgammaglobulinemia">
                                <label class="form-check-label" for="immunologicalAgammaglobulinemia">Agammaglobulinemia</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalAngioedema">
                                <label class="form-check-label" for="immunologicalAngioedema">Angioedema ereditario</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalAtassia">
                                <label class="form-check-label" for="immunologicalAtassia">Atassia-teleangectasia</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalIpoplasia">
                                <label class="form-check-label" for="immunologicalIpoplasia">Ipoplasia congenita del timo</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalLupus">
                                <label class="form-check-label" for="immunologicalLupus">Lupus eritematoso sistemico</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalSiero">
                                <label class="form-check-label" for="immunologicalSiero">Malattia da siero</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalMiastenia">
                                <label class="form-check-label" for="immunologicalMiastenia">Miastenia</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalCeliaco">
                                <label class="form-check-label" for="immunologicalCeliaco">Morbo celiaco</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalBasedow">
                                <label class="form-check-label" for="immunologicalBasedow">Morbo di Basedow</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalPemfigo">
                                <label class="form-check-label" for="immunologicalPemfigo">Pemfigo</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalBruton">
                                <label class="form-check-label" for="immunologicalBruton">Sindrome di Bruton</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="immunologicalHashimoto">
                                <label class="form-check-label" for="immunologicalHashimoto">Tiroidite di Hashimoto</label>
                              </div> 

                            </div>

                            <div class="tab-pane fade" id="idInfectious" role="tabpanel" aria-labelledby="idInfectious">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie infettive:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousAIDS">
                                <label class="form-check-label" for="infectiousAIDS">AIDS</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousAscesso">
                                <label class="form-check-label" for="infectiousAscesso">Ascesso dentale</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousBotulismo">
                                <label class="form-check-label" for="infectiousBotulismo">Botulismo</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousCandidosi">
                                <label class="form-check-label" for="infectiousCandidosi">Candidosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousCistite">
                                <label class="form-check-label" for="infectiousCistite">Cistite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousColera">
                                <label class="form-check-label" for="infectiousColera">Colera</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousEndocardite">
                                <label class="form-check-label" for="infectiousEndocardite">Endocardite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousEsantematiche">
                                <label class="form-check-label" for="infectiousEsantematiche">Malattie esantematiche</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousSimplex">
                                <label class="form-check-label" for="infectiousSimplex">Herpes simplex</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousZoster">
                                <label class="form-check-label" for="infectiousSimplex">Herpes zoster</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousMalaria">
                                <label class="form-check-label" for="infectiousMalaria">Malaria</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousMeningite">
                                <label class="form-check-label" for="infectiousMeningite">Meningite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousMononucleosi">
                                <label class="form-check-label" for="infectiousMononucleosi">Mononucleosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousMorbillo">
                                <label class="form-check-label" for="infectiousMorbillo">Morbillo</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousMughetto">
                                <label class="form-check-label" for="infectiousMughetto">Mughetto</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousOssiuriasi">
                                <label class="form-check-label" for="infectiousOssiuriasi">Ossiuriasi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousParotite">
                                <label class="form-check-label" for="infectiousParotite">Parotite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousPediculosi">
                                <label class="form-check-label" for="infectiousPediculosi">Pediculosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousPeritonite">
                                <label class="form-check-label" for="infectiousPeritonite">Peritonite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousPertosse">
                                <label class="form-check-label" for="infectiousPertosse">Pertosse</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousPielonefrite">
                                <label class="form-check-label" for="infectiousPielonefrite">Pielonefrite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousPoliomielite">
                                <label class="form-check-label" for="infectiousPoliomielite">Poliomielite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousPolmonite">
                                <label class="form-check-label" for="infectiousPolmonite">Polmonite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousQuarta">
                                <label class="form-check-label" for="infectiousQuarta">Quarta malattia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousQuinta">
                                <label class="form-check-label" for="infectiousQuinta">Quinta malattia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousSalmonellosi">
                                <label class="form-check-label" for="infectiousSalmonellosi">Salmonellosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousScarlattina">
                                <label class="form-check-label" for="infectiousScarlattina">Scarlattina</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousSesta">
                                <label class="form-check-label" for="infectiousSesta">Sesta malattia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousSifilide">
                                <label class="form-check-label" for="infectiousSifilide">Sifilide</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousTeniasi">
                                <label class="form-check-label" for="infectiousTeniasi">Teniasi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousTetano">
                                <label class="form-check-label" for="infectiousTetano">Tetano</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousEsantematico">
                                <label class="form-check-label" for="infectiousEsantematico">Tifo esantematico</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousPetecchiale">
                                <label class="form-check-label" for="infectiousPetecchiale">Tifo petecchiale</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousTigna">
                                <label class="form-check-label" for="infectiousTigna">Tigna</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousTonsillite">
                                <label class="form-check-label" for="infectiousTonsillite">Tonsillite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousToxoplasmosi">
                                <label class="form-check-label" for="infectiousToxoplasmosi">Toxoplasmosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousTricomoniasi">
                                <label class="form-check-label" for="infectiousTricomoniasi">Tricomoniasi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousTubercolosi">
                                <label class="form-check-label" for="infectiousTubercolosi">Tubercolosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="infectiousVaricella">
                                <label class="form-check-label" for="infectiousVaricella">Varicella</label>
                              </div>

                            </div>

                            <div class="tab-pane fade" id="idMetabolic" role="tabpanel" aria-labelledby="idMetabolic">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie metaboliche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="metabolicAcetone">
                                <label class="form-check-label" for="metabolicAcetone">Acetone</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="metabolicAcidosi">
                                <label class="form-check-label" for="metabolicAcidosi">Acidosi</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="metabolicDiabete">
                                <label class="form-check-label" for="metabolicDiabete">Diabete mellito</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="metabolicEmocromatosi">
                                <label class="form-check-label" for="metabolicEmocromatosi">Emocromatosi</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="metabolicObesita">
                                <label class="form-check-label" for="metabolicObesita">Obesità</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="metabolicPorfiria">
                                <label class="form-check-label" for="metabolicPorfiria">Porfiria</label>
                              </div>  

                            </div>

                            <div class="tab-pane fade" id="idNeurologic" role="tabpanel" aria-labelledby="idNeurologic">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie neurologiche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicAstrocitoma">
                                <label class="form-check-label" for="neurologicAstrocitoma">Astrocitoma</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicIschemici">
                                <label class="form-check-label" for="neurologicIschemici">Attacchi ischemici transitori</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicCataratta">
                                <label class="form-check-label" for="neurologicCataratta">Cataratta</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicCefalea">
                                <label class="form-check-label" for="neurologicCefalea">Cefalea</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicComa">
                                <label class="form-check-label" for="neurologicComa">Coma</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicCommozione">
                                <label class="form-check-label" for="neurologicCommozione">Commozione cerebrale</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicPresenile">
                                <label class="form-check-label" for="neurologicPresenile">Demenza presenile</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicSenile">
                                <label class="form-check-label" for="neurologicSenile">Demenza senile</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicDemenze">
                                <label class="form-check-label" for="neurologicDemenze">Demenze</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicEmicrania">
                                <label class="form-check-label" for="neurologicEmicrania">Emicrania</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicCerebrale">
                                <label class="form-check-label" for="neurologicCerebrale">Emorragia cerebrale</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicSubaracnoidea">
                                <label class="form-check-label" for="neurologicSubaracnoidea">Emorragia subaracnoidea</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicEncefalopatia">
                                <label class="form-check-label" for="neurologicEncefalopatia">Encefalopatia ipertensiva</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicEpilessia">
                                <label class="form-check-label" for="neurologicEpilessia">Epilessia</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicErnia">
                                <label class="form-check-label" for="neurologicErnia">Ernia del disco</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicIctus">
                                <label class="form-check-label" for="neurologicIctus">Ictus (apoplessia)</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicInsonnia">
                                <label class="form-check-label" for="neurologicInsonnia">Insonnia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicMeningioma">
                                <label class="form-check-label" for="neurologicMeningioma">Meningioma</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicMeningite">
                                <label class="form-check-label" for="neurologicMeningite">Meningite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicMiastenia">
                                <label class="form-check-label" for="neurologicMiastenia">Miastenia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicNeuroblastoma">
                                <label class="form-check-label" for="neurologicNeuroblastoma">Neuroblastoma</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicNeurosifilide">
                                <label class="form-check-label" for="neurologicNeurosifilide">Neurosifilide</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicParaplegia">
                                <label class="form-check-label" for="neurologicParaplegia">Paraplegia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicParkinson">
                                <label class="form-check-label" for="neurologicParkinson">Morbo di Parkinson</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicRetinopatia">
                                <label class="form-check-label" for="neurologicRetinopatia">Retinopatia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicSciatica">
                                <label class="form-check-label" for="neurologicSciatica">Sciatica</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicSclerosi">
                                <label class="form-check-label" for="neurologicSclerosi">Sclerosi a placche</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicSordita">
                                <label class="form-check-label" for="neurologicSordita">Sordità</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="neurologicCarpale">
                                <label class="form-check-label" for="neurologicCarpale">Sindrome del tunnel carpale</label>
                              </div>

                            </div>

                            <div class="tab-pane fade" id="idEye" role="tabpanel" aria-labelledby="idEye">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie oculistiche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeCalazio">
                                <label class="form-check-label" for="eyeCalazio">Calazio</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeCataratta">
                                <label class="form-check-label" for="eyeCataratta">Cataratta</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeCecita">
                                <label class="form-check-label" for="eyeCecita">Cecità</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeCheratite">
                                <label class="form-check-label" for="eyeCheratite">Cheratite</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeCheratocono">
                                <label class="form-check-label" for="eyeCheratocono">Cheratocono</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeCongiuntivite">
                                <label class="form-check-label" for="eyeCongiuntivite">Congiuntivite</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeGlaucoma">
                                <label class="form-check-label" for="eyeGlaucoma">Glaucoma</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeMiopia">
                                <label class="form-check-label" for="eyeMiopia">Miopia</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeOrzaiolo">
                                <label class="form-check-label" for="eyeOrzaiolo">Orzaiolo</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyePresbiopia">
                                <label class="form-check-label" for="eyePresbiopia">Presbiopia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeRetinoblastoma">
                                <label class="form-check-label" for="eyeRetinoblastoma">Retinoblastoma</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeRetinopatia">
                                <label class="form-check-label" for="eyeRetinopatia">Retinopatia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeSjögren">
                                <label class="form-check-label" for="eyeSjögren">Sindrome di Sjögren</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="eyeStrabismo">
                                <label class="form-check-label" for="eyeStrabismo">Strabismo</label>
                              </div>

                            </div>

                            <div class="tab-pane fade" id="idOncologic" role="tabpanel" aria-labelledby="idOncologic">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie oncologiche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicCarcinoma">
                                <label class="form-check-label" for="oncologicCarcinoma">Carcinoma del rene</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicLeucemia">
                                <label class="form-check-label" for="oncologicLeucemia">Leucemia</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicLinfoma">
                                <label class="form-check-label" for="oncologicLinfoma">Linfoma</label>
                              </div> 
                              
                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicMelanoma">
                                <label class="form-check-label" for="oncologicMelanoma">Melanoma</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicPlasmocitoma">
                                <label class="form-check-label" for="oncologicPlasmocitoma">Plasmocitoma</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicColonRetto">
                                <label class="form-check-label" for="oncologicColonRetto">Tumore del colon-retto</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicPancreas">
                                <label class="form-check-label" for="oncologicPancreas">Tumore del pancreas</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicPolmone">
                                <label class="form-check-label" for="oncologicPolmone">Tumore del polmone</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicOvaio">
                                <label class="form-check-label" for="oncologicOvaio">Tumore dell'ovaio</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicUtero">
                                <label class="form-check-label" for="oncologicUtero">Tumore dell'utero</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicMammella">
                                <label class="form-check-label" for="oncologicMammella">Tumore della mammella</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicProstata">
                                <label class="form-check-label" for="oncologicProstata">Tumore della prostata</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicCerebrali">
                                <label class="form-check-label" for="oncologicCerebrali">Tumori cerebrali</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicTesticolo">
                                <label class="form-check-label" for="oncologicTesticolo">Tumori del testicolo</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicTiroide">
                                <label class="form-check-label" for="oncologicTiroide">Tumori della tiroide</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="oncologicVescica">
                                <label class="form-check-label" for="oncologicVescica">Tumori della vescica</label>
                              </div> 

                            </div>

                            <div class="tab-pane fade" id="idOrthopedic" role="tabpanel" aria-labelledby="idOrthopedic">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie ortopediche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicArtrosi">
                                <label class="form-check-label" for="orthopedicArtrosi">Artrosi dell'anca</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicEpicondilite">
                                <label class="form-check-label" for="orthopedicEpicondilite">Epicondilite</label>
                              </div> 
                              
                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicErnia">
                                <label class="form-check-label" for="orthopedicErnia">Ernia del disco</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicGonartrosi">
                                <label class="form-check-label" for="orthopedicGonartrosi">Gonartrosi</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicLussazione">
                                <label class="form-check-label" for="orthopedicLussazione">Lussazione congenita dell'anca</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicDupuytren">
                                <label class="form-check-label" for="orthopedicDupuytren">Malattia di Dupuytren</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicMenisco">
                                <label class="form-check-label" for="orthopedicMenisco">Malattie del menisco</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicOsteoartrosi">
                                <label class="form-check-label" for="orthopedicOsteoartrosi">Osteoartrosi</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicOsteoporosi">
                                <label class="form-check-label" for="orthopedicOsteoporosi">Osteoporosi</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicPeriartrite">
                                <label class="form-check-label" for="orthopedicPeriartrite">Periartrite scapolo omerale</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicScoliosi">
                                <label class="form-check-label" for="orthopedicScoliosi">Scoliosi</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicCarpale">
                                <label class="form-check-label" for="orthopedicCarpale">Sindrome del tunnel carpale</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicVarismo">
                                <label class="form-check-label" for="orthopedicVarismo">Varismo</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="orthopedicValgismo">
                                <label class="form-check-label" for="orthopedicValgismo">Valgismo</label>
                              </div> 

                            </div>

                            <div class="tab-pane fade" id="idOtorinolaringoiatriche" role="tabpanel" aria-labelledby="idOtorinolaringoiatriche">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie otorinolaingoiatriche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheEdema">
                                <label class="form-check-label" for="otorinolaringoiatricheEdema">Edema della glottide</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheFaringite">
                                <label class="form-check-label" for="otorinolaringoiatricheFaringite">Faringite</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheLabirintite">
                                <label class="form-check-label" for="otorinolaringoiatricheLabirintite">Labirintite</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheLaringite">
                                <label class="form-check-label" for="otorinolaringoiatricheLaringite">Laringite</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheNoduli">
                                <label class="form-check-label" for="otorinolaringoiatricheNoduli">Noduli alle corde vocali</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheOtite">
                                <label class="form-check-label" for="otorinolaringoiatricheOtite">Otite</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheOtosclerosi">
                                <label class="form-check-label" for="otorinolaringoiatricheOtosclerosi">Otosclerosi</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatrichePalatoschisi">
                                <label class="form-check-label" for="otorinolaringoiatrichePalatoschisi">Palatoschisi</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatrichePoliposi">
                                <label class="form-check-label" for="otorinolaringoiatrichePoliposi">Poliposi nasale</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheRinite">
                                <label class="form-check-label" for="otorinolaringoiatricheRinite">Rinite</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheRussamento">
                                <label class="form-check-label" for="otorinolaringoiatricheRussamento">Russamento</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheApnee">
                                <label class="form-check-label" for="otorinolaringoiatricheApnee">Sindrome delle apnee notturne</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheSindrome">
                                <label class="form-check-label" for="otorinolaringoiatricheSindrome">Sindrome di Ménière</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheSinusite">
                                <label class="form-check-label" for="otorinolaringoiatricheSinusite">Sinusite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheSordita">
                                <label class="form-check-label" for="otorinolaringoiatricheSordita">Sordità</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheTonsillite">
                                <label class="form-check-label" for="otorinolaringoiatricheTonsillite">Tonsillite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="otorinolaringoiatricheLaringe">
                                <label class="form-check-label" for="otorinolaringoiatricheTonsillite">Tumore della laringe</label>
                              </div>

                            </div>

                            <div class="tab-pane fade" id="idPsychiatric" role="tabpanel" aria-labelledby="idPsychiatric">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie psichiatriche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricUmore">
                                <label class="form-check-label" for="psychiatricUmore">Disturbi dell'umore</label>
                              </div> 
                              
                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricDemenze">
                                <label class="form-check-label" for="psychiatricDemenze">Demenze</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricDepressione">
                                <label class="form-check-label" for="psychiatricDepressione">Depressione maggiore</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricDistimia">
                                <label class="form-check-label" for="psychiatricDistimia">Distimia</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricBipolorare1">
                                <label class="form-check-label" for="psychiatricBipolorare1">Disturbo bipolare I </label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricBipolorare2">
                                <label class="form-check-label" for="psychiatricBipolorare2">Disturbo bipolare II</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricCiclotimia">
                                <label class="form-check-label" for="psychiatricCiclotimia">Ciclotimia</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricSchizofrenia">
                                <label class="form-check-label" for="psychiatricSchizofrenia">Schizofrenia</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricPsiconevrosi">
                                <label class="form-check-label" for="psychiatricPsiconevrosi">Psiconevrosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricVascolari">
                                <label class="form-check-label" for="psychiatricVascolari">Vascolari</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricDipendenze">
                                <label class="form-check-label" for="psychiatricDipendenze">Alcolismo e tossicodipendenze</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="psychiatricBorderline">
                                <label class="form-check-label" for="psychiatricBorderline">Disturbo borderline di personalità</label>
                              </div>

                            </div>

                            <div class="tab-pane fade" id="idRheumatic" role="tabpanel" aria-labelledby="idRheumatic">
                            
                              <div class="card-header mb-3">
                                <p class="card-title">
                                  <i class="fas fa-edit"></i>
                                  Principali malattie reumatiche:
                                </p>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticArterite">
                                <label class="form-check-label" for="rheumaticArterite">Arterite temporale</label>
                              </div>  

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticReumatoide">
                                <label class="form-check-label" for="rheumaticReumatoide">Artrite reumatoide</label>
                              </div> 

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticArtrosi">
                                <label class="form-check-label" for="rheumaticArtrosi">Artrosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticCervicoartrosi">
                                <label class="form-check-label" for="rheumaticCervicoartrosi">Cervicoartrosi</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticDermatomiosite">
                                <label class="form-check-label" for="rheumaticDermatomiosite">Dermatomiosite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticDupuytren">
                                <label class="form-check-label" for="rheumaticDupuytren">Malattia di Dupuytren</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticGotta">
                                <label class="form-check-label" for="rheumaticGotta">Gotta</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticLupus">
                                <label class="form-check-label" for="rheumaticLupus">Lupus eritematoso sistemico</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticReumatica">
                                <label class="form-check-label" for="rheumaticReumatica">Malattia reumatica</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticPaget">
                                <label class="form-check-label" for="rheumaticPaget">Malattia dell'osso di Paget</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticPolimialgia">
                                <label class="form-check-label" for="rheumaticPolimialgia">Polimialgia reumatica</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticPolimiosite">
                                <label class="form-check-label" for="rheumaticPolimiosite">Polimiosite</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticSclerodermia">
                                <label class="form-check-label" for="rheumaticSclerodermia">Sclerodermia</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticReiter">
                                <label class="form-check-label" for="rheumaticReiter">Sindrome di Reiter</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticSpondilite">
                                <label class="form-check-label" for="rheumaticSpondilite">Spondilite anchilosante</label>
                              </div>

                              <div class="icheck-primary raw">
                                <input class="checkInfo" type="checkbox" id="rheumaticVasculiti">
                                <label class="form-check-label" for="rheumaticVasculiti">Vasculiti</label>
                              </div>

                            </div>

                        </div>
                        <!-- /.card -->
                        </div>

                      <div class="raw mt-5">
                        <div class="callout callout-info">
                          <h5><i class="fas fa-info"></i> </h5>
                          Seleziona le patologie di cui sei affetto e di cui è sei a conoscenza.
                        </div>
                      </div>  

                  </div>
                  <!-- END DISEASES DATA-->

                  </div>

                  <!-- VACCINATIONS DATA -->
                  <div class='tab-pane' id='vaccinationsData'>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsDifferite">
                      <label class="form-check-label" for="vaccinationsDifferite">Differite</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsEpatiteA">
                      <label class="form-check-label" for="vaccinationsEpatiteA">Epatite A</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsEpatiteB">
                      <label class="form-check-label" for="vaccinationsEpatiteB">Epatite B</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsYellowFever">
                      <label class="form-check-label" for="vaccinationsYellowFever">Febbre gialla</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsTyphus">
                      <label class="form-check-label" for="vaccinationsTyphus">Febbre tifoide</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsHaemophilus">
                      <label class="form-check-label" for="vaccinationsHaemophilus">Haemophilus influenzae tipo B</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsHerpesZoster">
                      <label class="form-check-label" for="vaccinationsHerpesZoster">Herpes zoster</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsHpv">
                      <label class="form-check-label" for="vaccinationsHpv">HPV – virus del papilloma umano</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsInfluence">
                      <label class="form-check-label" for="vaccinationsInfluence">Influenza</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsMeningococchi">
                      <label class="form-check-label" for="vaccinationsMeningococchi">Meningococchi</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsMeningoencefalite">
                      <label class="form-check-label" for="vaccinationsMeningoencefalite">Meningoencefalite da zecche</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsMorbillo">
                      <label class="form-check-label" for="vaccinationsMorbillo">Morbillo</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsOrecchioni">
                      <label class="form-check-label" for="vaccinationsOrecchioni">Orecchioni (parotite endemica)</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsPertosse">
                      <label class="form-check-label" for="vaccinationsPertosse">Pertosse</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsPneumococchi">
                      <label class="form-check-label" for="vaccinationsPneumococchi">Pneumococchi</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsPoliomielite">
                      <label class="form-check-label" for="vaccinationsPoliomielite">Poliomielite</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsRabbia">
                      <label class="form-check-label" for="vaccinationsRabbia">Rabbia</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsRosolia">
                      <label class="form-check-label" for="vaccinationsRosolia">Rosolia</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsRotavirus">
                      <label class="form-check-label" for="vaccinationsRotavirus">Rotavirus</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsTetano">
                      <label class="form-check-label" for="vaccinationsTetano">Tetano</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsTubercolosi">
                      <label class="form-check-label" for="vaccinationsTubercolosi">Tubercolosi</label>
                    </div>

                    <div class="icheck-primary raw">
                      <input class="checkInfo" type="checkbox" id="vaccinationsVaricella">
                      <label class="form-check-label" for="vaccinationsVaricella">Varicella</label>
                    </div>

                    <div class="raw mt-5">
                      <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> </h5>
                        Seleziona eventuali somministrazioni di cui è sei a conoscenza.
                      </div>
                    </div>  

                 </div>
                 <!-- END VACCINATIONS DATA-->

                <!-- MISSING ORGANS DATA -->
                <div class='tab-pane' id='missingOrgansData'>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingAdenoidi">
                    <label class="form-check-label" for="missingAdenoidi">Adenoidi</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingAppendice">
                    <label class="form-check-label" for="missingAppendice">Appendice</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingCistifellea">
                    <label class="form-check-label" for="missingCistifellea">Cistifellea</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingColon">
                    <label class="form-check-label" for="missingColon">Colon</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingMilza">
                    <label class="form-check-label" for="missingMilza">Milza</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingReproductive">
                    <label class="form-check-label" for="missingReproductive">Organi riproduttivi</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingPolmone">
                    <label class="form-check-label" for="missingPolmone">Polmone</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingRene">
                    <label class="form-check-label" for="missingRene">Rene</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingStomaco">
                    <label class="form-check-label" for="missingStomaco">Stomaco</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingTiroide">
                    <label class="form-check-label" for="missingTiroide">Tiroide</label>
                  </div>

                  <div class="icheck-primary raw">
                    <input class="checkInfo" type="checkbox" id="missingTonsille">
                    <label class="form-check-label" for="missingTonsille">Tonsille</label>
                  </div>

                  <div class="raw mt-5">
                    <div class="callout callout-info">
                      <h5><i class="fas fa-info"></i> </h5>
                      Seleziona eventuali organi mancanti, trapiantati e/o espiantati.
                    </div>
                  </div>  

                </div>
                <!-- END MISSING ORGANS DATA-->

                <!-- TIME LINE-->
                <div class='tab-pane' id='timeline'>
                  <!-- The timeline -->
                  <div style="max-height: 600px;" class="overflow-auto">
                    <div id="timeLineContainer" class='timeline timeline-inverse'>
                    </div>
                 </div>

                </div>
                <!-- END TIME LINE -->



                <!-- /.tab-content -->
              </div><!-- /.card-body -->

            </div>
            <!-- /.nav-tabs-custom -->

            <div class='row col-md-12'>
             

            </div>
          <!-- /.col -->

        </div>
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
