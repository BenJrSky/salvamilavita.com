  class Ajax {

      constructor(request, xhttp, url, headerDefoult, headers, callFirst, callBack) {
              this.request;
              this.xhttp = new XMLHttpRequest();
              this.url;
              this.callFirst;
              this.callBack;
              this.headerDefoult = true;
              this.headers = [];
          } //END constructor

      jsonRequest(json) {
              this.request = JSON.stringify(json);
          } //jsonRequest

      url(url) {
              this.url = url;
          } //url

      header() {

              if (arguments.length > 0) {

                  this.headerDefoult = false;

                  let header = {
                          data: arguments
                      } //END header

                  this.headers.push(header);

              } //END if

          } //END header

      callFirst(json) {
              this.callFirst = json;
          } //url

      callBack(json) {
              this.callBack = json;
          } //url

      execute() {

              if (typeof this.callFirst.function === "function") {
                  this.callFirst.function();
              } //END if

              // open a connection 
              this.xhttp.open("POST", this.url, true);

              if (this.headerDefoult === true) {
                  // Set the request header i.e. which type of content you are sending 
                  this.xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

              } else {
                  for (let header of this.headers) {
                      this.xhttp.setRequestHeader(header.data);
                  } //END for

              } //END if

              // Create a state change callback 
              this.xhttp.onreadystatechange = () => {

                  if (this.xhttp.readyState === 4 && this.xhttp.status === 200) {

                      if (typeof this.callBack.function === "function") {
                          this.callBack.function(this.xhttp.responseText);
                      } else {
                          alert(this.xhttp.responseText)
                      } //END if

                  } //END if 
              };

              // Sending data with the request 
              this.xhttp.send("data=" + this.request);

          } //END execute


  } //END Ajax

  class Alert {

      constructor(containerAlert, template, messageText, classAlert) {
              this.containerAlert = document.getElementById("containerAlert");
              this.template;
              this.messageText;
              this.classAlert;
          } //END constructor

      alertTemplate(message) {

              this.template = "<div class='showAlert'> " +
                  "<div class='alert " + this.classAlert + " alert-dismissible'>" +
                  "<button type='button' class='close' data-dismiss='alert' aria-hidden='true' onclick='closeContainerAlert()'>×</button>" +
                  "<h5><i class='icon fas fa-check'></i> Alert!</h5>" +
                  "<p>" + message + "</p>" +
                  "</div>" +
                  "</div>";

          } //END templatte

      freeze() {
              this.template = "<i class='fas fa-2x fa-sync-alt fa-spin loader'></i>";
              this.containerAlert.innerHTML = this.template;
              document.body.scrollTop = 0;
              document.documentElement.scrollTop = 0;
              this.containerAlert.style.display = "block";
          } //END freeze

      defreeze() {
              this.containerAlert.style.display = "none";
          } //END defreeze

      success(message) {

              if (message) {
                  this.freeze();
                  this.messageText = message;
                  this.classAlert = "alert-success";
                  this.alertTemplate(this.messageText);
                  this.containerAlert.innerHTML = this.template;
              } //END if

          } //END success

      warning(message) {

              if (message) {
                  this.freeze();
                  this.messageText = message;
                  this.classAlert = "alert-warning";
                  this.alertTemplate(this.messageText);
                  this.containerAlert.innerHTML = this.template;
              } //END if

          } //END warning

      danger(message) {

              if (message) {
                  this.freeze();
                  this.messageText = message;
                  this.classAlert = "alert-danger";
                  this.alertTemplate(this.messageText);
                  this.containerAlert.innerHTML = this.template;
              } //END if

          } //END warning


  } //END Alert

  function closeContainerAlert() {

      this.containerAlert = document.getElementById("containerAlert");
      this.containerAlert.style.display = "none";

  } //END closeContainerAlert

  function animationCheckboxes() {

      // Get the checkbox
      let checkBoxAddictions = document.getElementById("checkboxAddictions");

      if (checkboxAddictions) {
          // Get the output text
          let divAddictions = document.getElementById("checkboxAddictionsDescription");
          let inputAddictionsDescriptions = document.getElementById("inputAddictionsDescriptions");

          // If the checkbox is checked, display the output text
          if (checkBoxAddictions.checked === true) {
              divAddictions.style.display = "block";
              inputAddictionsDescriptions.classList.add("form-control");
          } else {
              divAddictions.style.display = "none";
              inputAddictionsDescriptions.classList.remove("form-control");
          } //END if
      } //END if

  } //END animations

  function listeners() {

      let checkBoxAddictions = document.getElementById("checkboxAddictions");
      let dataSubmit = document.getElementById("dataSubmit");
      let uploadDiv = document.getElementById("uploadDiv");
      let inputUploadPhoto = document.getElementById("inputUploadPhoto");
      let inputGender = document.getElementById("inputGender");
      let inputTown = document.getElementById("inputTown");

      let idTabSocialMessages = document.getElementById("idTabSocialMessages");
      let idDirectcPrimary = document.getElementById('idDirectcPrimary');
      let idLinkToMessages = document.getElementById('idLinkToMessages');

      idLinkToMessages.addEventListener('click', () => {
          document.getElementById('SocialDataTab').click();
          idTabSocialMessages.click();
      });

      idTabSocialMessages.addEventListener('click', () => {
          idDirectcPrimary.classList.remove('direct-chat-contacts-open');
          idDirectcPrimary.classList.add('direct-chat-contacts-open');
      });

      checkBoxAddictions.addEventListener('click', () => {
          this.animationCheckboxes();
      });

      inputGender.addEventListener('change', () => {
          this.dinamicProfession();
      });

      dataSubmit.addEventListener('click', () => {
          this.validationData();
      });

      uploadDiv.addEventListener('click', () => {
          inputUploadPhoto.click();
      });

      inputUploadPhoto.addEventListener('change', () => {
          this.crop(inputUploadPhoto);
      });

      inputTown.addEventListener('keyup', () => {
          if (inputTown.value != "" && inputTown.value != " ") {
              this.requestTownHint(inputTown.value);
          }; //END if
      });

      this.getPost();
      this.getMessagesIndex();
      this.intervalPost();



  } //END listeners

  function dietListeners() {

      let foodInput = document.getElementById("foodInput");
      let foodWeight = document.getElementById("foodWeight");

      foodInput.addEventListener('keyup', () => {
          if (foodInput.value != "" && foodInput.value != " ") {
              this.requestFoodHint(foodInput.value);
          }; //END if
      });

      foodInput.addEventListener('keyup', (event) => {
          if (event.keyCode === 13) {
              event.preventDefault();
              if (foodInput.value != "" && foodInput.value != " ") {
                  this.requestFoodHint(foodInput.value);
              }; //END if
          }
      });

  } //END dietListeners

  function pricingListeners() {


  } //END pricingListeners

  function affiliateListeners() {

      let dataSubmit = document.getElementById("dataSubmit");
      let uploadDiv = document.getElementById("uploadDiv");
      let inputUploadPhoto = document.getElementById("inputUploadPhoto");
      let inputTown = document.getElementById("inputTown");
      let idLinkToMessages = document.getElementById('idLinkToMessages');

      idLinkToMessages.addEventListener('click', () => {
          document.getElementById('SocialDataTab').click();
          idTabSocialMessages.click();
      });

      dataSubmit.addEventListener('click', () => {
          this.validationAffiliteData();
      });

      uploadDiv.addEventListener('click', () => {
          inputUploadPhoto.click();
      });

      inputUploadPhoto.addEventListener('change', () => {
          this.crop(inputUploadPhoto);
      });

      inputTown.addEventListener('keyup', () => {
          if (inputTown.value != "" && inputTown.value != " ") {
              this.requestTownHint(inputTown.value);
          }; //END if
      });

      let idTabSocialMessages = document.getElementById("idTabSocialMessages");
      let idDirectcPrimary = document.getElementById('idDirectcPrimary');

      idTabSocialMessages.addEventListener('click', () => {
          idDirectcPrimary.classList.remove('direct-chat-contacts-open');
          idDirectcPrimary.classList.add('direct-chat-contacts-open');
      });

      this.getPost();
      this.intervalPost();

  } //END affiliateListeners

  function intervalPost(status = true) {

      setInterval(() => {
          this.getPost();
      }, 200000);

      setInterval(() => {
          this.getMessagesIndex();
      }, 10000);

  }; //END intervalPost

  function listenersCard() {

      let privacyName = document.getElementById('privacyName');
      let privacyPhoto = document.getElementById('privacyPhoto');
      let privacyCard = document.getElementById('privacyCard');
      let privacyAddress = document.getElementById('privacyAddress');
      let privacyEmail = document.getElementById('privacyEmail');
      let privacyPhone = document.getElementById('privacyPhone');

      privacyName.addEventListener('click', () => {
          this.tooglePrivacy(privacyName);
      });

      privacyPhoto.addEventListener('click', () => {
          this.tooglePrivacy(privacyPhoto);
      });

      privacyCard.addEventListener('click', () => {
          this.tooglePrivacy(privacyCard);
      });

      privacyAddress.addEventListener('click', () => {
          this.tooglePrivacy(privacyAddress);
      });

      privacyEmail.addEventListener('click', () => {
          this.tooglePrivacy(privacyEmail);
      });

      privacyPhone.addEventListener('click', () => {
          this.tooglePrivacy(privacyPhone);
      });

  } //listenersCard

  function uploadPhotoPost() {

      let inputUploadPost = document.getElementById("inputUploadPost");

      inputUploadPost.addEventListener('change', () => {
          this.cropPost(inputUploadPost);
      });

      inputUploadPost.click();

  } //END upload photoPost

  function tooglePrivacy(element) {

      if (element) {

          switch (element.data) {

              case 'true':
                  element.data = 'false';
                  element.classList.remove('btn-default')
                  element.classList.add('btn-primary')
                  element.innerHTML = "Mostra"
                  break;

              case 'false':
                  element.data = 'true';
                  element.classList.remove('btn-primary')
                  element.classList.add('btn-default')
                  element.innerHTML = "Nascondi"
                  break;

          } //END switch

          this.updatePrivacy();

      } //END if

  } //END tooglePrivacy

  function buttonPrivacy(element, data) {

      if (element) {

          switch (data) {

              case 'false':
                  element.data = 'false';
                  // element.classList.remove('btn-default')
                  // element.classList.add('btn-primary')
                  element.classList.remove('btn-primary')
                  element.classList.add('btn-default')

                  element.innerHTML = "Mostra"
                  break;

              case 'true':
                  element.data = 'true';
                  // element.classList.remove('btn-primary')
                  // element.classList.add('btn-default')
                  element.classList.remove('btn-default')
                  element.classList.add('btn-primary')
                  element.innerHTML = "Nascondi"
                  break;

              default:
                  element.data = 'false';
                  // element.classList.remove('btn-default')
                  // element.classList.add('btn-primary')
                  element.classList.remove('btn-primary')
                  element.classList.add('btn-default')
                  break;

          } //END switch

      } //END if

  } //END buttonPrivacy

  function dinamicProfession() {

      let inputGender = document.getElementById("inputGender").value;

      let inputProfession = document.getElementById('inputProfession');

      switch (inputGender) {

          case 'male':
              inputProfession.innerHTML = "<option value='Disoccupato'>Disoccupato</option>" +
                  "<option value='Impiegato'>Impiegato</option>" +
                  "<option value='Imprenditore'>Imprenditore</option>" +
                  "<option value='Libero professionista'>Libero professionista</option>" +
                  "<option value='Pensionato'>Pensionato</option>" +
                  "<option value='Studente'>Studente</option>";
              break;

          case 'female':
              inputProfession.innerHTML = "<option value='Casalinga'>Casalinga</option>" +
                  "<option value='Disoccupata'>Disoccupata</option>" +
                  "<option value='Impiegata'>Impiegata</option>" +
                  "<option value='Imprenditrice'>Imprenditrice</option>" +
                  "<option value='Libero professionista'>Libero professionista</option>" +
                  "<option value='Pensionata'>Pensionata</option>" +
                  "<option value='Studentessa'>Studentessa</option>";
              break;

      } //END switch

  } //END dinamicProfession

  function crop(inputFile) {

      let currentPath = window.location.pathname;
      let currentPage = currentPath.split("/").slice(-1);

      let mainCropper = document.getElementById("mainCropper");

      let croppie = null;

      let destroy = {
          croppie: () => {
              if (mainCropper.classList.contains("croppie-container")) {
                  mainCropper.classList.remove("croppie-container");
                  mainCropper.innerHTML = ("");
              } //END if
          }
      }; //END destroy

      destroy.croppie();

      if (inputFile.files && inputFile.files[0]) {

          let cropModal = document.getElementById("cropModal");
          cropModal.style.display = "block";

          let reader = new FileReader();

          let cropDone = document.getElementById("cropDone");
          let cropCancel = document.getElementById("cropCancel");

          reader.onload = function(img) {

                  croppie = new Croppie(mainCropper, {
                      viewport: { width: 100, height: 100, type: 'circle' },
                      boundary: { width: 200, height: 200 },
                      showZoomer: true,
                      url: img.target.result
                  });

                  cropDone.addEventListener('click', () => {

                      croppie.result({
                              type: 'canvas'
                          })
                          .then(function(response) {

                              let base64Photo = document.getElementById("base64Photo");
                              let userPicture = document.getElementById("userPicture");

                              let base64Mysql = response.replace(/\+/g, '-');
                              userPicture.src = response;
                              base64Photo.src = base64Mysql;

                              //destroy.croppie();
                              croppie.destroy();
                              cropModal.style.display = "none";

                              if (currentPage == "profile.html") {
                                  this.validationData();
                              };

                              if (currentPage == "affiliate.html") {
                                  this.validationAffiliteData();
                              };

                          });

                  }); //END cropDone

                  cropCancel.addEventListener('click', () => {

                      croppie.destroy();
                      cropModal.style.display = "none";

                  }); //END cropCancel

              } //END reader

          reader.readAsDataURL(inputFile.files[0]);


      } //END if

  } //END crop

  function cropPost(inputFile) {

      let mainCropperPost = document.getElementById("mainCropperPost");
      let userPicture = document.getElementById("userPost");
      let idDeletePhoto = document.getElementById("idDeletePhoto");

      let croppie = null;

      idDeletePhoto.style.display = 'none';

      let destroy = {
          croppie: () => {
              let cropElements = document.getElementsByClassName("croppie-container");

              for (let element of cropElements) {
                  element.innerHTML = ("");
                  element.classList.remove("croppie-container");
              } //END for
          }
      }; //END destroy

      destroy.croppie();

      if (inputFile.files && inputFile.files[0]) {

          let cropModalPost = document.getElementById("cropModalPost");

          cropModalPost.style.display = "block";
          userPicture.style.display = "none";

          let reader = new FileReader();

          let cropDone = document.getElementById("cropDonePost");
          let cropCancel = document.getElementById("cropCancelPost");

          reader.onload = function(img) {

                  croppie = new Croppie(mainCropperPost, {
                      viewport: { width: 150, height: 100 },
                      boundary: { width: 200, height: 200 },
                      showZoomer: true,
                      url: img.target.result
                  });

                  cropDone.addEventListener('click', () => {

                      croppie.result({
                              type: 'canvas'
                          })
                          .then(function(response) {

                              let base64Post = document.getElementById("base64Post");
                              userPicture.style.display = "block";

                              let base64Mysql = response.replace(/\+/g, '-');
                              userPicture.src = response;
                              base64Post.src = base64Mysql;

                              //destroy.croppie();
                              croppie.destroy();
                              cropModalPost.style.display = "none";
                              idDeletePhoto.style.display = 'block';

                              idDeletePhoto.addEventListener('click', () => {
                                  this.deletePhoto();
                              });

                          });

                  }); //END cropDone

                  cropCancel.addEventListener('click', () => {

                      croppie.destroy();
                      userPicture.style.display = "block";
                      cropModalPost.style.display = "none";

                  }); //END cropCancel

              } //END reader

          reader.readAsDataURL(inputFile.files[0]);

      } //END if

  } //END cropPost

  function deletePhoto() {

      let userPost = document.getElementById('userPost');
      let inputUploadPost = document.getElementById('inputUploadPost');
      let base64Post = document.getElementById('base64Post')
      let idDeletePhoto = document.getElementById("idDeletePhoto");

      userPost.src = "dist/img/logoDefault.jpg";
      inputUploadPost.value = null;
      base64Post.src = null;
      idDeletePhoto.style.display = 'none';

  } //END deletePhoto

  function base64Encode(inputFile) {

      let file = inputFile.files[0];
      let reader = new FileReader();
      let base64Photo = document.getElementById("base64Photo");
      let userPicture = document.getElementById("userPicture");

      reader.onloadend = function() {
          let base64 = reader.result;
          let base64Mysql = base64.replace(/\+/g, '-');
          userPicture.src = base64;
          base64Photo.src = base64Mysql;
      };

      reader.readAsDataURL(file);

  } //END base64Encode

  function indexListeners() {

      let submitSearchUser = document.getElementById("submitSearchUser");
      let inputSearchUser = document.getElementById("inputSearchUser");

      submitSearchUser.addEventListener('click', () => {
          if (inputSearchUser.value != "" && inputSearchUser.value != " ") {
              this.collectSearchData();
          }; //END if
      });

      inputSearchUser.addEventListener('keyup', (event) => {
          if (event.keyCode === 13 && inputSearchUser.value != "" && inputSearchUser.value != " ") {
              event.preventDefault();
              this.collectSearchData();
          }; //END if
      });

  } //END indexListeners

  function loginListeners() {

      let loginEmail = document.getElementById("loginEmail").value;
      let loginPassword = document.getElementById("loginPassword").value;


      if (localStorage.getItem('login') && loginEmail == "" && loginPassword == "") {

          let request = JSON.parse(localStorage.getItem('login'));

          loginEmail = request.userEmail;
          loginPassword = request.loginPassword;

      }


      let submitLogin = document.getElementById("submitLogin");

      submitLogin.addEventListener('click', () => {
          this.collectLoginData();
      });

  } //END loginListeners

  function loginAffiliateListeners() {

      let submitAffiliateLogin = document.getElementById("submitAffiliateLogin");

      submitAffiliateLogin.addEventListener('click', () => {
          this.collectAffiliateLoginData();
      });

  } //END loginListeners

  function listenersCheckup() {

      let directChatSubmit = document.getElementById("directChatSubmit");
      let directMessage = document.getElementById("directMessage");

      directChatSubmit.addEventListener('click', () => {
          if (directMessage.value != "" && directMessage.value != " ") {
              this.appendMessage(directMessage.value);
          }
      });

      directMessage.addEventListener('keyup', (event) => {
          if (event.keyCode === 13 && directMessage.value != "" && directMessage.value != " ") {
              event.preventDefault();
              this.appendMessage(directMessage.value);
          }; //END if

      });

      directMessage.addEventListener('keyup', () => {
          if (directMessage.value != "" && directMessage.value != " ") {
              this.requestChatHint(directMessage.value);
          }; //END if
      });


  } //END listenersCheckup

  function registerListeners() {

      let submitRegister = document.getElementById("submitRegister");
      submitRegister.disabled = true;

      let agreeTerms = document.getElementById("agreeTerms");

      agreeTerms.addEventListener('change', () => {

          if (agreeTerms.checked) {
              submitRegister.disabled = false;
          } else {
              submitRegister.disabled = true;
          }

      })

      submitRegister.addEventListener('click', () => {
          this.collectRegisterData();
      });

  } //END loginListeners

  function registerAffiliationListeners() {

      let submitAffiliationRegister = document.getElementById("submitAffiliationRegister");
      submitAffiliationRegister.disabled = true;

      let agreeTerms = document.getElementById("agreeTerms");

      agreeTerms.addEventListener('change', () => {

          if (agreeTerms.checked) {
              submitAffiliationRegister.disabled = false;
          } else {
              submitAffiliationRegister.disabled = true;
          }

      })

      submitAffiliationRegister.addEventListener('click', () => {
          this.collectRegisterAffiliationData();
      });

  } //END registerAffiliationListeners

  function cleanPost() {

      let inputTitoloPost = document.getElementById("inputTitoloPost");
      let inputTextPost = document.getElementById("inputTextPost");
      let base64Post = document.getElementById("base64Post");
      let idTabSocialHome = document.getElementById("idTabSocialHome");
      let socialContainer = document.getElementById("socialContainer");
      let body = document.documentElement;

      inputTitoloPost.classList.remove("is-valid");
      inputTextPost.classList.remove("is-valid");
      inputTitoloPost.classList.remove("is-invalid");
      inputTextPost.classList.remove("is-invalid");

      base64Post.src = null;
      inputTitoloPost.value = null;
      inputTextPost.value = null;

      this.deletePhoto();
      this.getPost();

      idTabSocialHome.click();

      postContainer.scrollTop = 0;
      socialContainer.scrollTop = 0;
      body.scrollTop = 0;

  } //END cleanPost

  function placePostes(json) {

      let postList = JSON.parse(json);

      let diary = postList.data;

      let postContainer = document.getElementById('postContainer');

      let postBody = "";
      let postHeader = "";
      let postContent = "";
      let postPicture = "";
      let userPicturePost = "";
      let commentsBox = "";
      let collapseBox = "";
      let previewComments = "";
      let countPreview = 0;
      let hiddenComments = "";
      let templateComments = "";
      let userMessageLink = "";
      let userCommentLink = "";
      let countId = 0;

      postContainer.innerHTML = "";

      if (diary.post) {

          for (let key in diary) {

              let days = diary[key];

              for (let day in days) {

                  let postes = days[day];

                  postContent = "";

                  for (let post of postes) {

                      let postImage = post['picture'];
                      if (postImage != null) {
                          postImage = postImage.replace(/\-/g, '+');
                      }; //END if

                      let userImage = post['userInfo']['picture'];
                      if (userImage != null) {
                          userImage = userImage.replace(/\-/g, '+');
                      } else {
                          if (post['userInfo']['gender'] == 'male') {
                              userImage = 'dist/img/man_social.jpg';
                          } else {
                              userImage = 'dist/img/woman_social.jpg';
                          }; //END if
                      }; //END if

                      let idComment = "textComment" + post['postId'];
                      let idDivcomment = "idDivcomment" + post['postId'];

                      previewComments = "";
                      hiddenComments = "";
                      commentsBox = "";
                      collapseBox = "";

                      if (post['comments'] !== null) {

                          countPreview = 0;

                          for (let comment of post['comments']) {

                              let commentUserImage = comment['userInfo']['picture'];

                              if (commentUserImage != null) {
                                  commentUserImage = commentUserImage.replace(/\-/g, '+');
                              } else {
                                  if (comment['userInfo']['gender'] == 'male') {
                                      commentUserImage = 'dist/img/man_social.jpg';
                                  } else {
                                      commentUserImage = 'dist/img/woman_social.jpg';
                                  }; //END if
                              }; //END if

                              userCommentLink = "<a class='nav-link text-secondary pl-0' data-toggle='dropdown' href='#'>" +
                                  "<img src='" + commentUserImage + "' class='ml-0 img-circle elevation-2 img-user-post'>" +
                                  "<small class='col mt-3 text-bold text-secondary'>" + comment['userInfo']['fullName'] + "</small>" +
                                  "</a>" +
                                  "<div id='messageBox" + countId + "' class='dropdown-menu p-3 col-12 col-lg-6'>" +
                                  "<div class=''>" +
                                  "<div class='row'>" +
                                  "<img src='" + commentUserImage + "' class='img-circle elevation-1 img-user-message mx-auto'>" +
                                  "</div>" +
                                  "<div class='col'>" +
                                  "<p class='mt-1 text-bold text-secondary text-center' >" + comment['userInfo']['fullName'] + "</p>" +
                                  "</div>" +
                                  "<div class='col'>" +
                                  "<textarea id='messageId" + countId + "' class='form-control no-form-check' placeholder='Testo del messaggio...' maxlength='200' style='resize:none; margin-top: 0px; margin-bottom: 0px; height: 200px;'></textarea>" +
                                  "</div>" +
                                  "<div class='mt-2 mb-2 col-12'>" +
                                  "<button type='button' id='submitMessage" + countId + "' messageBox='messageBox" + countId + "' messageId='messageId" + countId + "' recipentId='" + comment['userInfo']['userId'] + "' recipentType='" + comment['userInfo']['userType'] + "' class='btn btn-block btn-primary btn-sm instantMessage'>invia messaggio</button>" +
                                  "</div>" +
                                  "</div>" +
                                  "</div>";

                              countId++;

                              commentsBox = "<div class='comment-item'>" +
                                  "<span class='time-comment col text-right'><i class='far fa-clock'></i> " + comment['postDate'] + " - " + comment['postHour'] + "</span>" +
                                  "<div class='col pl-0'>" +
                                  userCommentLink +
                                  "</div>" +
                                  "<div class='timeline-body'>" +
                                  "<div class='row mt-2'>" +
                                  "<div class='col-12'>" +
                                  "<p style='width:100%;' class='text-justify text-md-left'>" + comment['postMessage'] + "</p>" +
                                  "</div>" +
                                  "</div>" +
                                  "</div>" +
                                  "</div>";

                              if (countPreview <= 2) {
                                  previewComments += commentsBox;
                              } else {
                                  hiddenComments += commentsBox;
                              }; //END if

                              countPreview++;

                          }; //END for 

                          templateComments = "";

                          if (hiddenComments.length > 0) {
                              templateComments = "<div style='background-color:#f8f9fa;' class='card collapsed-card elevation-0'>" +
                                  "<div class='card-header ui-sortable-handle pt-0 pb-0 border-bottom-0' style='cursor: move;'>" +
                                  "<div class='card-tools'>" +
                                  "<button type='button' class='btn btn-tool' data-card-widget='collapse'>" +
                                  "<i class='fas fa-plus text-primary'></i>" +
                                  "</button>" +
                                  "</div>" +
                                  "</div>" +
                                  "<div class='card-body px-0 style='display: none;'>" +
                                  hiddenComments +
                                  "</div>" +
                                  "</div>";
                          }; //END if

                          collapseBox = previewComments + templateComments;

                      }; //END if       

                      //START MESSAGE LINK
                      userMessageLink = "";

                      userPicturePost = "<div class='row image mt-2 mb-2'>" +
                          "<img src='" + userImage + "' class='ml-2 img-circle elevation-2 img-user-post'>" +
                          "<small class='ml-3 mt-1 text-bold text-secondary'>" + post['userInfo']['fullName'] + "</small>" +
                          "</div>";

                      userMessageLink = "<a class='nav-link text-secondary' data-toggle='dropdown' href='#'>" +
                          userPicturePost +
                          "</a>" +
                          "<div id='messageBox" + countId + "' class='dropdown-menu p-3 col-12 col-lg-6'>" +
                          "<div class=''>" +
                          "<div class='row '>" +
                          "<img src='" + userImage + "' class='img-circle elevation-1 img-user-message mx-auto'>" +
                          "</div>" +
                          "<div class='col'>" +
                          "<p class='mt-1 text-bold text-secondary text-center' >" + post['userInfo']['fullName'] + "</p>" +
                          "</div>" +
                          "<div class='col'>" +
                          "<textarea id='messageId" + countId + "' class='form-control no-form-check' placeholder='Testo del messaggio...' maxlength='200' style='resize:none; margin-top: 0px; margin-bottom: 0px; height: 200px;'></textarea>" +
                          "</div>" +
                          "<div class='mt-2 mb-2 offset-md-6 col-md-6 col-sm-12 col'>" +
                          "<button type='button' id='submitMessage" + countId + "' messageBox='messageBox" + countId + "' messageId='messageId" + countId + "' recipentId='" + post['userId'] + "' recipentType='" + post['userType'] + "' class='btn btn-block btn-primary btn-sm instantMessage'>invia messaggio</button>" +
                          "</div>" +
                          "</div>" +
                          "</div>";

                      countId++;

                      if (post['picture'] !== null) {
                          postPicture = "<div class='col-12 col-md-3'>" +
                              "<div class='w-100 mx-auto mt-1 mb-1'>" +
                              "<img src='" + postImage + "' class='w-100 img-fluid'>" +
                              "</div>" +
                              "</div>";
                      } else {
                          postPicture = "";
                      }; //END if

                      postHeader = "<div class='time-label mt-3'>" +
                          "<span class='bg-primary'>" +
                          post['postDate'] +
                          "</span>" +
                          "</div>";

                      postContent += "<div class='timeline-item post-container'>" +
                          userMessageLink +
                          "<div class='timeline-item post-container'>" +
                          "<span class='time col text-right'><i class='far fa-clock'></i> " + post['postDate'] + " - " + post['postHour'] + "</span>" +
                          "<h3 class='timeline-header text-bold text-primary'>" + post['postTitle'] + "</h3>" +
                          "<div class='timeline-body'>" +
                          "<div class='row'>" +
                          postPicture +
                          "<div class='col-12 col-md-9'>" +
                          "<p style='width:100%;' class='text-justify text-md-left'>" + post['postMessage'] + "</p>" +
                          "</div>" +
                          "<div class='col-12'>" +

                          "<div id='" + idDivcomment + "' class='togleComment row overflow-hidden hideComment'>" +
                          "<div class='mt-2 w-90 col-12'>" +
                          "<a style='font-size:1.3em' class='text-secondary float-right' >" +
                          "<i class='fa fa-puzzle-piece text-primary' aria-hidden='true'></i>" +
                          "</a>" +
                          "</div>" +
                          "<div class='mt-2 w-90 col-12'>" +
                          "<textarea id='" + idComment + "' class='form-control no-form-check' placeholder='Testo del coomento...' maxlength='300' style='resize:none; margin-top: 0px; margin-bottom: 0px; height: 200px;'></textarea>" +
                          "</div>" +
                          "<div class='mt-2 mb-2 offset-md-8 col-md-4 col-sm-12 col'>" +
                          "<button type='button' dataId='" + post['postId'] + "' class='btn btn-block btn-primary btn-sm'>commenta</button>" +
                          "</div>" +
                          "</div>" +
                          "<div>" +
                          collapseBox +
                          "</div>" +
                          "</div>" +
                          "</div>" +
                          "</div>" +
                          "</div>" +
                          "</div>";

                  }; //END for 

                  postBody += postHeader + postContent;

              }; //END for 

          }; //END for

          let firstIcon = "<div class='mt-2'><i class='far fa-clock bg-gray'></i><div class='timeline-item'></div></div>";

          postBody += firstIcon;

          postContainer.innerHTML = postBody;

          let instantMessages = document.getElementsByClassName('instantMessage');

          for (messageSubmit of instantMessages) {

              let submitId = messageSubmit.getAttribute('id');
              let buttonMessage = document.getElementById(submitId);

              buttonMessage.addEventListener('click', () => {

                  let messageId = buttonMessage.getAttribute('messageId');
                  let recipientId = buttonMessage.getAttribute('recipentId');
                  let recipientType = buttonMessage.getAttribute('recipentType');
                  let messageBox = buttonMessage.getAttribute('messageBox');

                  let directChatBox = document.getElementById(messageBox);
                  let textArea = document.getElementById(messageId);
                  let message = textArea.value;

                  if (message.length > 0) {

                      this.sendPrivateMessage(recipientId, recipientType, message);

                      textArea.value = "";
                      directChatBox.classList.remove('show');

                  } else {

                      textArea.value = "";
                      directChatBox.classList.remove('show');

                  }; //END if

              }); //END listener   

          }; //END for

          let commentsDiv = document.getElementsByClassName('togleComment');

          for (div of commentsDiv) {

              let id = div.getAttribute('id');
              let cont = document.getElementById(id);

              cont.addEventListener('click', () => {

                  if (cont.classList.contains('hideComment')) {

                      cont.classList.remove('hideComment');
                      cont.classList.add('showComment');

                      this.intervalPost(false);

                      let textArea = cont.getElementsByTagName('textarea')[0];
                      textArea.focus();

                      let submitButton = cont.getElementsByTagName('button')[0];

                      submitButton.addEventListener('click', () => {

                          let status = false;
                          this.intervalPost(status);

                          let id = submitButton.getAttribute('dataId');
                          let comment = textArea.value;

                          this.collectCommentData(id, comment);
                          textArea.value = "";

                      }); //END listener


                  } else {

                      cont.classList.add('hideComment');
                      cont.classList.remove('showComment');

                  }; //END if

              }); //END listener   

          }; //END for

      };

  } //END placePostes

  function placeMessagesIndex(json) {

      //console.log(json)

      let response = JSON.parse(json);

      if (response.response == true) {
          this.showMessageIndex(json);
      }; //END if

      let contactMessages = document.getElementById('contactMessages');

      contactMessages.innerHTML = "";

      let previewContent = "";

      let currentUser = response.data.currentUser;

      let toRead = currentUser.toRead;
      toRead == 0 ? toRead = "" : null;

      document.getElementById('idMessageNumberA').innerHTML = toRead;
      document.getElementById('idMessageNumberB').innerHTML = toRead;


      let userData = response.data;
      let idLink = 0;

      for (let keyA in userData) {

          let users = userData[keyA];

          for (let keyB in users) {

              let user = users[keyB];

              if ((typeof user === "object")) {

                  let info = user['info'];
                  let userPicure = "";
                  let userName = info['fullName'];

                  let arrayMessages = user['message'];

                  let lastMessage = arrayMessages[arrayMessages.length - 1];
                  let textPreviw = lastMessage['messageText'].slice(0, 20) + "...";

                  let countNotReadYet = user['count'];
                  countNotReadYet == 0 ? countNotReadYet = "" : null;

                  if (info['profilePhotoLink'] != null) {
                      userPicure = info['profilePhotoLink'].replace(/\-/g, '+');
                  } else {
                      if (info['personalGender'] == 'male') {
                          userPicure = 'dist/img/man_social.jpg';
                      } else {
                          userPicure = 'dist/img/woman_social.jpg';
                      }; //END if
                  }; //END if

                  if (info['accountType'] == 'admin') {
                      userPicure = 'dist/img/doctor.png';
                  }; //END if

                  idLink++;

                  let content = "<li id='idDirectMessage" + idLink + "' dataCurentId='" + currentUser.id + "' dataCurentType='" + currentUser.type + "' dataUserId='" + info['id'] + "' dataUserType='" + info['accountType'] + "' class='linkMessages'>" +
                      "<img class='contacts-list-img mt-3 ml-2 mr-3' src='" + userPicure + "'>" +
                      "<div class='contacts-list-info'>" +
                      "<div class='row'>" +
                      "<div class='col-12'>" +
                      "<span class='contacts-list-name'>" + userName + "</span>" +
                      "</div>" +
                      "</div>" +
                      "<div class='row'>" +
                      "<div class='col-10 col-lg-11'>" +
                      "<small class='contacts-list-date'>" + lastMessage['messageDate'] + " - " + lastMessage['messageHour'] + "</small>" +
                      "</div>" +
                      "<div class='col-1'>" +
                      "<span class='badge badge-danger'>" + countNotReadYet + "</span>" +
                      "</div>" +
                      "</div>" +
                      "<div class='row'>" +
                      "<div class='col-12'>" +
                      "<span class='contacts-list-msg'>" + textPreviw + "</span>" +
                      "</div>" +
                      "</div>" +
                      "</div>" +
                      "</li>";

                  previewContent += content;

              }; //END if

          }; //END for

      }; //END for

      contactMessages.innerHTML = previewContent;

      let linkMessages = document.getElementsByClassName('linkMessages');
      let chatContainer = document.getElementById('chatContainer');
      let idDirectcPrimary = document.getElementById('idDirectcPrimary');

      for (link of linkMessages) {

          let idLink = link.getAttribute('id');

          let listener = document.getElementById(idLink);

          listener.addEventListener('click', () => {

              dataUserId = listener.getAttribute('dataUserId');
              dataUserType = listener.getAttribute('dataUserType');
              dataCurentId = listener.getAttribute('dataCurentId');
              dataCurentType = listener.getAttribute('dataCurentType');

              chatContainer.setAttribute('dataUserId', dataUserId);
              chatContainer.setAttribute('dataUserType', dataUserType);

              this.notifyReadMessage(dataCurentId, dataCurentType, dataUserId, dataUserType);

              this.showMessageIndex(json);

              idDirectcPrimary.classList.remove('direct-chat-contacts-open');

          });


      }; //END for

  } //END placeMessagesIndex

  function notifyReadMessage(dataCurentId, dataCurentType, dataUserId, dataUserType) {

      if (dataUserId && dataUserType) {

          let request = {
                  typology: "notifyReadMessage",
                  dataCurentId: dataCurentId,
                  dataCurentType: dataCurentType,
                  dataUserId: dataUserId,
                  dataUserType: dataUserType
              } //END request

          let myCallback = {
                  function: (json) => {
                          //alert(json)
                          let dataApi = JSON.parse(json);
                          if (dataApi.response == true) {
                              //this.tost('info',' Nofifica di lettura inviata');
                          } else {
                              this.tost('error', " Impossibile notificare la lettura");
                          }; //END if
                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      }; //END if

  } //END placeMessagesIndex;

  function showMessageIndex(json) {

      let response = JSON.parse(json);

      let chatContainer = document.getElementById('chatContainer');
      let dataUserId = chatContainer.getAttribute('dataUserId');
      let dataUserType = chatContainer.getAttribute('dataUserType');

      if (dataUserType != "" && dataUserType != null) {

          chatContainer.innerHTML = "";

          let previewContent = "";
          let content = "";

          let sessionPicture = document.getElementById('userPicture').src;
          let sessionFullName = document.getElementById('profileUserName').innerHTML;

          let idLink = 0;
          let messages;
          let info;

          let userData = response.data;

          messages = userData[dataUserType][dataUserId]['message'];
          info = userData[dataUserType][dataUserId]['info'];

          if ((typeof messages === 'object')) {

              for (let message of messages) {

                  if (message) {

                      let userPicture = "";
                      let userName = info['fullName'];

                      if (info['profilePhotoLink'] != null) {
                          userPicture = info['profilePhotoLink'].replace(/\-/g, '+');
                      } else {
                          if (info['personalGender'] == 'male') {
                              userPicture = 'dist/img/man_social.jpg';
                          } else {
                              userPicture = 'dist/img/woman_social.jpg';
                          }; //END if
                      }; //END if

                      let currentUser = response.data.currentUser;

                      if (currentUser.type == message.senderType && currentUser.id == message.senderId) {

                          content = "<div class='direct-chat-msg col-lg-6'>" +
                              "<div class='direct-chat-infos clearfix'>" +
                              "<span class='direct-chat-name float-left'>" + sessionFullName + "</span>" +
                              "<span class='direct-chat-timestamp float-right'>" + message.messageDate + " - " + message.messageHour + "</span>" +
                              "</div>" +
                              "<img class='direct-chat-img' src='" + sessionPicture + "'>" +
                              "<div class='direct-chat-text text-capitalize'>" +
                              message.messageText +
                              "</div>" +
                              "</div>";

                      } else {

                          content = "<div class='direct-chat-msg right offset-lg-6 col-lg-6'>" +
                              "<div class='direct-chat-infos clearfix'>" +
                              "<span class='direct-chat-name float-right'>" + userName + "</span>" +
                              "<span class='direct-chat-timestamp float-left'>" + message.messageDate + " - " + message.messageHour + "</span>" +
                              "</div>" +
                              "<img class='direct-chat-img' src='" + userPicture + "'>" +
                              "<div class='direct-chat-text text-capitalize'>" +
                              message.messageText +
                              "</div>" +
                              "</div>";

                      }; //END if

                      if (message.senderType == 'admin') {

                          content = "<div class='direct-chat-msg right offset-lg-6 col-lg-6'>" +
                              "<div class='direct-chat-infos clearfix'>" +
                              "<span class='direct-chat-name float-right'>" + userName + "</span>" +
                              "<span class='direct-chat-timestamp float-left'>" + message.messageDate + " - " + message.messageHour + "</span>" +
                              "</div>" +
                              "<img class='direct-chat-img' src='dist/img/doctor.png'>" +
                              "<div class='direct-chat-text text-capitalize'>" +
                              message.messageText +
                              "</div>" +
                              "</div>";

                      }; //END if

                      previewContent += content;

                  }; //END if

              }; //END for

              chatContainer.innerHTML = previewContent;
              chatContainer.scrollTop = chatContainer.scrollHeight;

              let directChatSubmit = document.getElementById('directChatSubmit');
              let directMessage = document.getElementById('directMessage');

              directMessage.addEventListener('keyup', (event) => {
                  if (event.keyCode === 13) {
                      event.preventDefault();
                      directChatSubmit.click();
                  }
              });

              directChatSubmit.addEventListener('click', () => {

                  let directMessage = document.getElementById('directMessage');
                  let textChat = directMessage.value;

                  let dataUserId = chatContainer.getAttribute('dataUserId');
                  let dataUserType = chatContainer.getAttribute('dataUserType');

                  if (textChat.length > 0) {
                      this.sendPrivateMessage(dataUserId, dataUserType, textChat);
                  }; //END if

                  directMessage.value = "";

              }); //END listener

          }; //END if

      }; //END if    

  } //END showMessageIndex

  function sendPrivateMessage(recipientId, recipientType, message) {

      if (message.length > 0) {

          let request = {
                  typology: "directMessage",
                  recipientId: recipientId,
                  recipientType: recipientType,
                  message: message
              } //END request

          let myCallback = {
                  function: (json) => {
                          //alert(json)
                          let dataApi = JSON.parse(json);
                          if (dataApi.response == true) {
                              this.getMessagesIndex();
                              this.tost('success', ' Messaggio inviato');
                          } else {
                              this.tost('error', " Errore durante l'invio");
                          }; //END if
                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      }; //END if

  } //END sendPrivateMessage

  function getPost(status = true) {

      if (status == true) {

          let idFilterPost = document.getElementById("idFilterPost");

          let request = {
                  typology: "getPost",
                  filter: idFilterPost.value
              } //END request

          let myCallback = {
                  function: (json) => {
                          //alert(json)
                          let dataApi = JSON.parse(json);
                          if (dataApi.response == true) {
                              this.placePostes(json);
                          }; //END if
                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } else {

      }; //END if

  } //END getPost

  function getMessagesIndex() {

      let request = {
              typology: "getMessagesIndex"
          } //END request

      let myCallback = {
              function: (json) => {
                      //console.log(json)
                      let dataApi = JSON.parse(json);
                      if (dataApi.response == true) {
                          this.placeMessagesIndex(json);
                      }; //END if
                  } //END function
          } //END myCallback

      let ajax = new Ajax;
      ajax.url("php/data.php");
      ajax.jsonRequest(request);
      ajax.callBack(myCallback)
      ajax.execute();

  } //END getMessagesIndex

  function collectPostData() {

      let inputTitoloPost = document.getElementById("inputTitoloPost");
      let inputTextPost = document.getElementById("inputTextPost");
      let base64Post = document.getElementById("base64Post");

      let title = inputTitoloPost.value;
      let text = inputTextPost.value;

      if (title.length > 0 && text.length > 0) {

          inputTitoloPost.classList.add("is-valid");
          inputTextPost.classList.add("is-valid");

          inputTitoloPost.classList.remove("is-invalid");
          inputTextPost.classList.remove("is-invalid");

          let request = {
                  typology: "publicPost",
                  title: inputTitoloPost.value,
                  text: inputTextPost.value,
                  picture: base64Post.src
              } //END request

          let myCallFirst = {
                  function: () => {
                      let notify = new Alert;
                      notify.freeze();
                  }
              } //END myCallFirst

          let myCallback = {
                  function: (json) => {
                          let notify = new Alert;
                          let dataApi = JSON.parse(json);
                          if (dataApi.response == true) {
                              this.cleanPost();
                              notify.defreeze();
                              this.tost('success', ' Post pubblicato');
                          } else {
                              notify.defreeze();
                              this.tost('error', ' Impossibile pubblicare questo post');
                          }; //END if
                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callFirst(myCallFirst);
          ajax.callBack(myCallback)
          ajax.execute();

      } else {

          inputTitoloPost.classList.add("is-invalid");
          inputTextPost.classList.add("is-invalid");

          inputTitoloPost.classList.remove("is-valid");
          inputTextPost.classList.remove("is-valid");

      } //END if

  } //END collectPostData

  function collectCommentData(postId, textComment) {

      if (postId != null && textComment.length > 0) {

          let request = {
                  typology: "publicComment",
                  postId: postId,
                  text: textComment
              } //END request

          let myCallback = {
                  function: () => {
                          let socialContainer = document.getElementById("socialContainer");
                          let body = document.documentElement;
                          socialContainer.scrollTop = 0;
                          body.scrollTop = 0;
                          this.getPost();
                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if

  } //END collectCommentData

  function collectLoginData() {

      let loginEmail = document.getElementById("loginEmail").value;
      let loginPassword = document.getElementById("loginPassword").value;

      if (loginEmail != null && loginPassword != null) {

          let request = {
                  typology: "userLogin",
                  userEmail: loginEmail,
                  userPassword: loginPassword
              } //END request

          localStorage.setItem('login', JSON.stringify(request));

          let myCallback = {
                  function: (json) => {

                      let loginEmail = document.getElementById("loginEmail");
                      let loginPassword = document.getElementById("loginPassword");

                      loginEmail.value = "";
                      loginPassword.value = "";

                      this.loginSwitch(json);
                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END collectLoginData

  function collectAffiliateLoginData() {

      let loginAffiliateEmail = document.getElementById("loginAffiliateEmail").value;
      let loginAffiliatePassword = document.getElementById("loginAffiliatePassword").value;

      if (loginAffiliateEmail != null && loginAffiliatePassword != null) {

          let request = {
                  typology: "affiliateLogin",
                  affiliateEmail: loginAffiliateEmail,
                  affiliatePassword: loginAffiliatePassword
              } //END request

          localStorage.setItem('login', JSON.stringify(request));

          let myCallback = {
                  function: (json) => {
                      let loginAffiliateEmail = document.getElementById("loginAffiliateEmail");
                      let loginAffiliatePassword = document.getElementById("loginAffiliatePassword");

                      loginAffiliateEmail.value = "";
                      loginAffiliatePassword.value = "";

                      this.loginAffiliateSwitch(json);
                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END collectAffiliateLoginData

  function collectSearchData() {

      let inputSearchUser = document.getElementById("inputSearchUser").value;

      let currentPath = window.location.pathname;
      let currentPage = currentPath.split("/").slice(-1);

      if (inputSearchUser != null && inputSearchUser != null) {

          let request = {
                  typology: "searchUser",
                  searchString: inputSearchUser
              } //END request

          let myCallFirst = {
                  function: () => {
                      if (currentPage == "search.html") {
                          let notify = new Alert;
                          notify.freeze();
                      }; //END if
                  }
              } //END myCallFirst

          let myCallback = {
                  function: (json) => {
                          let notify = new Alert;

                          let dataApi = JSON.parse(json);
                          if (dataApi.response == true || dataApi.response == false) {
                              this.searchSwitch(json);
                              if (currentPage == "search.html") {
                                  notify.defreeze();
                              }; //END if  
                          }; //END if

                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callFirst(myCallFirst);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END collectSearchData

  function sendDirectMessage(message) {

      let directMessage = message;

      if (directMessage != null) {

          let request = {
                  typology: "directChat",
                  message: directMessage
              } //END request

          let myCallback = {
                  function: (json) => {
                      //alert(json);
                      this.appendResponse(json);
                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END sendDirectMessage

  function showChatHint(json) {

      //alert(json)

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let hintString = dataApi.hints;
          let hints = hintString.split(' , ');
          let chatHint = document.getElementById("chatHint");
          let bageList = "";

          for (let hint of hints) {

              let send = {
                  symptom: (message) => {
                      this.appendMessage(message);
                  }
              };

              let badge = "<span class='hintButton btn btn-sm btn-primary mt-1 mr-1'>" + hint + "</span><br>";
              bageList += badge;

          }; //END for

          chatHint.innerHTML = bageList;

          let hintButtons = document.getElementsByClassName("hintButton");

          for (let button of hintButtons) {
              button.addEventListener('click', () => {
                  let message = button.innerHTML;
                  this.appendMessage(message);
              });
          } //END if

      }; //END if  

  } //END showChatHint

  function showTownHint(json) {

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let hintString = dataApi.hints;
          let hints = hintString.split(' , ');
          let townHint = document.getElementById("townHint");
          let inputTown = document.getElementById("inputTown");
          let bageList = "";

          for (let hint of hints) {

              let badge = "<span class='hintButton btn btn-sm btn-primary mt-1 mr-1'>" + hint + "</span><br>";
              bageList += badge;

          }; //END for

          townHint.innerHTML = bageList;

          let hintButtons = document.getElementsByClassName("hintButton");

          let currentPath = window.location.pathname;
          let currentPage = currentPath.split("/").slice(-1);

          let zipField;

          if (currentPage == "profile.html") {
              zipField = document.getElementById('inputZip');
          };

          if (currentPage == "affiliate.html") {
              zipField = document.getElementById('inputAffiliateZipCode');
          };

          for (let button of hintButtons) {
              button.addEventListener('click', () => {
                  inputTown.value = button.innerHTML;
                  townHint.innerHTML = "";
                  zipField.innerHTML = "- aggiorna per confermare -";
              });
          } //END if

      }; //END if  

  } //END showTownHint

  function showFoodHint(json) {

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let hints = dataApi.hints;
          let foodHint = document.getElementById("foodHint");
          let eatenBox = document.getElementById("eatenBox");
          let foodInput = document.getElementById("foodInput");
          let bageList = "";

          for (let hint of hints) {


              let badge = "<span class='hintButton badge " + hint.label + " mt-1 mr-1'>" + hint.name + "</span><br>";
              bageList += badge;

          }; //END for

          foodHint.innerHTML = bageList;

          let hintButtons = document.getElementsByClassName("hintButton");

          for (let button of hintButtons) {
              button.addEventListener('click', () => {
                  foodInput.value = button.innerHTML;
                  this.askFoodInfo(button.innerHTML);
                  foodHint.innerHTML = "";
              });
          } //END if

      }; //END if  

      eatenBox.scrollIntoView();

  } //END showTownHint

  function askFoodInfo(name) {

      if (name != null) {

          let request = {
                  typology: "foodInfo",
                  input: name
              } //END request

          let myCallback = {
                  function: (json) => {
                      //alert(json)
                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {
                          this.showFoodInfo(json);
                      }
                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/diet.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END askFoodInfo

  function askDeleteFood(id) {

      if (id != null) {

          let request = {
                  typology: "deleteFood",
                  input: id
              } //END request

          let myCallback = {
                  function: (json) => {
                          //alert(json)
                          let dataApi = JSON.parse(json);
                          this.showSummary(dataApi);
                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/diet.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END askFoodInfo

  function sendFood(data) {

      if (data) {

          let request = {
                  typology: "foodRecord",
                  data: data
              } //END request

          let myCallback = {
                  function: (json) => {
                          //alert(json)
                          let dataApi = JSON.parse(json);
                          if (dataApi.response == true) {
                              this.dietDiary();
                              this.tost('success', ' Salvato');
                          } else {
                              this.tost('error', " Errore");
                          }; //END if
                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/diet.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      }; //END if

  } //END sendFood

  function dietDiary() {

      let request = {
              typology: "diaryRecord"
          } //END request

      let myCallback = {
              function: (json) => {
                      //alert(json)
                      let dataApi = JSON.parse(json);
                      this.showSummary(dataApi);
                  } //END function
          } //END myCallback

      let ajax = new Ajax;
      ajax.url("php/diet.php");
      ajax.jsonRequest(request);
      ajax.callBack(myCallback)
      ajax.execute();

  } //END sendFood

  function showFoodInfo(json) {

      let data;

      if (json) {
          data = JSON.parse(json);
      } else {
          data = { "info": { "nome": "", "carCanvas": 0, "proCanvas": 0, "graCanvas": 0 } }
      }

      let info = data.info;

      let foodInfo = document.getElementById('foodInfo');

      let foodInput = document.getElementById('foodInput');
      foodInput.focus();

      let foodWeight = document.getElementById('foodWeight');

      if (foodWeight.value == 0 || foodWeight.value.length == 0) {
          foodWeight.value = 100;
      } //IF

      let insertFood = document.getElementById('insertFood');

      if (info.nome.length > 1) {

          insertFood.innerHTML = "<i class='fa fa-chevron-circle-down white-color'></i><b> Inserisci " + info.nome + "</b>";
          insertFood.classList.remove('d-none');
          insertFood.classList.add('d-block');

          foodInfo.innerHTML = "Hai selezionato: <b>" + info.nome + "</b>";

      } //IF

      let other = parseFloat(100 - info.carCanvas - info.proCanvas - info.graCanvas);

      let dataFood = {
          labels: [
              'Carboidrati',
              'Proteine',
              'Grassi',
              ''
          ],
          datasets: [{
              data: [info.carCanvas, info.proCanvas, info.graCanvas, other],
              backgroundColor: ['#3c8dbc', '#00a65a', '#f39c12', '#d2d6de'],
          }]
      }

      let clearFood = {
          labels: [
              'Carboidrati',
              'Proteine',
              'Grassi',
              ''
          ],
          datasets: [{
              data: [0, 0, 0, 100],
              backgroundColor: ['#3c8dbc', '#00a65a', '#f39c12', '#d2d6de'],
          }]
      }

      let pieChartCanvas = document.getElementById("foodChart").getContext('2d');

      let pieOptions = {
          maintainAspectRatio: false,
          responsive: true,
      }

      let pieChart = new Chart(pieChartCanvas, {
          type: 'pie',
          data: dataFood,
          options: pieOptions
      })

      pieChart.render();

      insertFood.addEventListener('click', () => {

              if (foodWeight.value > 0 && foodWeight.value.length > 0 && foodInput.value.length > 0) {

                  let data = {
                          food: foodInput.value,
                          weight: foodWeight.value
                      } //data

                  this.sendFood(data);

                  foodInput.value = "";
                  insertFood.classList.remove('d-block');
                  insertFood.classList.add('d-none');
                  foodInfo.innerHTML = "";
                  foodWeight.value = 100;

                  pieChart = new Chart(pieChartCanvas, {
                      type: 'pie',
                      data: clearFood,
                      options: pieOptions
                  })

                  pieChart.update();
                  pieChart.render();
                  // clearChart.stop();


              } //IF

          }) //insertFood

  } //renderDiet

  function showSummary(data) {

      let eatenFoods = document.getElementById("eatenFoods");

      let carboIngested = document.getElementById("carboIngested");
      let carboLeft = document.getElementById("carboLeft");
      let carboTotal = document.getElementById("carboTotal");

      let protIngested = document.getElementById("protIngested");
      let protLeft = document.getElementById("protLeft");
      let protTotal = document.getElementById("protTotal");

      let grasIngested = document.getElementById("grasIngested");
      let grasLeft = document.getElementById("grasLeft");
      let grasTotal = document.getElementById("grasTotal");

      let kcalIngested = document.getElementById("kcalIngested");
      let kcalLeft = document.getElementById("kcalLeft");
      let kcalTotal = document.getElementById("kcalTotal");

      let diary = data.diary;
      let foods = diary.foods;

      carboTotal.innerHTML = diary.carboidratiDay + " g";
      carboIngested.innerHTML = diary.carboidratiIngested + " g";
      carboLeft.innerHTML = diary.carboidratiRemaining + " g";

      protTotal.innerHTML = diary.proteineDay + " g";
      protIngested.innerHTML = diary.proteineIngested + " g";
      protLeft.innerHTML = diary.proteineRemaining + " g";

      grasTotal.innerHTML = diary.grassiDay + " g";
      grasIngested.innerHTML = diary.fatIngested + " g";
      grasLeft.innerHTML = diary.fatRemaining + " g";

      kcalTotal.innerHTML = diary.kcalDay + " Kcal";
      kcalIngested.innerHTML = diary.kcalIngested + " Kcal";
      kcalLeft.innerHTML = diary.kcalRemaining + " Kcal";

      let eatenList = "";

      eatenFoods.innerHTML = "";

      console.log("---> " + JSON.stringify(diary.overview))

      let labelChart = diary.overview.label;
      let scoreChart = diary.overview.score;


      //SHOW EATEN FOODS
      if (foods.length > 0) {

          for (let food of foods) {

              let badge = "<span class='foodLink badge " + food.label + " mt-1 mr-1'>" +
                  food.foodName + " " + food.foodGrams + "g " +
                  "<button type='button' data='" + food.id + "' class='close deleteFood' aria-label='Dismiss'>" +
                  "<span aria-hidden='true'>&times;</span>" +
                  "</button>" +
                  "</span><br>";

              eatenList += badge;

          } //for

          eatenFoods.innerHTML = eatenList;

          let deleteFood = document.getElementsByClassName("deleteFood");

          for (let button of deleteFood) {
              button.addEventListener('click', () => {
                  let id = button.getAttribute('data');
                  this.askDeleteFood(id);
              });
          } //END if

      } //IF

      //KCAL CANVAS
      var kcalChartCanvas = document.getElementById("kcalChart").getContext('2d')
      var kcalData = {
          labels: [
              'KCal ingerite',
              'KCal restanti',
          ],
          datasets: [{
              data: [diary.kcalIngested, diary.kcalRemaining],
              backgroundColor: ['#f56954', '#d2d6de'],
          }]
      }

      var kcalOptions = {
          maintainAspectRatio: false,
          responsive: true,
      }

      var kcalChart = new Chart(kcalChartCanvas, {
          type: 'doughnut',
          data: kcalData,
          options: kcalOptions
      })



      kcalChart.render();

      //PROT CANVAS
      var protChartCanvas = document.getElementById("protChart").getContext('2d')
      var protData = {
          labels: [
              'Proteine',
              'Restanti',
          ],
          datasets: [{
              data: [diary.proteineIngested, diary.proteineRemaining],
              backgroundColor: ['#00a65a', '#d2d6de'],
          }]
      }

      var protOptions = {
          maintainAspectRatio: false,
          responsive: true,
      }

      var protChart = new Chart(protChartCanvas, {
          type: 'doughnut',
          data: protData,
          options: protOptions
      })

      protChart.render();

      //CARB CANVAS
      var carbChartCanvas = document.getElementById("carbChart").getContext('2d')
      var carbData = {
          labels: [
              'Carboidrati',
              'Restanti',
          ],
          datasets: [{
              data: [diary.carboidratiIngested, diary.carboidratiRemaining],
              backgroundColor: ['#3c8dbc', '#d2d6de'],
          }]
      }

      var carbOptions = {
          maintainAspectRatio: false,
          responsive: true,
      }

      var carbChart = new Chart(carbChartCanvas, {
          type: 'doughnut',
          data: carbData,
          options: carbOptions
      })

      carbChart.render();

      //FAT CANVAS
      var grasChartCanvas = document.getElementById("grasChart").getContext('2d')
      var grasData = {
          labels: [
              'Grassi',
              'Restanti',
          ],
          datasets: [{
              data: [diary.fatIngested, diary.fatRemaining],
              backgroundColor: ['#f39c12', '#d2d6de'],
          }]
      }

      var grasOptions = {
          maintainAspectRatio: false,
          responsive: true,
      }

      var grasChart = new Chart(grasChartCanvas, {
          type: 'doughnut',
          data: grasData,
          options: grasOptions
      })

      grasChart.render();

      //CHART CANVAS
      var lineChartCanvas = document.getElementById("lineChart").getContext('2d')

      var lineData = {
          labels: labelChart,
          datasets: [{
                  label: 'Digital Goods',
                  backgroundColor: 'rgba(60,141,188,0.9)',
                  borderColor: 'rgba(60,141,188,0.8)',
                  pointRadius: false,
                  pointColor: '#3b8bba',
                  pointStrokeColor: 'rgba(60,141,188,1)',
                  pointHighlightFill: '#fff',
                  pointHighlightStroke: 'rgba(60,141,188,1)',
                  data: scoreChart
              },
              {
                  label: 'Electronics',
                  backgroundColor: 'rgba(210, 214, 222, 1)',
                  borderColor: 'rgba(210, 214, 222, 1)',
                  pointRadius: false,
                  pointColor: 'rgba(210, 214, 222, 1)',
                  pointStrokeColor: '#c1c7d1',
                  pointHighlightFill: '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',
                  data: [65, 59, 80, 81, 56, 55, 40]
              },
          ]
      }

      var lineOptions = {
          maintainAspectRatio: false,
          responsive: true,
      }

      lineData.datasets[0].fill = false;
      lineData.datasets[1].fill = false;
      lineOptions.datasetFill = false

      var lineChart = new Chart(lineChartCanvas, {
          type: 'line',
          data: lineData,
          options: lineOptions
      })

      lineChart.render();



  } //showSummary

  function requestChatHint(message) {

      if (message != null) {

          let request = {
                  typology: "chatHint",
                  message: message
              } //END request

          let myCallback = {
                  function: (json) => {
                      //alert(json)
                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {
                          this.showChatHint(json);
                      }
                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END requestChatHint

  function requestTownHint(input) {

      if (input != null) {

          let request = {
                  typology: "townHint",
                  input: input
              } //END request

          let myCallback = {
                  function: (json) => {
                      //alert(json)
                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {
                          this.showTownHint(json);
                      }
                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END requestTownHint

  function requestFoodHint(input) {

      if (input != null) {

          let request = {
                  typology: "foodHint",
                  input: input
              } //END request

          let myCallback = {
                  function: (json) => {
                      //alert(json)
                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {
                          this.showFoodHint(json);
                      }
                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/diet.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END requestTownHint

  function appendMessage(message) {

      let userName = document.getElementById("profileUserName").innerHTML;
      let userPicture = document.getElementById("userPicture").src;
      let chatContainer = document.getElementById("chatContainer");
      let directMessage = document.getElementById("directMessage");
      let chatHint = document.getElementById("chatHint");
      chatHint.innerHTML = "";

      let date = new Date();

      let monthName = new Array();
      monthName[0] = "Gen";
      monthName[1] = "Feb";
      monthName[2] = "Mar";
      monthName[3] = "Apr";
      monthName[4] = "Mag";
      monthName[5] = "Giu";
      monthName[6] = "Lug";
      monthName[7] = "Ago";
      monthName[8] = "Set";
      monthName[9] = "Ott";
      monthName[10] = "Nov";
      monthName[11] = "Dec";

      let day = date.getDate();
      let month = monthName[date.getMonth()];
      let year = date.getFullYear();
      let hour = date.getHours();
      let minutes = date.getMinutes();

      let data = day + " " + month + " " + year + " " + hour + ":" + minutes;

      directMessage.value = "";

      let template = "<div class='direct-chat-msg'>" +
          "<div class='direct-chat-infos clearfix'>" +
          "<span class='direct-chat-name float-left'>" + userName + "</span>" +
          "<span class='direct-chat-timestamp float-right'>" + data + "</span>" +
          "</div>" +
          "<img class='direct-chat-img' src='" + userPicture + "'>" +
          "<div class='direct-chat-text text-capitalize'>" +
          message +
          "</div>" +
          "</div>";

      chatContainer.innerHTML += template;
      chatContainer.scrollTop = chatContainer.scrollHeight;

      this.sendDirectMessage(message);

  } //END appendMessage

  function appendResponse(json) {

      //alert(json);

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let message = dataApi.message;

          let doctorName = "Dott.ssa Hope";
          let doctorPicture = "dist/img/doctor.png";
          let chatContainer = document.getElementById("chatContainer");

          let date = new Date();

          let monthName = new Array();
          monthName[0] = "Gen";
          monthName[1] = "Feb";
          monthName[2] = "Mar";
          monthName[3] = "Apr";
          monthName[4] = "Mag";
          monthName[5] = "Giu";
          monthName[6] = "Lug";
          monthName[7] = "Ago";
          monthName[8] = "Set";
          monthName[9] = "Ott";
          monthName[10] = "Nov";
          monthName[11] = "Dec";

          let day = date.getDate();
          let month = monthName[date.getMonth()];
          let year = date.getFullYear();
          let hour = date.getHours();
          let minutes = date.getMinutes();

          let data = day + " " + month + " " + year + " " + hour + ":" + minutes;

          let template = "<div class='direct-chat-msg right'>" +
              "<div class='direct-chat-infos clearfix'>" +
              "<span class='direct-chat-name float-right'>" + doctorName + "</span>" +
              "<span class='direct-chat-timestamp float-left'>" + data + "</span>" +
              "</div>" +
              "<img class='direct-chat-img' src='" + doctorPicture + "'>" +
              "<div class='direct-chat-text text-capitalize'>" +
              message +
              "</div>" +
              "</div>";

          chatContainer.innerHTML += template;
          chatContainer.scrollTop = chatContainer.scrollHeight;

          if (dataApi.refresh === true) {
              this.refreshTimeLine();
          }; //END if  

      }; //END if  

  } //END appendResponse

  function collectRegisterData() {

      let registerEmail = document.getElementById("registerEmail").value;
      let registerFirstPassword = document.getElementById("registerFirstPassword").value;
      let registerSecondPassword = document.getElementById("registerSecondPassword").value;

      if (registerEmail != null && registerFirstPassword != null && registerSecondPassword != null && registerFirstPassword != " " && registerSecondPassword != " " && registerFirstPassword === registerSecondPassword) {

          let request = {
                  typology: "registerUser",
                  userEmail: registerEmail,
                  userPassword: registerFirstPassword
              } //END request

          let myCallFirst = {
                  function: () => {
                      let notify = new Alert;
                      notify.freeze();
                  }
              } //END myCallFirst

          let myCallback = {
                  function: (json) => {
                          //alert(json)
                          let dataApi = JSON.parse(json);
                          if (dataApi.response === true) {
                              this.loginSwitch(json);
                          } else {
                              this.tost('warning', " Dati non corretti, utente già prresente.");
                          } //END if
                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callFirst(myCallFirst)
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if

  } //END collectRegisterData

  function collectRegisterAffiliationData() {

      let affiliationType = document.getElementById("affiliationType").value;
      let affiliationEmail = document.getElementById("affiliationEmail").value;
      let affiliationFirstPassword = document.getElementById("affiliationFirstPassword").value;
      let affiliationSecondPassword = document.getElementById("affiliationSecondPassword").value;

      if (affiliationType != null && affiliationEmail != null && affiliationFirstPassword != null && affiliationSecondPassword != null && affiliationFirstPassword != " " && affiliationSecondPassword != " " && affiliationFirstPassword === affiliationSecondPassword) {

          let request = {
                  typology: "registerAffiliate",
                  affiliateType: affiliationType,
                  affiliateEmail: affiliationEmail,
                  affiliatePassword: affiliationFirstPassword
              } //END request

          let myCallFirst = {
                  function: () => {
                      let notify = new Alert;
                      notify.freeze();
                  }
              } //END myCallFirst

          let myCallback = {
                  function: (json) => {
                          //alert(json)
                          let notify = new Alert;
                          let dataApi = JSON.parse(json);
                          if (dataApi.response === true) {
                              this.loginAffiliateSwitch(json);
                          } else {
                              notify.warning("Dati non corretti!");
                          } //END if
                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callFirst(myCallFirst)
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if


  } //END collectRegisterAffiliationData

  function searchCheck() {

      //alert(json);

      let currentPath = window.location.pathname;
      let currentPage = currentPath.split("/").slice(-1);

      if (currentPage == "search.html") {

          let request = {
                  typology: "lastResult"
              } //END request

          let myCallFirst = {
                  function: () => {
                      let notify = new Alert;
                      notify.freeze();
                  }
              } //END myCallFirst

          let myCallback = {
                  function: (json) => {
                          let notify = new Alert;
                          let dataApi = JSON.parse(json);
                          if (dataApi.response == true || dataApi.response == false) {
                              this.searchResult(json);
                              notify.defreeze();
                          }; //END if

                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callFirst(myCallFirst)
          ajax.callBack(myCallback)
          ajax.execute();

      }; //END if

  } //END searchSwitch

  function searchSwitch(json) {

      //alert(json);

      let currentPath = window.location.pathname;
      let currentPage = currentPath.split("/").slice(-1);

      if (currentPage != "search.html") {

          window.location.href = "search.html";

      } else {

          let dataApi = JSON.parse(json);

          if (dataApi.response === true || dataApi.response === false) {
              this.searchResult(json);
          } //END if 

      }; //END if

  } //END searchSwitch

  function searchResult(json) {

      //alert(json);

      let dataApi = JSON.parse(json);

      let resultContainer = document.getElementById('resultContainer');

      let resultContent = "";

      if (dataApi.response === true) {

          let result = dataApi.data.result;

          for (let user of result) {

              let useDefaultPic = true;
              let userPicture;

              let profileBloodGroup = user.additionalBloodGroup;
              profileBloodGroup = profileBloodGroup.replace(/p/g, '+');
              profileBloodGroup = profileBloodGroup.replace(/n/g, '-');
              profileBloodGroup.length <= 0 ? profileBloodGroup = null : null;

              let infoUser = "";

              if (profileBloodGroup !== null) {
                  infoUser += "<p class='small mb-2 text-muted'><i class='fa fa-medkit'></i> Gruppo sanguigno: " + profileBloodGroup + "</p>";
              }; //END if

              user.personalCodiceFiscale.length <= 0 ? user.personalCodiceFiscale = null : null;

              if (user.personalCodiceFiscale !== null) {
                  infoUser += "<p class='small mb-2 text-muted'><i class='fa fa-address-card'></i> Codice fiscale: " + user.personalCodiceFiscale + "</p>";
              }; //END if

              if (user.profilePhotoLink !== null && user.profilePhotoLink !== undefined) {

                  let base64Mysql = user.profilePhotoLink;
                  let base64 = base64Mysql.replace(/\-/g, '+');
                  useDefaultPic = false;
                  userPicture = base64;

              }; //END if

              if (useDefaultPic === true || user.profilePhotoLink === null || user.profilePhotoLink === "" || user.profilePhotoLink.length < 50) {
                  if (user.personalGender == 'female') {
                      userPicture = "dist/img/userWoman.jpg";
                  } else {
                      userPicture = "dist/img/userMan.jpg";
                  } //END if  
              } //END if

              let userName = user.personalFirstName + " " + user.personalLastName;

              let resultTemplate = "<div class='card col'>" +
                  "<div class='card-header'>" +
                  "<h3 class='card-title text-capitalize font-weight-bold'>" + userName + "</h3>" +
                  "<div class='card-tools'>" +
                  "<button type='button' class='btn btn-tool' data-card-widget='collapse' data-toggle='tooltip' title='Collapse'>" +
                  "<i class='fas fa-minus'></i>" +
                  "</button>" +
                  "</div>" +
                  "</div>" +
                  "<div class='container row card-body justify-content-md-left'>" +
                  "<div class='col col-md-2 mt-2'>" +
                  "<img class='direct-chat-img' src='" + userPicture + "'>" +
                  "</div>" +

                  "<div class='col col-md-8 mt-2'>" +
                  infoUser +
                  "</div>" +

                  "<div class='col col-md-2 mt-2'>" +
                  "</div>" +

                  "</div>" +
                  "<div class='card-footer'>" +
                  "<a href='profilo_sanitario.html?id=" + user.id + "' target='_blank' class='card-link no-print'>scheda sanitaria</a>" +
                  "</div>" +
                  "</div>";

              resultContent += resultTemplate;

          }; //END for

          resultContainer.innerHTML = resultContent;

      } else {

          resultContainer.innerHTML = "<div class='card col'>" +
              "<div class='card-header'>" +
              "<h3 class='card-title text-capitalize font-weight-normal'>Risultato della ricerca:</h3>" +
              "<div class='card-tools'>" +
              "<button type='button' class='btn btn-tool' data-card-widget='collapse' data-toggle='tooltip' title='Collapse'>" +
              "<i class='fas fa-minus'></i>" +
              "</button>" +
              "</div>" +
              "</div>" +
              "<div class='container row card-body justify-content-md-left'>" +
              "<p>Nessun dato corrispondente ai criteti utilizzati</p>";
          "</div>" +
          "<div class='card-footer'>" +
          "</div>" +
          "</div>";

      }; //END if

  } //END searchResult

  function loginSwitch(json) {

      //alert(json);

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          window.location.href = "profile.html";

      } else {

          this.tost('error', " Dati non validi, riprova.");

      } //END if 


  } //END LOGIN SWITCH

  function loginAffiliateSwitch(json) {

      //alert(json);

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          window.location.href = "affiliate.html";

      } else {

          this.tost('error', " Dati non validi, riprova.");

      } //END if 


  } //END loginAffiliateSwitch

  function validationData() {

      let elements = document.getElementsByClassName("form-control");
      let isValid = true;
      let focusField = [];

      for (let element of elements) {

          if (element.classList.contains("no-form-check") == false) {
              if (element.value === null || element.value === undefined || element.value === "" || element.value === " ") {
                  element.classList.add("is-invalid");
                  element.classList.remove("is-valid");
                  isValid = false;
              } else {
                  element.classList.remove("is-invalid");
                  element.classList.add("is-valid");
              } //END if
          } //END if

      } //END for

      //TAB CONTAINERS
      let personalData = document.getElementById('personalData');
      let lifeStyleData = document.getElementById('lifeStyleData');
      let additionalData = document.getElementById('additionalData');
      let vaccinationsData = document.getElementById('vaccinationsData');
      let missingOrgansData = document.getElementById('missingOrgansData');

      //TAB LINKS
      let personalDataTab = document.getElementById('personalDataTab');
      let lifeStyleDataTab = document.getElementById('lifeStyleDataTab');
      let additionalDataTab = document.getElementById('additionalDataTab');
      let vaccinationsDataTab = document.getElementById('vaccinationsDataTab');
      let missingOrgansDataTab = document.getElementById('missingOrgansDataTab');

      //SEARCH INVALID CLASSES
      let personalDataInvalidField = personalData.getElementsByClassName('is-invalid');
      let lifeStyleDataInvalidField = lifeStyleData.getElementsByClassName('is-invalid');
      let additionalDataInvalidField = additionalData.getElementsByClassName('is-invalid');
      let vaccinationsDataInvalidField = vaccinationsData.getElementsByClassName('is-invalid');
      let missingOrgansDataInvalidField = missingOrgansData.getElementsByClassName('is-invalid');

      let focusTab = null;

      if (personalDataInvalidField.length > 0) {
          focusTab = personalDataTab;
          focusField = personalDataInvalidField[0];
      };

      if (lifeStyleDataInvalidField.length > 0) {
          focusTab = lifeStyleDataTab;
          focusField = lifeStyleDataInvalidField[0];
      };

      if (additionalDataInvalidField.length > 0) {
          focusTab = additionalDataTab;
          focusField = additionalDataInvalidField[0];
      };

      if (vaccinationsDataInvalidField.length > 0) {
          focusTab = vaccinationsDataTab;
          focusField = vaccinationsDataInvalidField[0];
      };

      if (missingOrgansDataInvalidField.length > 0) {
          focusTab = missingOrgansDataTab;
          focusField = missingOrgansDataInvalidField[0];
      };

      if (isValid === true) {
          let data = this.collectProfileInfo();
          this.collectDataSubmit(data);
      } else {
          if (focusTab !== null) {
              focusTab.click();
              focusTab.focus();
              focusField.focus();
          } //END if
      } //END if

  } //END validationData

  function validationAffiliteData() {

      let elements = document.getElementsByClassName("form-control");
      let isValid = true;
      let focusField = [];

      for (let element of elements) {
          if (element.classList.contains("no-form-check") == false) {
              if (element.value === null || element.value === undefined || element.value === "" || element.value === " ") {
                  element.classList.add("is-invalid");
                  element.classList.remove("is-valid");
                  isValid = false;
              } else {
                  element.classList.remove("is-invalid");
                  element.classList.add("is-valid");
              } //END if
          } //END if
      } //END for

      //TAB CONTAINERS
      let personalData = document.getElementById('personalData');
      let companyProfileData = document.getElementById('companyProfileData');

      //TAB LINKS
      let personalDataTab = document.getElementById('personalDataTab');
      let companyProfileDataTab = document.getElementById('companyProfileDataTab');

      //SEARCH INVALID CLASSES
      let personalDataInvalidField = personalData.getElementsByClassName('is-invalid');
      let companyProfileDataField = companyProfileData.getElementsByClassName('is-invalid');

      let focusTab = null;

      if (personalDataInvalidField.length > 0) {
          focusTab = personalDataTab;
          focusField = personalDataInvalidField[0];
      };

      if (companyProfileDataField.length > 0) {
          focusTab = companyProfileDataTab;
          focusField = companyProfileDataField[0];
      };

      if (isValid === true) {
          let data = this.collectAffiliateInfo();
          this.collectAffiliateSubmit(data);
      } else {
          if (focusTab !== null) {
              focusTab.click();
              focusTab.focus();
              focusField.focus();
          } //END if
      } //END if

  } //END validationAffiliteData

  function loadUserProfile() {

      let request = {
              typology: "loadUserProfile"
          } //END data

      let myCallFirst = {
              function: () => {
                  let notify = new Alert;
                  notify.freeze();
              }
          } //END myCallFirst

      let myCallback = {
              function: (json) => {
                      this.placeUserData(json);
                      let notify = new Alert;

                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {
                          notify.defreeze();
                      } else {
                          window.location.href = "login.html";
                      } //END if
                  } //END function
          } //END myCallback

      let ajax = new Ajax;
      ajax.url("php/data.php");
      ajax.jsonRequest(request);
      ajax.callFirst(myCallFirst);
      ajax.callBack(myCallback);
      ajax.execute();

  } //END loadUserProfile

  function loadDiet() {

      let request = {
              typology: "loadUserProfile"
          } //END data

      let myCallFirst = {
              function: () => {
                  let notify = new Alert;
                  notify.freeze();
              }
          } //END myCallFirst

      let myCallback = {
              function: (json) => {
                      this.placeDiet(json);
                      let notify = new Alert;

                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {
                          notify.defreeze();
                      } else {
                          window.location.href = "login.html";
                      } //END if
                  } //END function
          } //END myCallback

      let ajax = new Ajax;
      ajax.url("php/data.php");
      ajax.jsonRequest(request);
      ajax.callFirst(myCallFirst);
      ajax.callBack(myCallback);
      ajax.execute();

  } //END loadDiet

  function loadUserPricing() {

      let request = {
              typology: "loadUserPricing"
          } //END data

      let myCallFirst = {
              function: () => {
                  let notify = new Alert;
                  //notify.freeze();
              }
          } //END myCallFirst

      let myCallback = {
              function: (json) => {

                      //alert(json);

                      this.placeUserPricing(json);
                      let notify = new Alert;

                      let dataApi = JSON.parse(json);
                      //if(dataApi.response===true){
                      if (dataApi.response) {
                          notify.defreeze();
                      } else {
                          window.location.href = "login.html";
                      } //END if
                  } //END function
          } //END myCallback

      let ajax = new Ajax;
      ajax.url("php/data.php");
      ajax.jsonRequest(request);
      ajax.callFirst(myCallFirst);
      ajax.callBack(myCallback);
      ajax.execute();

  } //END loadUserPricing

  function loadAffiliateProfile() {

      let request = {
              typology: "loadAffiliateProfile"
          } //END data

      let myCallFirst = {
              function: () => {
                  let notify = new Alert;
                  notify.freeze();
              }
          } //END myCallFirst

      let myCallback = {
              function: (json) => {
                      this.placeAffiliateData(json);
                      let notify = new Alert;

                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {
                          notify.defreeze();
                      } else {
                          window.location.href = "affiliation_login.html";
                      } //END if

                  } //END function

          } //END myCallback

      let ajax = new Ajax;
      ajax.url("php/data.php");
      ajax.jsonRequest(request);
      ajax.callFirst(myCallFirst);
      ajax.callBack(myCallback);
      ajax.execute();

  } //END loadAffiliateProfile

  function loadUserCard() {

      let request = {
              typology: "loadUserCard"
          } //END data

      let myCallFirst = {
              function: () => {
                  let notify = new Alert;
                  notify.freeze();
              }
          } //END myCallFirst

      let myCallback = {
              function: (json) => {
                      let notify = new Alert;
                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {
                          notify.defreeze();
                          this.placeUserCard(json);
                      } else {
                          window.location.href = "login.html";
                      } //END if
                  } //END function
          } //END myCallback

      let ajax = new Ajax;
      ajax.url("php/data.php");
      ajax.jsonRequest(request);
      ajax.callFirst(myCallFirst);
      ajax.callBack(myCallback);
      ajax.execute();

  } //END loadUserCard

  function loadUserCheckup() {

      let request = {
              typology: "loadUserProfile"
          } //END data

      let myCallFirst = {
              function: () => {
                  let notify = new Alert;
                  notify.freeze();
              }
          } //END myCallFirst

      let myCallback = {
              function: (json) => {

                      //alert(json);

                      let notify = new Alert;
                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {
                          notify.defreeze();
                          this.placeUserCheckup(json);
                      } else {
                          window.location.href = "login.html";
                      } //END if
                  } //END function
          } //END myCallback

      let ajax = new Ajax;
      ajax.url("php/data.php");
      ajax.jsonRequest(request);
      ajax.callFirst(myCallFirst);
      ajax.callBack(myCallback);
      ajax.execute();

  } //END loadUserCheckup

  function updatePrivacy() {

      let privacyName = document.getElementById('privacyName');
      let privacyPhoto = document.getElementById('privacyPhoto');
      let privacyCard = document.getElementById('privacyCard');
      let privacyAddress = document.getElementById('privacyAddress');
      let privacyEmail = document.getElementById('privacyEmail');
      let privacyPhone = document.getElementById('privacyPhone');

      let privacyData = {
              typology: "updatePrivacy",
              privacySetting: {
                  privacyName: privacyName.data,
                  privacyPhoto: privacyPhoto.data,
                  privacyCard: privacyCard.data,
                  privacyAddress: privacyAddress.data,
                  privacyEmail: privacyEmail.data,
                  privacyPhone: privacyPhone.data
              }
          } //END privacyStatus

      // Converting JSON data to string 
      let data = JSON.stringify(privacyData);

      if (data) {

          let myCallFirst = {
                  function: () => {
                      let notify = new Alert;
                      notify.freeze();
                  }
              } //END myCallFirst

          let myCallback = {
                  function: (json) => {

                      let dataApi = JSON.parse(json);
                      let notify = new Alert;

                      if (dataApi.response === true) {
                          this.loadUserCard();
                      } else {
                          notify.danger(dataApi.message);
                      } //END if

                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(privacyData);
          ajax.callFirst(myCallFirst);
          ajax.callBack(myCallback);
          ajax.execute();

      } //END data




  } //END updatePrivacy

  function placeUserData(json) {

      //alert(json);

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let user = dataApi.data.user;

          let userName = user.personalFirstName + " " + user.personalLastName;
          let birthYear = user.personalBirthDay.split('/')[2];
          let currentYear = new Date();
          currentYear = currentYear.getFullYear();
          let profileUserAge = parseInt(currentYear - birthYear);
          profileUserAge > 0 ? profileUserAge : profileUserAge = "";

          user.additionalCheckedList == null ? user.additionalCheckedList = "" : null;

          let profileBloodGroup = user.additionalBloodGroup;
          profileBloodGroup = profileBloodGroup.replace(/p/g, '+');
          profileBloodGroup = profileBloodGroup.replace(/n/g, '-');

          let infoEducation;

          switch (user.styleEducation) {
              case 'noEducation':
                  infoEducation = 'Nessuna';
                  break;
              case 'elementaryEducation':
                  infoEducation = 'Elementare';
                  break;
              case 'middleEducation':
                  infoEducation = 'Media';
                  break;
              case 'highSchoolEducation':
                  infoEducation = 'Superiore';
                  break;
              case 'graduateEducation':
                  infoEducation = 'Laurea';
                  break;
          };

          if (user.accountStatus != 'active') {
              document.getElementById('updatePaypent').innerHTML = "<a href='pricing.php' target='_blanck' class='btn btn-warning btn-block'><i class='fa fa-shopping-cart'></i><b> Abbonati subito</b></a>";
          } else {
              document.getElementById('updatePaypent').innerHTML = "";
          };

          document.getElementById("townHint").innerHTML = "";
          document.getElementById("profileBloodGroup").innerHTML = profileBloodGroup;
          document.getElementById("profileUserName").innerHTML = userName;
          document.getElementById("inputEmail").innerHTML = user.profileActivationEmail;
          document.getElementById("inputFiscalCode").value = user.personalCodiceFiscale;
          document.getElementById("inputName").value = user.personalFirstName;
          document.getElementById("inputSurname").value = user.personalLastName;
          document.getElementById("inputGender").value = user.personalGender;

          this.dinamicProfession();

          document.getElementById("inputPersonalPhone").value = user.profilePhoneNumber;
          document.getElementById("inputBirthDay").value = user.personalBirthDay;
          document.getElementById("inputBirthPlace").value = user.personalBirthPlace;
          document.getElementById("inputAddress").value = user.personalAddress;
          document.getElementById("inputZip").innerHTML = user.personalZipCode;
          document.getElementById("inputTown").value = user.personalTown;
          document.getElementById("inputProfession").value = user.personalProfession;
          document.getElementById("profileUserProfession").innerHTML = user.personalProfession;

          document.getElementById("profileUserAge").innerHTML = profileUserAge;
          document.getElementById("inputWeight").value = user.styleWeight;
          document.getElementById("inputHeight").value = user.styleHeight;
          document.getElementById("checkboxAddictions").value = user.checkboxAddictions;
          document.getElementById("inputAddictionsDescriptions").value = user.styleDrugs;
          document.getElementById("inputEducation").value = user.styleEducation;
          document.getElementById("sideInfoEducation").innerHTML = infoEducation;
          document.getElementById("sideInfoLocation").innerHTML = user.personalAddress + " <br> " + user.personalZipCode + " <br> " + (user.personalTown).toUpperCase();
          document.getElementById("sideInfoExpiration").innerHTML = user.accountExpiration;

          document.getElementById("inputMaritalStatus").value = user.styleMaritalStatus;
          document.getElementById("inputBloodGroup").value = user.additionalBloodGroup;
          document.getElementById("inputMemebershipAsl").value = user.additionalAsl;
          document.getElementById("inputDoctorName").value = user.additionalDoctorName;
          document.getElementById("inputDoctorPhone").value = user.additionalDoctorPhone;
          document.getElementById("inputSmoke").value = user.styleSmoke;
          document.getElementById("inputDrink").value = user.styleDrink;

          let userPicture = document.getElementById("userPicture");
          let base64Photo = document.getElementById("base64Photo");
          base64Photo.src = null;

          if (user.profilePhotoLink !== null && user.profilePhotoLink !== undefined) {

              let base64Mysql = user.profilePhotoLink;
              let base64 = base64Mysql.replace(/\-/g, '+');
              userPicture.src = base64;
              base64Photo.src = base64Mysql;
          }; //END if

          if (user.profilePhotoLink === "" || user.profilePhotoLink === null || user.profilePhotoLink.length < 50 || base64Photo.src === null || base64Photo.src === undefined) {

              if (user.personalGender === "male") {
                  userPicture.src = "dist/img/userMan.jpg"
              } else {
                  userPicture.src = "dist/img/userWoman.jpg"
              };

          }; //END if

          //PLACE CHECKBOX LIST
          let arrayElements = user.additionalCheckedList.split(",");

          if (arrayElements.length > 0) {
              for (let element of arrayElements) {
                  if (element !== "" && element !== null) {
                      document.getElementById(element).checked = true;
                  }
              } //END for
          } //END if

          let checkboxAddictions = document.getElementById("checkboxAddictions");
          let divAddictions = document.getElementById("checkboxAddictionsDescription");

          if (checkboxAddictions.checked === true) {
              divAddictions.style.display = "block";
          } else {
              divAddictions.style.display = "none";
          } //END if

          if (user.timeLine.length > 0) {
              this.timeLine(user.timeLine);
          } //END if

      } //END if  

  } //END placeUserData

  function placeDiet(json) {

      //alert(json);

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let user = dataApi.data.user;

          let userName = user.personalFirstName + " " + user.personalLastName;
          let birthYear = user.personalBirthDay.split('/')[2];
          let currentYear = new Date();
          currentYear = currentYear.getFullYear();
          let profileUserAge = parseInt(currentYear - birthYear);
          profileUserAge > 0 ? profileUserAge : profileUserAge = "";

          document.getElementById("profileUserName").innerHTML = userName;
          document.getElementById("profileUserProfession").innerHTML = user.personalProfession;

          let userPicture = document.getElementById("userPicture");
          let base64Photo = document.getElementById("base64Photo");
          base64Photo.src = null;

          if (user.profilePhotoLink !== null && user.profilePhotoLink !== undefined) {

              let base64Mysql = user.profilePhotoLink;
              let base64 = base64Mysql.replace(/\-/g, '+');
              userPicture.src = base64;
              base64Photo.src = base64Mysql;
          }; //END if

          if (user.profilePhotoLink === "" || user.profilePhotoLink === null || user.profilePhotoLink.length < 50 || base64Photo.src === null || base64Photo.src === undefined) {

              if (user.personalGender === "male") {
                  userPicture.src = "dist/img/userMan.jpg"
              } else {
                  userPicture.src = "dist/img/userWoman.jpg"
              };

          }; //END if

          if (user.diet.length > 10) {

              let diet = JSON.parse(user.diet);

              if (diet.status == 'active') {

                  document.getElementById("dietAge").innerHTML = diet.age + " anni";
                  document.getElementById("dietCurrentWeight").innerHTML = diet.currentWeight + " kg";
                  document.getElementById("dietIdealWeight").innerHTML = diet.idealWeight + " kg";
                  document.getElementById("dietClass").innerHTML = diet.class;
                  document.getElementById("dietStart").innerHTML = diet.start;

              } //IF

          } else {
              let alert = "<li class='list-group-item'>" +
                  "<b>Diario alimentare</b> <a class='float-right'>NON ATTIVO</a>" +
                  "</li>" +
                  "<li class='list-group-item'>" +
                  "<p class='text-muted'>Devi iniziare una <b>dieta</b> per attivare il diario. Esegui un <a href='checkup.html' class='btn btn-danger btn-sm'><b> Check-up</b></a> e segui le istruzioni per creare una dieta.</p>" +
                  "</li>";
              document.getElementById("dietBoard").innerHTML = alert;
          } //IF

          if (user.timeLine.length > 0) {
              this.timeLine(user.timeLine);
          } //END if

          this.renderDiet();

      } //END if  

  } //END placeUserData

  function renderDiet() {

      this.showFoodInfo();

      this.dietDiary();

  } //renderDiet

  function placeUserPricing(json) {

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let user = dataApi.data.user;

          let data = {
              user: user
          }

          let customData = JSON.stringify(data);

          if (user.accountStatus != 'active') {

              if (user.accountType == 'user') {

                  let user_box_base = document.getElementById('user_box_base');
                  user_box_base.classList.remove('d-none');
                  user_box_base.classList.add('d-block');

                  let user_box_medium = document.getElementById('user_box_medium');
                  user_box_medium.classList.remove('d-none');
                  user_box_medium.classList.add('d-block');

                  let user_box_premium = document.getElementById('user_box_premium');
                  user_box_premium.classList.remove('d-none');
                  user_box_premium.classList.add('d-block');

                  let baseCustomData = document.getElementById('baseCustomData');
                  baseCustomData.value = customData;

                  let mediumCustomData = document.getElementById('mediumCustomData');
                  mediumCustomData.value = customData;

                  let premiumCustomData = document.getElementById('premiumCustomData');
                  premiumCustomData.value = customData;

              } //END IF  

              if (user.accountType == 'affiliate') {

                  let affilate_box = document.getElementById('affilate_box');
                  affilate_box.classList.remove('d-none');
                  affilate_box.classList.add('d-block');

                  let affilate_info = document.getElementById('affilate_info');
                  affilate_info.classList.remove('d-none');
                  affilate_info.classList.add('d-block');

                  let affilate_bottom = document.getElementById('affilate_bottom');
                  affilate_bottom.classList.remove('d-none');
                  affilate_bottom.classList.add('d-block');

                  let affiliateCustomData = document.getElementById('affiliateCustomData');
                  affiliateCustomData.value = customData;

              } //END IF  

          } //END IF  

      } //END if  

  } //END placeUserPricing

  function placeAffiliateData(json) {

      //alert(json);

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let affiliate = dataApi.data.affiliate;

          let affiliateTypology = affiliate.affiliateProfession;

          let birthYear = affiliate.affiliateBirthDay.split('/')[2];
          let currentYear = new Date();
          currentYear = currentYear.getFullYear();
          let profileUserAge = parseInt(currentYear - birthYear);
          profileUserAge > 0 ? profileUserAge : profileUserAge = "";

          document.getElementById("townHint").innerHTML = "";

          document.getElementById("affiliateTypology").innerHTML = affiliateTypology;
          document.getElementById("inputAffiliateEmail").innerHTML = affiliate.affiliateActivationEmail;
          document.getElementById("profileUserName").innerHTML = affiliate.affiliateCompany;

          document.getElementById("inputName").value = affiliate.affiliateFirstName;
          document.getElementById("inputSurname").value = affiliate.affiliateLastName;
          document.getElementById("inputGender").value = affiliate.affiliateGender;
          document.getElementById("inputBirthDay").value = affiliate.affiliateBirthDay;
          document.getElementById("inputBirthPlace").value = affiliate.affiliateBirthPlace;
          document.getElementById("inputPersonalPhone").value = affiliate.affiliatePhoneNumber;
          document.getElementById("inputAffiliateCompany").value = affiliate.affiliateCompany;
          document.getElementById("inputAffiliateProfession").value = affiliate.affiliateProfession;
          document.getElementById("inputAffiliateCodiceFiscale").value = affiliate.affiliateCodiceFiscale;
          document.getElementById("inputAffiliateZipCode").innerHTML = affiliate.affiliateZipCode;

          document.getElementById("sideInfoTypology").innerHTML = affiliateTypology;
          document.getElementById("sideInfoLocation").innerHTML = affiliate.affiliateAddress + " <br> " + affiliate.affiliateZipCode + " <br> " + (affiliate.affiliateTown).toUpperCase();
          document.getElementById("sideInfoExpiration").innerHTML = affiliate.accountExpiration;

          document.getElementById("inputTown").value = affiliate.affiliateTown;
          document.getElementById("inputAffiliateAddress").value = affiliate.affiliateAddress;
          document.getElementById("inputAffiliateDescription").value = affiliate.affiliateDescription;

          document.getElementById("profileUserAge").innerHTML = profileUserAge;

          if (affiliate.accountStatus != 'active') {
              document.getElementById('updatePaypent').innerHTML = "<a href='pricing.php' target='_blanck' class='btn btn-warning btn-block'><i class='fa fa-shopping-cart'></i><b> Abbonati subito</b></a>";
          } else {
              document.getElementById('updatePaypent').innerHTML = "";
          };

          let affiliateLogo = document.getElementById("userPicture");
          let base64Photo = document.getElementById("base64Photo");
          base64Photo.src = null;

          if (affiliate.affiliatePhotoLink !== null && affiliate.affiliatePhotoLink !== undefined) {

              let base64Mysql = affiliate.affiliatePhotoLink;
              let base64 = base64Mysql.replace(/\-/g, '+');
              affiliateLogo.src = base64;
              base64Photo.src = base64Mysql;
          }; //END if

          if (affiliate.affiliatePhotoLink === "" || affiliate.affiliatePhotoLink === null || affiliate.affiliatePhotoLink.length < 50 || base64Photo.src === null || base64Photo.src === undefined) {

              affiliateLogo.src = "dist/img/logoDefault.jpg"

          }; //END if

          if (affiliate.timeLine.length > 0) {
              this.timeLine(affiliate.timeLine);
          } //END if

      } //END if  

  } //END placeAffiliateData

  function refreshTimeLine() {

      let request = {
              typology: "loadUserProfile"
          } //END data

      let myCallback = {
              function: (json) => {

                      //alert(json);

                      let notify = new Alert;
                      let dataApi = JSON.parse(json);
                      if (dataApi.response === true) {

                          let timeline = dataApi.data.user.timeLine;
                          this.timeLine(timeline);

                      } else {
                          window.location.href = "login.html";
                      } //END if
                  } //END function
          } //END myCallback

      let ajax = new Ajax;
      ajax.url("php/data.php");
      ajax.jsonRequest(request);
      ajax.callBack(myCallback);
      ajax.execute();



  } //END refreshTimeLine

  function timeLine(jsonData) {

      let timeData = JSON.parse(jsonData);
      let timeLineContainer = document.getElementById('timeLineContainer');
      let timeContent = "";
      let dayHeader = "";
      let dayContent = "";
      let dayTypology = "";

      if (timeData.events) {

          for (let key in timeData) {

              let events = timeData[key];

              for (let event in events) {

                  let days = events[event];

                  dayContent = "";

                  for (let day of days) {

                      dayTypology = "<i class='far fa-clock bg-gray'></i>";

                      if (day['eventType'] == "inizio") {
                          dayTypology = "<i class='fas fa fa-user bg-warning'></i>";
                      }; //END if

                      if (day['eventType'] == "avviso") {
                          dayTypology = "<i class='fas fa-envelope bg-info'></i>";
                      }; //END if

                      if (day['eventType'] == "checkup") {
                          dayTypology = "<i class='fas fa-heart bg-danger'></i>";
                      }; //END if

                      if (day['eventType'] == "dieta") {
                          dayTypology = "<i class='fa fa-book bg-success'></i>";
                      }; //END if

                      dayHeader = "<div class='time-label'>" +
                          "<span class='bg-primary'>" +
                          day['eventDate'] +
                          "</span>" +
                          "</div>";

                      dayContent += "<div>" +
                          dayTypology +
                          "<div class='timeline-item'>" +
                          "<span class='time'><i class='far fa-clock'></i> " + day['eventHour'] + "</span>" +
                          "<h3 class='timeline-header'>" + day['eventType'] + "</h3>" +
                          "<div class='timeline-body'>" +
                          "<p style='width:90%;'>" + day['eventMessage'] + "</p>" +
                          "</div>" +
                          "</div>" +
                          "</div>";

                  }; //END for 

                  timeContent += dayHeader + dayContent;

              }; //END for 

          }; //END for

          let firstIcon = "<div><i class='far fa-clock bg-gray'></i><div class='timeline-item'></div></div>";

          timeContent += firstIcon;

          timeLineContainer.innerHTML = timeContent;

      };

  } //END timeLine

  function placeUserCheckup(json) {

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let user = dataApi.data.user;

          let userPicture = document.getElementById("userPicture");
          let useDefaultPic = true;

          if (user.profilePhotoLink !== null && user.profilePhotoLink !== undefined) {

              let base64Mysql = user.profilePhotoLink;
              let base64 = base64Mysql.replace(/\-/g, '+');
              userPicture.src = base64;
              base64Photo.src = base64Mysql;
          }; //END if

          if (user.profilePhotoLink === "" || user.profilePhotoLink === null || user.profilePhotoLink.length < 50 || base64Photo.src === null || base64Photo.src === undefined) {

              if (user.personalGender === "male") {
                  userPicture.src = "dist/img/userMan.jpg"
              } else {
                  userPicture.src = "dist/img/userWoman.jpg"
              };

          }; //END if

          let userName = user.personalFirstName + " " + user.personalLastName;
          let chatContainer = document.getElementById("chatContainer");
          chatContainer.innerHTML = "";
          let chatHint = document.getElementById("chatHint");
          chatHint.innerHTML = "";
          let birthYear = user.personalBirthDay.split('/')[2];
          let currentYear = new Date();
          currentYear = currentYear.getFullYear();
          let profileUserAge = parseInt(currentYear - birthYear);
          profileUserAge > 0 ? profileUserAge : profileUserAge = "";

          let profileBloodGroup = user.additionalBloodGroup;
          profileBloodGroup = profileBloodGroup.replace(/p/g, '+');
          profileBloodGroup = profileBloodGroup.replace(/n/g, '-');

          document.getElementById("profileUserName").innerHTML = userName;
          document.getElementById("profileBloodGroup").innerHTML = profileBloodGroup;
          document.getElementById("profileUserAge").innerHTML = profileUserAge;
          document.getElementById("profileUserProfession").innerHTML = user.personalProfession;

          let intro = {
                  response: true,
                  message: "Ciao " + user.personalFirstName + ", puoi usare questa chat per comunicare con me, Sono il tuo medico virtuale, ti accompagnerò in tutti i checkup presenti in questa applicazione.</br></br>  I servizi principali sono:</br> - il <b>Check-up prevenzione</b> per conoscere il tuo stato di salute attuale, Per accedere scrivi <b>check</b>;</br> - il <b>Check-up dieta</b> un programma dietologico personalizzato. Per accedere scrivi <b>dieta</b>.</br></br> Per iniziare scrivi <b>info</b> ed accederai al menu dei servizi.</br>Scrivimi presto."
              } //END request

          if (user.timeLine.length > 0) {
              this.timeLine(user.timeLine);
          } //END if

          intro = JSON.stringify(intro);

          this.appendResponse(intro);

      } //END if  



  } //END placeUserCheckup

  function placeUserCard(json) {

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let user = dataApi.data.user;

          let userPicture = document.getElementById("cardUserPhoto");
          let useDefaultPic = true;

          let linkScheda = document.getElementById("linkScheda");

          linkScheda.href = "profilo_sanitario.html?id=" + user.id;

          if (user.privacySetting != null && user.privacySetting != "") {

              let privacy = JSON.parse(user.privacySetting);

              let privacyName = document.getElementById('privacyName');
              let privacyPhoto = document.getElementById('privacyPhoto');
              let privacyCard = document.getElementById('privacyCard');
              let privacyAddress = document.getElementById('privacyAddress');
              let privacyEmail = document.getElementById('privacyEmail');
              let privacyPhone = document.getElementById('privacyPhone');

              this.buttonPrivacy(privacyName, privacy.privacyName);
              this.buttonPrivacy(privacyPhoto, privacy.privacyPhoto);
              this.buttonPrivacy(privacyCard, privacy.privacyCard);
              this.buttonPrivacy(privacyAddress, privacy.privacyAddress);
              this.buttonPrivacy(privacyEmail, privacy.privacyEmail);
              this.buttonPrivacy(privacyPhone, privacy.privacyPhone);

          } else {
              this.buttonPrivacy(privacyName, 'true');
              this.buttonPrivacy(privacyPhoto, 'true');
              this.buttonPrivacy(privacyCard, 'true');
              this.buttonPrivacy(privacyAddress, 'true');
              this.buttonPrivacy(privacyEmail, 'true');
              this.buttonPrivacy(privacyPhone, 'true');
          } //END if

          if (user.profilePhotoLink !== null && user.profilePhotoLink !== undefined) {

              let base64Mysql = user.profilePhotoLink;
              let base64 = base64Mysql.replace(/\-/g, '+');
              useDefaultPic = false;
              userPicture.src = base64;

          }; //END if

          if (useDefaultPic === true || user.profilePhotoLink === null || user.profilePhotoLink === "" || user.profilePhotoLink.length < 50) {
              if (user.personalGender == 'female') {
                  userPicture.src = "dist/img/userWoman.jpg";
              } else {
                  userPicture.src = "dist/img/userMan.jpg";
              } //END if  
          } //END if

          let userName = user.personalFirstName + " " + user.personalLastName;
          let birthYear = user.personalBirthDay.split('/')[2];
          let currentYear = new Date();
          currentYear = currentYear.getFullYear();
          let profileUserAge = parseInt(currentYear - birthYear);
          profileUserAge > 0 ? profileUserAge : profileUserAge = "";

          let profileBloodGroup = user.additionalBloodGroup;
          profileBloodGroup = profileBloodGroup.replace(/p/g, '+');
          profileBloodGroup = profileBloodGroup.replace(/n/g, '-');

          profileBloodGroup.length <= 0 ? profileBloodGroup = "##" : null;
          userName.length <= 2 ? userName = "##########" : null;
          user.personalProfession.length <= 0 ? user.personalProfession = "########" : null;
          user.personalAddress.length <= 0 ? user.personalAddress = "########" : null;
          user.profilePhoneNumber.length <= 0 ? user.profilePhoneNumber = "######" : null;
          user.personalCodiceFiscale.length <= 0 ? user.personalCodiceFiscale = "############" : null;
          user.personalBirthDay.length <= 0 ? user.personalBirthDay = "######" : null;
          user.styleWeight.length <= 0 ? user.styleWeight = "###" : null;
          user.styleHeight.length <= 0 ? user.styleHeight = "###" : null;
          user.personalGender.length <= 0 ? user.personalGender = "#####" : null;
          user.styleSmoke.length <= 0 ? user.styleSmoke = "#####" : null;
          user.styleDrink.length <= 0 ? user.styleDrink = "#####" : null;

          document.getElementById("cardBlood").innerHTML = "Gruppo sanguigno " + profileBloodGroup;
          document.getElementById("cardUserName").innerHTML = userName;
          document.getElementById("labelUserName").innerHTML = userName;
          document.getElementById("cardUserProfession").innerHTML = "<b>Professione: </b> " + user.personalProfession;
          document.getElementById("cardUserAddress").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-building'></i></span> " + user.personalAddress;
          document.getElementById("cardUserEmail").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-envelope'></i></span> " + user.profileActivationEmail;
          document.getElementById("cardUserPhone").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-phone'></i></span> " + user.profilePhoneNumber;
          document.getElementById("cardUserCod").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-address-card'></i></span> " + user.personalCodiceFiscale;

          if (user.personalGender == 'male') {
              document.getElementById("cardUserGender").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-mars'></i></span> Maschio";
          } //END if  

          if (user.personalGender == 'female') {
              document.getElementById("cardUserGender").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-venus'></i></span> Femmina";
          } //END if  

          document.getElementById("cardUserBirthDay").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-birthday-cake'></i></span> " + user.personalBirthDay;
          document.getElementById("cardUserWeight").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa fa-info'></i></span> " + user.styleWeight + " Kg";
          document.getElementById("cardUserHeight").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa fa-info'></i></span> " + user.styleHeight + " cm";

          let userSmokeTranslated;

          switch (user.styleSmoke) {

              case 'noSmoke':
                  userSmokeTranslated = "Non fumo";
                  break;

              case 'rarelySmoke':
                  userSmokeTranslated = "Fumo raramente";
                  break;

              case 'constantlySmoke':
                  userSmokeTranslated = "Fumo costantemente";
                  break;

              default:
                  userSmokeTranslated = user.styleSmoke;

          } //END switch

          document.getElementById("cardUserSmoke").innerHTML = "<span class='fa-li'><i class='fas fa-smoking'></i></span> " + userSmokeTranslated;

          let userDrinkTranslated;

          switch (user.styleDrink) {

              case 'noDrink':
                  userDrinkTranslated = "Non bevo";
                  break;

              case 'rarelyDrink':
                  userDrinkTranslated = "Bevo raramente";
                  break;

              case 'constantlyDrink':
                  userDrinkTranslated = "Bevo costantemente";
                  break;

              default:
                  userDrinkTranslated = user.styleDrink;

          } //END switch

          document.getElementById("cardUserDrink").innerHTML = "<span class='fa-li'><i class='fas fa-cocktail'></i></span> " + userDrinkTranslated;

          if (user.additionalCheckedList) {
              let dataAnamnsesi = user.additionalCheckedList.split(',');
              this.fillAnamnesi(dataAnamnsesi);
          } //END if

      } //END if  

  } //END placeUserCard

  function fillAnamnesi(data) {

      if (data.length > 0) {

          let anamnesiContainer = document.getElementById('anamnesiContainer');

          let content = "";

          for (let label of LabelData.labels) {

              for (let element of data) {

                  let containString = label.includes(element);

                  if (containString) {

                      content += label + "<br>";

                  } //END if

              } //END for

          } //END for

          anamnesiContainer.innerHTML = content;


      } //END if


  } //END fillanamnesi

  function collectUserTableData() {

      let userTable = document.getElementById("userTable");

      if (userTable) {

          let request = {
                  typology: "userDataList"
              } //END data

          let myCallback = {
                  function: (json) => { this.buildUserTable(json) }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callBack(myCallback)
          ajax.execute();

      } //END if

  } //END collectUserTableData

  function foundStatusClass(status) {

      if (status) {

          switch (status) {
              case "pending":
                  return "warning";
                  break;
              case "active":
                  return "success";
                  break;
              case "expired":
                  return "danger";
                  break;
              default:
                  // code block
          }

      } //END if


  } //END foundStatusClass

  class UserTable {

      constructor(rawData, callNewPage, idBody, idContainer, idPagination, currentData, split, prev, next, currentPage, table, tableHead, tableBody, paginationBody, useLimit, content) {
              this.rawData = [];
              this.currentData = [];
              this.split = 5;
              this.prev;
              this.next;
              this.currentPage = 1;
              this.table;
              this.tableHead;
              this.tableBody;
              this.paginationBody;
              this.content;
              this.useLimit = false;
              this.callNewPage;
              this.idContainer;
              this.idBody;
              this.idPagination;
          } //END constructor

      tableId(id) {
          this.table = document.getElementById(id);
          let head = this.table.getElementsByTagName("thead");
          this.tableHead = head[0];

          let body = this.table.getElementsByTagName("tbody");
          this.tableBody = body[0];
          let rawData = this.tableBody.getElementsByTagName("tr");
          this.rawData = [];

          for (let tr of rawData) {
              this.rawData.push("<tr>" + tr.innerHTML + "</tr>");
          } //END for

          this.idContainer = id + "Container";
          this.idBody = id + "Body";
          this.idPagination = id + "Control";

          let container = document.createElement('div');
          container.setAttribute('id', this.idContainer);
          container.classList.add('card-body');

          let tableContainer = "<div class='table-responsive'>" +
              "<table class='table m-0'>" +
              "<thead>" +
              this.tableHead.innerHTML +
              "</thead>" +
              "<tbody id='" + this.idBody + "'>" +
              this.tableBody.innerHTML +
              "</tbody>" +
              "</table>" +
              "<div id='" + this.idPagination + "' class='row mt-2'></div>" +
              "</div>";

          container.innerHTML = tableContainer;

          this.table.parentNode.insertBefore(container, this.table);

          this.table.remove();

          this.paginationBody = document.getElementById(this.idPagination);
          this.tableBody = document.getElementById(this.idBody);

      }; //body

      limitResult(value) {

          if (value) {
              this.useLimit = true;
              this.split = parseInt(value);
          } //END if

      }; //END limitResult

      render() {

          this.paginationBody.setAttribute('currentPage', this.currentPage);

          this.buildTable();

      };

      buildTable() {

          let totElements = this.rawData.length;
          let pages = parseInt(totElements / this.split);

          if (parseInt(pages * this.split) < totElements) {
              pages++;
          }; //END if

          this.paginationBody.innerHTML = "";

          let showTo = parseInt((this.currentPage * this.split) + 1 - this.split);
          showTo >= totElements ? showTo = totElements : null;
          let showUntil = parseInt((showTo + this.split) - 1);
          showUntil >= totElements ? showUntil = totElements : null;

          let limitPage;

          if (pages <= 5) {
              limitPage = pages;
          } else {
              limitPage = 5;
          }; //END if

          let stepPage;

          if (this.currentPage <= 5 && this.currentPage <= pages) {
              stepPage = 1;
              limitPage = 5;
          } else {
              stepPage = this.currentPage;
              limitPage = parseInt(stepPage + 5);
          }; //END if

          limitPage >= pages ? limitPage = pages : null;

          let startData = parseInt((this.currentPage * this.split) - this.split);
          let endData = parseInt(startData + this.split);
          endData >= totElements ? endData = totElements : null;

          this.content = "";

          for (let i = startData; i < endData; i++) {
              this.content += this.rawData[i];
          } //END for

          this.tableBody.innerHTML = this.content;

          let idTableBody = document.getElementById(this.idBody).getAttribute('id');

          let control = "";

          control += "<div id='userPagination' class='row col-sm-12'>" +
              "<div class='col-sm-6'>" +
              "<div class='dataTables_info' >Showing " + showTo + " to " + showUntil + " of " + totElements + " entries</div>" +
              "</div>" +
              "<div class='col-sm-6'>" +
              "<div style='float:right;' class='dataTables_paginate paging_simple_numbers'>" +
              "<ul class='pagination'>" +
              "<li class='paginate_button page-item previous' id='tablePagePrev'><a aria-controls='example1' data-dt-idx='0' tabindex='0' class='page-link'>Previous</a></li>";

          for (let id = stepPage; id <= limitPage; id++) {
              let active = "";
              if (this.currentPage == id) {
                  active = "active";
              }; //END if
              control += "<li class='paginate_button page-item tablePageLink " + active + "' dataPage='" + id + "'><a href='#" + idTableBody + "' dataPage='" + id + "' class='page-link'>" + id + "</a></li>";
          }; //END for 

          control += "<li class='paginate_button page-item next' id='tablePageNext'><a aria-controls='example1' data-dt-idx='7' tabindex='0' class='page-link'>Next</li>" +
              "</ul></div></div></div>";

          this.paginationBody.innerHTML = control;

          let pageLinks = document.getElementsByClassName("tablePageLink");

          for (let link of pageLinks) {
              link.addEventListener('click', () => {
                  let page = link.getAttribute('dataPage');
                  this.currentPage = page;
                  this.render();
              });
          } //END if

          let pagePrev = document.getElementById("tablePagePrev");

          pagePrev.addEventListener('click', () => {
              if (this.currentPage >= 2) {
                  this.currentPage--;
                  this.render();
              } else {
                  this.currentPage = 1;
                  this.render();
              }
          });

          let pageNext = document.getElementById("tablePageNext");

          pageNext.addEventListener('click', () => {
              if (this.currentPage < pages) {
                  this.currentPage++;
                  this.render();
              } else {
                  this.currentPage = pages;
                  this.render();
              }
          });



      }; //END 


  } //END UserTable

  function buildUserTable(JSONData) {

      let dataApi = JSON.parse(JSONData);

      if (dataApi.response === true) {

          let users = dataApi.data.users;

          let userTableBody = document.getElementById("userTableBody");

          let tableBody = "";

          for (let user of users) {

              let status = user.accountStatus;
              let statusClass = this.foundStatusClass(status);

              let userPicture;
              let imgPicture;

              if (user.profilePhotoLink !== null && user.profilePhotoLink !== undefined) {

                  userPicture = user.profilePhotoLink.replace(/\-/g, '+');
                  imgPicture = "<img class='direct-chat-img' src='" + userPicture + "'>";

              } else {
                  imgPicture = "";
              }; //END if

              let row = "<tr> \n" +
                  "<td><a>" + user.id + "</a></td> \n" +
                  "<td>" + imgPicture + "</td> \n" +
                  "<td>" + user.personalLastName + " " + user.personalFirstName + "</td> \n" +
                  "<td><span class='badge badge-" + statusClass + "'>" + user.accountStatus + "</span> \n" +
                  "<td>" + user.personalCodiceFiscale + "</td> \n" +
                  "<td>" + user.profileActivationEmail + "</td> \n" +
                  "</tr> \n";




              tableBody += row;

          } //END for

          userTableBody.innerHTML = tableBody;

          let table = new UserTable;
          table.tableId("userTable");
          table.limitResult(10);
          table.render();

          let spinnerUserTable = document.getElementById("spinnerUserTable");
          spinnerUserTable.style.display = "none";

      } //END IF









      // personalCodiceFiscale VARCHAR(30) NOT NULL,
      // personalGender VARCHAR(10) NOT NULL,
      // personalBirthDay VARCHAR(10) NOT NULL,
      // personalBirthPlace VARCHAR(30) NOT NULL,
      // personalAddress VARCHAR(100) NOT NULL,
      // styleWeight VARCHAR(5) NOT NULL,
      // styleHeight VARCHAR(5) NOT NULL,
      // styleSmoke VARCHAR(5) NOT NULL,
      // styleDrink VARCHAR(5) NOT NULL,
      // styleDrugs VARCHAR(100) NOT NULL,
      // styleEducation VARCHAR(30) NOT NULL,
      // styleMaritalStatus VARCHAR(30) NOT NULL,
      // additionalAsl VARCHAR(30) NOT NULL,
      // additionalDoctorName VARCHAR(100) NOT NULL,
      // additionalDoctorPhone VARCHAR(30) NOT NULL,
      // additionalCheckedList VARCHAR(300) NOT NULL,
      // additionalBloodGroup VARCHAR(5) NOT NULL,
      // additionalFavismo VARCHAR(5) NOT NULL,
      // additionalilnesses VARCHAR(100) NOT NULL,
      // allergyDrugs VARCHAR(30) NOT NULL,
      // allergyFoods VARCHAR(30) NOT NULL,
      // allergyRespiratory VARCHAR(30) NOT NULL,
      // allergyOthers VARCHAR(30) NOT NULL,
      // vaccinationsTypes VARCHAR(100) NOT NULL,
      // missingOrgans VARCHAR(100) NOT NULL,
      // profilePhotoLink VARCHAR(200) NOT NULL,
      // profileCertificateLink VARCHAR(200) NOT NULL,
      // profileDocumentLink VARCHAR(200) NOT NULL,
      // profileCreationData VARCHAR(100) NOT NULL,
      // profileActivationEmail VARCHAR(100) NOT NULL,
      // profileRecoveryEmail VARCHAR(100) NOT NULL,
      // profilePhoneNumber VARCHAR(10) NOT NULL,
      // accountStatus VARCHAR(10) NOT NULL,
      // accountType VARCHAR(10) NOT NULL,
      // accountPayment VARCHAR(10) NOT NULL,
      // accountPassword VARCHAR(30) NOT NULL,
      // accountPrice VARCHAR(10) NOT NULL,
      // accountPromotions VARCHAR(30) NOT NULL,
      // accountExiration VARCHAR(30) NOT NULL,
      // accountNotifications VARCHAR(100) NOT NULL

  } //END buildUserTable

  function collectDataSubmit(personalData) {

      // Converting JSON data to string 
      data = JSON.stringify(personalData);

      if (data) {

          let myCallFirst = {
                  function: () => {
                      let notify = new Alert;
                      notify.freeze();
                  }
              } //END myCallFirst

          let myCallback = {
                  function: (json) => {
                      let dataApi = JSON.parse(json);
                      let notify = new Alert;

                      if (dataApi.response === true) {
                          //notify.success(dataApi.message);
                          this.loadUserProfile();
                      } else {
                          notify.danger(dataApi.message);
                      } //END if

                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(personalData);
          ajax.callFirst(myCallFirst);
          ajax.callBack(myCallback);
          ajax.execute();

      } //END data

  } //END function

  function collectAffiliateSubmit(affiliateData) {

      // Converting JSON data to string 
      data = JSON.stringify(affiliateData);

      if (data) {

          let myCallFirst = {
                  function: () => {
                      let notify = new Alert;
                      notify.freeze();
                  }
              } //END myCallFirst

          let myCallback = {
                  function: (json) => {
                      //alert(json);
                      let dataApi = JSON.parse(json);
                      let notify = new Alert;

                      if (dataApi.response === true) {
                          //notify.success(dataApi.message);
                          this.loadAffiliateProfile();
                      } else {
                          notify.danger(dataApi.message);
                      } //END if

                  }
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(affiliateData);
          ajax.callFirst(myCallFirst);
          ajax.callBack(myCallback);
          ajax.execute();

      } //END data

  } //END function

  function collectProfileInfo() {

      let checkBoxList = [];
      let elements = document.getElementsByClassName("checkInfo");

      for (let element of elements) {

          if (element.checked === true) {
              checkBoxList.push(element.id);
          } //END if

      } //END for

      let base64Photo = document.getElementById("base64Photo").src;

      let imageBase64 = null;

      if (base64Photo !== null && base64Photo.length > 50) {
          imageBase64 = base64Photo;
      } //END if

      let data = {
              typology: "userData",
              inputEmail: document.getElementById("inputEmail").innerHTML,
              inputFiscalCode: document.getElementById("inputFiscalCode").value,
              inputName: document.getElementById("inputName").value,
              inputSurname: document.getElementById("inputSurname").value,
              inputGender: document.getElementById("inputGender").value,
              inputBirthDay: document.getElementById("inputBirthDay").value,
              inputBirthPlace: document.getElementById("inputBirthPlace").value,
              inputAddress: document.getElementById("inputAddress").value,
              inputProfession: document.getElementById("inputProfession").value,
              inputPersonalTown: document.getElementById("inputTown").value,
              inputPersonalPhone: document.getElementById("inputPersonalPhone").value,
              inputWeight: document.getElementById("inputWeight").value,
              inputHeight: document.getElementById("inputHeight").value,
              inputSmoke: document.getElementById("inputSmoke").value,
              inputDrink: document.getElementById("inputDrink").value,
              checkboxAddictions: document.getElementById("checkboxAddictions").value,
              inputAddictionsDescriptions: document.getElementById("inputAddictionsDescriptions").value,
              inputEducation: document.getElementById("inputEducation").value,
              inputMaritalStatus: document.getElementById("inputMaritalStatus").value,
              inputBloodGroup: document.getElementById("inputBloodGroup").value,
              inputMemebershipAsl: document.getElementById("inputMemebershipAsl").value,
              inputDoctorName: document.getElementById("inputDoctorName").value,
              inputDoctorPhone: document.getElementById("inputDoctorPhone").value,
              inputUploadPhoto: imageBase64,
              checkedList: checkBoxList.toString()
          } //END data

      return data;

  } //END function

  function collectAffiliateInfo() {

      let base64Photo = document.getElementById("base64Photo").src;

      let imageBase64 = null;

      if (base64Photo !== null && base64Photo.length > 50) {
          imageBase64 = base64Photo;
      } //END if

      let data = {
              typology: "affiliateData",
              affiliateActivationEmail: document.getElementById("inputAffiliateEmail").innerHTML,
              affiliateFirstName: document.getElementById("inputName").value,
              affiliateLastName: document.getElementById("inputSurname").value,
              affiliateGender: document.getElementById("inputGender").value,
              affiliateBirthDay: document.getElementById("inputBirthDay").value,
              affiliateTown: document.getElementById("inputTown").value,
              affiliateBirthPlace: document.getElementById("inputBirthPlace").value,
              affiliatePhoneNumber: document.getElementById("inputPersonalPhone").value,
              affiliateCompany: document.getElementById("inputAffiliateCompany").value,
              affiliateProfession: document.getElementById("inputAffiliateProfession").value,
              affiliateCodiceFiscale: document.getElementById("inputAffiliateCodiceFiscale").value,
              affiliateAddress: document.getElementById("inputAffiliateAddress").value,
              affiliateDescription: document.getElementById("inputAffiliateDescription").value,
              affiliatePhotoLink: imageBase64
          } //END data

      return data;

  } //END collectAffiliateInfo

  function loadScripts() {

      this.animationCheckboxes();
      this.listeners();
      this.loadUserProfile();

  } //END loadScripts

  function loadScriptDiet() {

      this.dietListeners();
      this.loadDiet();

  } //END loadScriptDiet

  function loadAffiliateScripts() {

      //this.animationCheckboxes();
      this.affiliateListeners();
      this.loadAffiliateProfile();

  } //END loadAffiliateScripts

  function loadScriptCard() {

      this.loadUserCard();
      this.listenersCard();

  } //END loadScripts

  function loadScriptCheckup() {

      this.loadUserCheckup();
      this.listenersCheckup();

  } //END loadScriptCheckup

  function dashboardSripts() {

      this.collectUserTableData();

  } //END dashboardSripts

  function indexScripts() {

      this.indexListeners();
      this.searchCheck();

  } //END indexScripts

  function placeIdProfile(json) {

      let dataApi = JSON.parse(json);

      if (dataApi.response === true) {

          let user = dataApi.data.user;

          let userPicture = document.getElementById("cardUserPhoto");
          let useDefaultPic = true;

          if (user.profilePhotoLink !== null && user.profilePhotoLink !== undefined) {

              let base64Mysql = user.profilePhotoLink;
              let base64 = base64Mysql.replace(/\-/g, '+');
              useDefaultPic = false;
              userPicture.src = base64;

          }; //END if

          if (useDefaultPic === true || user.profilePhotoLink === null || user.profilePhotoLink === "" || user.profilePhotoLink.length < 50) {
              if (user.personalGender == 'female') {
                  userPicture.src = "dist/img/userWoman.jpg";
              } else {
                  userPicture.src = "dist/img/userMan.jpg";
              } //END if  
          } //END if

          let userName = user.personalFirstName + " " + user.personalLastName;
          let birthYear = user.personalBirthDay.split('/')[2];
          let currentYear = new Date();
          currentYear = currentYear.getFullYear();
          let profileUserAge = parseInt(currentYear - birthYear);
          profileUserAge > 0 ? profileUserAge : profileUserAge = "";

          let profileBloodGroup = user.additionalBloodGroup;
          profileBloodGroup = profileBloodGroup.replace(/p/g, '+');
          profileBloodGroup = profileBloodGroup.replace(/n/g, '-');

          profileBloodGroup.length <= 0 ? profileBloodGroup = "##" : null;
          userName.length <= 2 ? userName = "##########" : null;
          user.personalProfession.length <= 0 ? user.personalProfession = "########" : null;
          user.personalAddress.length <= 0 ? user.personalAddress = "########" : null;
          user.profilePhoneNumber.length <= 0 ? user.profilePhoneNumber = "######" : null;
          user.personalCodiceFiscale.length <= 0 ? user.personalCodiceFiscale = "############" : null;
          user.personalBirthDay.length <= 0 ? user.personalBirthDay = "######" : null;
          user.styleWeight.length <= 0 ? user.styleWeight = "###" : null;
          user.styleHeight.length <= 0 ? user.styleHeight = "###" : null;
          user.personalGender.length <= 0 ? user.personalGender = "#####" : null;
          user.styleSmoke.length <= 0 ? user.styleSmoke = "#####" : null;
          user.styleDrink.length <= 0 ? user.styleDrink = "#####" : null;

          document.getElementById("cardBlood").innerHTML = "Gruppo sanguigno " + profileBloodGroup;
          document.getElementById("cardUserName").innerHTML = userName;
          document.getElementById("cardUserProfession").innerHTML = "<b>Professione: </b> " + user.personalProfession;
          document.getElementById("cardUserAddress").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-building'></i></span> " + user.personalAddress;
          document.getElementById("cardUserEmail").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-envelope'></i></span> " + user.profileActivationEmail;
          document.getElementById("cardUserPhone").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-phone'></i></span> " + user.profilePhoneNumber;
          document.getElementById("cardUserCod").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-address-card'></i></span> " + user.personalCodiceFiscale;

          if (user.personalGender == 'male') {
              document.getElementById("cardUserGender").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-mars'></i></span> Maschio";
          } //END if  

          if (user.personalGender == 'female') {
              document.getElementById("cardUserGender").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-venus'></i></span> Femmina";
          } //END if  

          document.getElementById("cardUserBirthDay").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa-birthday-cake'></i></span> " + user.personalBirthDay;
          document.getElementById("cardUserWeight").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa fa-info'></i></span> " + user.styleWeight + " Kg";
          document.getElementById("cardUserHeight").innerHTML = "<span class='fa-li'><i class='fas fa-lg fa fa-info'></i></span> " + user.styleHeight + " cm";

          let userSmokeTranslated;

          switch (user.styleSmoke) {

              case 'noSmoke':
                  userSmokeTranslated = "Non fumo";
                  break;

              case 'rarelySmoke':
                  userSmokeTranslated = "Fumo raramente";
                  break;

              case 'constantlySmoke':
                  userSmokeTranslated = "Fumo costantemente";
                  break;

              default:
                  userSmokeTranslated = user.styleSmoke;

          } //END switch

          document.getElementById("cardUserSmoke").innerHTML = "<span class='fa-li'><i class='fas fa-smoking'></i></span> " + userSmokeTranslated;

          let userDrinkTranslated;

          switch (user.styleDrink) {

              case 'noDrink':
                  userDrinkTranslated = "Non bevo";
                  break;

              case 'rarelyDrink':
                  userDrinkTranslated = "Bevo raramente";
                  break;

              case 'constantlyDrink':
                  userDrinkTranslated = "Bevo costantemente";
                  break;

              default:
                  userDrinkTranslated = user.styleDrink;

          } //END switch

          document.getElementById("cardUserDrink").innerHTML = "<span class='fa-li'><i class='fas fa-cocktail'></i></span> " + userDrinkTranslated;

          if (user.additionalCheckedList) {
              let dataAnamnsesi = user.additionalCheckedList.split(',');
              this.fillAnamnesi(dataAnamnsesi);
          } //END if

      } //END if  

  } //END placeIdProfile

  function loadIdProfile() {

      //alert(json);

      let currentPath = window.location.href;

      let url = new URL(currentPath);
      let id = url.searchParams.get("id");

      if (id !== null) {

          let request = {
                  typology: "searchId",
                  userId: id
              } //END request

          let myCallFirst = {
                  function: () => {
                      let notify = new Alert;
                      notify.freeze();
                  }
              } //END myCallFirst

          let myCallback = {
                  function: (json) => {
                          //alert(json);
                          let notify = new Alert;
                          let dataApi = JSON.parse(json);
                          if (dataApi.response == true || dataApi.response == false) {
                              this.placeIdProfile(json);
                              notify.defreeze();
                          }; //END if

                      } //END function
              } //END myCallback

          let ajax = new Ajax;
          ajax.url("php/data.php");
          ajax.jsonRequest(request);
          ajax.callFirst(myCallFirst)
          ajax.callBack(myCallback)
          ajax.execute();

      }; //END if

  } //END loadIdProfile

  function loadSearchScripts() {

      this.indexListeners();
      this.loadIdProfile();

  } //END loadSearchScripts

  function loginScripts() {

      this.loginListeners();

  } //END loginScripts

  function loadPricing() {

      this.pricingListeners();
      this.loadUserPricing();

  } //END loginScripts

  function loginAffiliateScripts() {

      this.loginAffiliateListeners();

  } //END loginScripts

  function registerScripts() {

      this.registerListeners();

  } //END loginScripts

  function registerAffiliationScripts() {

      this.registerAffiliationListeners();

  } //END registerAffiliationScripts

  function tost(type = 'info', message = '') {

      let Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
      });

      Toast.fire({
          type: type,
          title: message
      });

  } //END tost