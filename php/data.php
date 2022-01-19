<?php

    session_start();

    include "config.php";
    include "directChat.php";
    include "post.php";
    include "controller.php";

    class UserData{

        public $postedData;
        public $typoly;
        public $data;
        public $messageEvent;            

        function postFormat($data){

            foreach($data as $key=>$value) {
                $data[$key]=str_replace("+","çùç",$value);
            };

            return $data;

        }//END postFormat

        function getFormat($data){

            foreach($data as $value) {
                $value=str_replace("çùç","+",$value);
            };

            return $data;

        }//END postFormat

        function sanitaze($string){

            $value = $string;
            $value = str_replace("'", '"', $value); 
            $value = strip_tags($value);
            
            return $value;

        }//END sanitaze

        function checkPost(){

            $this->data=new ConnectData;
            $this->data->connect();

            $this->messageEvent = new TimeLine;

            if ($_SERVER["REQUEST_METHOD"] === "POST"){

                $this->postedData = $_POST['data'];

                $this->postedData = json_decode($this->postedData, false);

                $this->typology=$this->postedData->typology;
    
                switch ($this->typology) {
                    case "userData":
                        $this->dataHandle();
                        break;
                    case "affiliateData":
                        $this->affiliateDataHandle();
                        break;    
                    case "userDataList":
                        $this->loadUserDataList();
                        break;
                    case "userLogin":
                        $this->checkUserLogin();
                        break; 
                    case "affiliateLogin":
                        $this->checkAfiliateLogin();
                        break; 
                    case "loadUserProfile":
                        $this->loadUserProfile();
                        break;  
                    case "loadUserPricing":
                        $this->loadUserPricing();
                        break;  
                    case "loadAffiliateProfile":
                        $this->loadAffiliateProfile();
                        break;  
                    case "loadUserCard":
                        $this->loadUserCard();
                        break;      
                    case "registerUser":
                        $this->checkUserRegister();
                        break;   
                    case "registerAffiliate":
                        $this->checkAffiliateRegister();
                        break;   
                    case "updatePrivacy":
                        $this->updatePrivacy();
                        break;   
                    case "chatHint":
                        $this->chatHint();
                        break;   
                    case "townHint":
                        $this->townHint();
                        break;       
                    case "directChat":
                        $chat=new DirectCheckUp;
                        $chat->directChat($this->postedData->message);
                        break;   
                    case "publicPost":
                        $post=new Post;
                        $post->public($this->postedData);
                        break;    
                    case "publicComment":
                        $post=new Post;
                        $post->comment($this->postedData);
                        break; 
                    case "directMessage":
                        $post=new Post;
                        $post->sendMessage($this->postedData);
                        break;     
                    case "getPost":
                        $post=new Post;
                        $post->get($this->postedData);
                        break;   
                    case "notifyReadMessage":
                        $post=new Post;
                        $post->notifyRead($this->postedData);
                        break;  
                    case "getMessagesIndex":
                        $post=new Post;
                        $post->getMessagesIndex($this->postedData);
                        break;         
                    case "searchUser":
                        $this->searchEngine($this->postedData->searchString);
                        break;   
                    case "lastResult":
                        $this->getLastResult();
                        break;   
                    case "searchId":
                        $this->searchId($this->postedData->userId);
                        break;   

                    default:
                       // code to be executed if n is different from all labels;
                }//END switch
        
            };//END if

        }//END checkPost

        function searchEngine($searchString){

            $originalString = $searchString;

            $searchString = preg_replace('/\s+/', '', $searchString);

            $searchString = strtoupper($searchString);

            $sql = "SELECT * FROM users WHERE personalCodiceFiscale='$searchString'";

                $result=$this->data->sql($sql);

                $response=array();

                $response['string']=$originalString;

                //TRY TO SEARCH BY EMAIL IF DIDN'T FIND NOTHINK BY CODICE FISCALE
                if ($result->num_rows == 0) {

                    $searchByEmail=strtolower($originalString);
                    $searchByEmail = preg_replace('/\s+/', '', $searchByEmail);

                    $sql = "SELECT * FROM users WHERE profileActivationEmail LIKE '%$searchByEmail%'";
                    $result=$this->data->sql($sql);

                };//END if    

                if ($result->num_rows > 0) {

                    $response['response']=true;
                    $response['message']="User found!";

                    while($row = $result->fetch_assoc()) {

                        //ADDITIONALCHECKLIST
                        $additionalCheckedList=$row['additionalCheckedList'];

                        if(strlen($additionalCheckedList)==0){
                            $row['additionalCheckedList']=null;
                        };//END if

                       //PRIVACY SETTINGS
                       $row['accountPassword'] = str_repeat("*", strlen($row['accountPassword'])); 
                       $row['timeLine'] =""; 

                       $privacySetting=json_decode($row['privacySetting'], false);

                        if($privacySetting->privacyName=='false'){
                            $row['personalFirstName']=str_replace(".","",$row['personalFirstName']);
                            $row['personalLastName']=str_replace(".","",$row['personalLastName']);
                            $row['personalFirstName']=str_replace(" ","",$row['personalFirstName']);
                            $row['personalLastName']=str_replace(" ","",$row['personalLastName']);
                            $row['personalFirstName']=substr($row['personalFirstName'],0,1).".";
                            $row['personalLastName']=substr($row['personalLastName'],0,1).".";
                        };//END if

                       if($privacySetting->privacyPhoto=='false'){
                            $row['profilePhotoLink']=null;
                       };//END if

                       if($privacySetting->privacyCard=='false'){
                            $row['personalCodiceFiscale'] = str_repeat("*", strlen($row['personalCodiceFiscale'])); 
                       };//END if

                       if($privacySetting->privacyAddress=='false'){
                            $row['personalAddress'] = str_repeat("*", strlen($row['personalAddress'])); 
                       };//END if

                       if($privacySetting->privacyEmail=='false'){
                            $row['profileActivationEmail'] = str_repeat("*", strlen($row['profileActivationEmail'])); 
                       };//END if

                       if($privacySetting->privacyPhone=='false'){
                            $row['profilePhoneNumber'] = str_repeat("*", strlen($row['profilePhoneNumber'])); 
                       };//END if

                       $response['data']['result'][]=$row;

                    }//END while

    
                } else {
                       $response['response']=false;
                       $response['message']="user not found";
                }//END if

            $_SESSION["searchResult"] = $response;

            echo(json_encode($response));

        }//END searchEngine

        function getLastResult(){

            if($_SESSION["searchResult"]){

                $response = $_SESSION["searchResult"];

            }else{
                $response['response']=false;
                $response['message']="Nothing stored";
            };//END if

            echo(json_encode($response));

        }//END getLastResult

        function checkUserLogin(){

             //CHECK IF THERE ARE USER WITH THIS CREDENTIALS
             $userEmail=$this->postedData->userEmail;
             $userPassword=$this->postedData->userPassword;

             $sql = "SELECT id, accountType, accountStatus FROM users WHERE profileActivationEmail='$userEmail' AND accountPassword='$userPassword'";

             $result=$this->data->sql($sql);

             $response=array();

             if($result->num_rows > 0){
                $response['response']=true;
                $response['message']="User successfully logged in";

                while($row = $result->fetch_assoc()) {
                    $response['data']['user']=$row;
                }//END while

                 $_SESSION["id"] = $response['data']['user']['id'];
                 $_SESSION["type"] = $response['data']['user']['accountType'];
                 $_SESSION["active"] = true;
                 $_SESSION["status"] = $response['data']['user']['accountStatus'];
                 $_SESSION["checkup"] = [];

             }else{
                $response['response']=false;
                $response['message']="Unknown user";
             }//END if

             echo(json_encode($response));

        }//END checkUserLogin

        function checkAfiliateLogin(){

            //CHECK IF THERE ARE USER WITH THIS CREDENTIALS
            $affiliateEmail=$this->postedData->affiliateEmail;
            $affiliatePassword=$this->postedData->affiliatePassword;

            $sql = "SELECT id, accountType, accountStatus FROM affiliates WHERE affiliateActivationEmail='$affiliateEmail' AND accountPassword='$affiliatePassword'";

            $result=$this->data->sql($sql);

            $response=array();

            if($result->num_rows > 0){
               $response['response']=true;
               $response['message']="User successfully logged in";

               while($row = $result->fetch_assoc()) {
                   $response['data']['affiliate']=$row;
                }//END while

                $_SESSION["idAffiliate"] = $response['data']['affiliate']['id'];
                $_SESSION["type"] = $response['data']['affiliate']['accountType'];
                $_SESSION["status"] = $response['data']['affiliate']['accountStatus'];
                $_SESSION["active"] = true;
                $_SESSION["checkup"] = [];

            }else{
               $response['response']=false;
               $response['message']="Unknown user";
            }//END if

            echo(json_encode($response));

        }//END checkAfiliateLogin

        function checkUserRegister(){

            //CHECK IF THERE ARE USER WITH THIS CREDENTIALS
            $userEmail=$this->postedData->userEmail;
            $userPassword=$this->postedData->userPassword;

            $trimEmail=preg_replace('/\s+/', '', $userEmail);
            $trimPassword=preg_replace('/\s+/', '', $userPassword);


            if($trimEmail!="" && $trimPassword!==""){

                $sql = "SELECT id, accountType, accountStatus FROM users WHERE profileActivationEmail='$userEmail' AND accountPassword='$userPassword'";

                $result=$this->data->sql($sql);
    
                $response=array();
    
                if($result->num_rows > 0){
    
                    $response['response']=false;
                    $response['message']="user already present";
                    
                    echo(json_encode($response));
    
                }else{
                    $this->registerUser();
                }//END if
    

            }else{
                $response=array();
                $response['response']=false;
                $response['message']="incorrect email and password";
                
                echo(json_encode($response));

            }//END if

           

        }//END checkUserRegister

        function checkAffiliateRegister(){

            //CHECK IF THERE ARE USER WITH THIS CREDENTIALS
            $affiliateType=$this->postedData->affiliateType;
            $affiliateEmail=$this->postedData->affiliateEmail;
            $affiliatePassword=$this->postedData->affiliatePassword;

            $trimEmail=preg_replace('/\s+/', '', $affiliateEmail);
            $trimPassword=preg_replace('/\s+/', '', $affiliatePassword);

            if($trimEmail!="" && $trimPassword!==""){

                $sql = "SELECT id, accountType, accountStatus FROM affiliates WHERE affiliateActivationEmail='$affiliateEmail' AND accountPassword='$affiliatePassword'";

                $result=$this->data->sql($sql);
    
                $response=array();
    
                if($result->num_rows > 0){
    
                    $response['response']=false;
                    $response['message']="affiliate already present";
                    
                    echo(json_encode($response));
    
                }else{
                    $this->registerAffiliate();
                }//END if
    

            }else{
                $response=array();
                $response['response']=false;
                $response['message']="incorrect email and password";
                
                echo(json_encode($response));

            }//END if

           

        }//END checkAffiliateRegister

        function dataHandle(){

            //CHECK IF THERE ARE DATA TO UPDATE OR NOT
            $userEmail=$this->postedData->inputEmail;
            $userCodiceFiscale=$this->postedData->inputFiscalCode;
            $idUser;

            $sql = "SELECT id FROM users WHERE profileActivationEmail='$userEmail'";

            $result=$this->data->sql($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                   $idUser=$row["id"];
                }//END while

                $this->updateData($idUser);

            } else {
                $this->saveData();
            }//END if

        }//END dataHandle

        function affiliateDataHandle(){

            //CHECK IF THERE ARE DATA TO UPDATE OR NOT
            $affiliateEmail=$this->postedData->affiliateActivationEmail;
            $affiliateCodiceFiscale=$this->postedData->affiliateCodiceFiscale;
            $idAffiliate;

            $sql = "SELECT id FROM affiliates WHERE affiliateActivationEmail='$affiliateEmail'";

            $result=$this->data->sql($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                   $idAffiliate=$row["id"];
                }//END while

                $this->updateAffiliateData($idAffiliate);

            }//END if

        }//END affiliateDataHandle

        function updateData($id){
    
            $data=$this->postedData;

            $data->inputEmail=strtolower($data->inputEmail);
            $data->inputName=ucwords($data->inputName);
            $data->inputSurname=ucwords($data->inputSurname);
            $data->inputFiscalCode=strtoupper($data->inputFiscalCode);
            $data->inputBirthPlace=ucwords($data->inputBirthPlace);
            $data->inputAddress=ucwords($data->inputAddress);
            $data->inputAddictionsDescriptions=ucwords($data->inputAddictionsDescriptions);
            $data->inputMemebershipAsl=strtoupper($data->inputMemebershipAsl);
            $data->inputDoctorName=ucwords($data->inputDoctorName);

            $data->inputFiscalCode=preg_replace('/\s+/', '', $data->inputFiscalCode);

            $data->inputEmail=$this->sanitaze($data->inputEmail);
            $data->inputFiscalCode=$this->sanitaze($data->inputFiscalCode);
            $data->inputName=$this->sanitaze($data->inputName);
            $data->inputSurname=$this->sanitaze($data->inputSurname);
            $data->inputGender=$this->sanitaze($data->inputGender);
            $data->inputBirthDay=$this->sanitaze($data->inputBirthDay);
            $data->inputBirthPlace=$this->sanitaze($data->inputBirthPlace);
            $data->inputAddress=$this->sanitaze($data->inputAddress);
            $data->inputProfession=$this->sanitaze($data->inputProfession);
            $data->inputPersonalPhone=$this->sanitaze($data->inputPersonalPhone);
            $data->inputWeight=$this->sanitaze($data->inputWeight);
            $data->inputHeight=$this->sanitaze($data->inputHeight);
            $data->inputSmoke=$this->sanitaze($data->inputSmoke);
            $data->inputDrink=$this->sanitaze($data->inputDrink);
            $data->inputAddictionsDescriptions=$this->sanitaze($data->inputAddictionsDescriptions);
            $data->inputEducation=$this->sanitaze($data->inputEducation);
            $data->inputMaritalStatus=$this->sanitaze($data->inputMaritalStatus);
            $data->inputBloodGroup=$this->sanitaze($data->inputBloodGroup);
            $data->inputMemebershipAsl=$this->sanitaze($data->inputMemebershipAsl);
            $data->inputDoctorName=$this->sanitaze($data->inputDoctorName);
            $data->inputDoctorPhone=$this->sanitaze($data->inputDoctorPhone);

            $data->inputPersonalTown=strtolower($data->inputPersonalTown);
            $data->inputPersonalTown=$this->sanitaze($data->inputPersonalTown);

            $zipCode=$this->findZipCode($data->inputPersonalTown);

            $thisUser=$this->searchUserById($id);

            if($thisUser['accountExpiration']==" " || $thisUser['accountExpiration']==null){
                $attivation=date("d/m/Y");
                $date=date("d-m-Y");
                $expiration=date('d/m/Y', strtotime($date. ' + 15 days'));       
            }else{
                $expiration=$thisUser['accountExpiration'];
            }

            $sql = "UPDATE users SET
                    profileActivationEmail='$data->inputEmail',
                    personalCodiceFiscale='$data->inputFiscalCode', 
                    personalFirstName='$data->inputName', 
                    personalLastName='$data->inputSurname',
                    personalGender='$data->inputGender',
                    personalBirthDay='$data->inputBirthDay',
                    personalBirthPlace='$data->inputBirthPlace',
                    personalAddress='$data->inputAddress',
                    personalZipCode='$zipCode',
                    personalTown='$data->inputPersonalTown', 
                    personalProfession='$data->inputProfession',
                    profilePhoneNumber='$data->inputPersonalPhone',
                    styleWeight='$data->inputWeight',
                    styleHeight='$data->inputHeight',
                    styleSmoke='$data->inputSmoke',
                    styleDrink='$data->inputDrink',
                    styleDrugs='$data->inputAddictionsDescriptions',
                    styleEducation='$data->inputEducation',
                    styleMaritalStatus='$data->inputMaritalStatus',
                    additionalBloodGroup='$data->inputBloodGroup',
                    additionalAsl='$data->inputMemebershipAsl',
                    additionalDoctorName='$data->inputDoctorName',
                    additionalDoctorPhone='$data->inputDoctorPhone',
                    additionalCheckedList='$data->checkedList',
                    accountExpiration='$expiration',
                    profilePhotoLink='$data->inputUploadPhoto'
                    WHERE id='$id'";
                                
                    $response=array();

                    $result=$this->data->sql($sql);

                    if($result===true){
                        $response['response']=true;
                        $response['message']="Successfully updated";
                    }else{
                        $response['response']=false;
                        $response['message']="Error updating";
                    }//END if

                    echo(json_encode($response));

        }//END updateData

        function updateAffiliateData($id){
    
            $data=$this->postedData;

            $data->affiliateActivationEmail=strtolower($data->affiliateActivationEmail);
            $data->affiliateFirstName=ucwords($data->affiliateFirstName);
            $data->affiliateLastName=ucwords($data->affiliateLastName);
            $data->affiliateBirthPlace=ucwords($data->affiliateBirthPlace);
            $data->affiliateCompany=ucwords($data->affiliateCompany);
            $data->affiliateProfession=strtolower($data->affiliateProfession);
            $data->affiliateCodiceFiscale=strtoupper($data->affiliateCodiceFiscale);
            $data->affiliateAddress=ucwords($data->affiliateAddress);

            $data->affiliateCodiceFiscale=preg_replace('/\s+/', '', $data->affiliateCodiceFiscale);

            $data->affiliateActivationEmail=$this->sanitaze($data->affiliateActivationEmail);
            $data->affiliateFirstName=$this->sanitaze($data->affiliateFirstName);
            $data->affiliateLastName=$this->sanitaze($data->affiliateLastName);
            $data->affiliateGender=$this->sanitaze($data->affiliateGender);
            $data->affiliateBirthDay=$this->sanitaze($data->affiliateBirthDay);
            $data->affiliateBirthPlace=$this->sanitaze($data->affiliateBirthPlace);
            $data->affiliatePhoneNumber=$this->sanitaze($data->affiliatePhoneNumber);
            $data->affiliateCompany=$this->sanitaze($data->affiliateCompany);
            $data->affiliateProfession=$this->sanitaze($data->affiliateProfession);
            $data->affiliateCodiceFiscale=$this->sanitaze($data->affiliateCodiceFiscale);
            $data->affiliateZipCode=$this->sanitaze($data->affiliateZipCode);
            $data->affiliateAddress=$this->sanitaze($data->affiliateAddress);
            $data->affiliateDescription=$this->sanitaze($data->affiliateDescription);
            $data->affiliatePhotoLink=$this->sanitaze($data->affiliatePhotoLink);

            $data->affiliateTown=strtolower($data->affiliateTown);
            $data->affiliateTown=$this->sanitaze($data->affiliateTown);

            $zipCode=$this->findZipCode($data->affiliateTown);

            $thisUser=$this->searchAffiliateById($id);

            if($thisUser['accountExpiration']==" " || $thisUser['accountExpiration']==null){
                $attivation=date("d/m/Y");
                $date=date("d-m-Y");
                $expiration=date('d/m/Y', strtotime($date. ' + 15 days'));       
            }else{
                $expiration=$thisUser['accountExpiration'];
            }


            $sql = "UPDATE affiliates SET
                    affiliateActivationEmail='$data->affiliateActivationEmail',
                    affiliateFirstName='$data->affiliateFirstName', 
                    affiliateLastName='$data->affiliateLastName', 
                    affiliateGender='$data->affiliateGender',
                    affiliateBirthDay='$data->affiliateBirthDay',
                    affiliateBirthPlace='$data->affiliateBirthPlace',
                    affiliatePhoneNumber='$data->affiliatePhoneNumber',
                    affiliateCompany='$data->affiliateCompany',
                    affiliateProfession='$data->affiliateProfession',
                    affiliateCodiceFiscale='$data->affiliateCodiceFiscale',
                    affiliateZipCode='$zipCode',
                    affiliateTown='$data->affiliateTown', 
                    affiliateAddress='$data->affiliateAddress',
                    accountExpiration='$expiration',
                    affiliateDescription='$data->affiliateDescription',
                    affiliatePhotoLink='$data->affiliatePhotoLink'
                    WHERE id='$id'";
                                
                    $response=array();

                    $result=$this->data->sql($sql);

                    if($result===true){
                        $response['response']=true;
                        $response['message']="Successfully updated";
                    }else{
                        $response['response']=false;
                        $response['message']="Error updating";
                    }//END if

                    echo(json_encode($response));

        }//END updateAffiliateData

        function updatePrivacy(){

            $id=$_SESSION["id"];
            $session=$_SESSION["active"];

            if($id && $session){

                $data=$this->postedData;

                $privacy=json_encode($data->privacySetting);
    
                $sql = "UPDATE users SET privacySetting='$privacy'
                        WHERE id='$id'";
                                    
                        $response=array();
    
                        $result=$this->data->sql($sql);
    
                        if($result===true){
                            $response['response']=true;
                            $response['message']="Successfully updated";
                        }else{
                            $response['response']=false;
                            $response['message']="Error updating";
                        }//END if
    
                        echo(json_encode($response));

            }//END if
    
        
        }//END updatePrivacy

        function saveData(){
    
            $data=$this->postedData;

            $data->inputEmail=$this->sanitaze($data->inputEmail);
            $data->inputFiscalCode=$this->sanitaze($data->inputFiscalCode);
            $data->inputName=$this->sanitaze($data->inputName);
            $data->inputSurname=$this->sanitaze($data->inputSurname);
            $data->inputGender=$this->sanitaze($data->inputGender);
            $data->inputBirthDay=$this->sanitaze($data->inputBirthDay);
            $data->inputBirthPlace=$this->sanitaze($data->inputBirthPlace);
            $data->inputAddress=$this->sanitaze($data->inputAddress);
            $data->inputProfession=$this->sanitaze($data->inputProfession);
            $data->inputPersonalPhone=$this->sanitaze($data->inputPersonalPhone);
            $data->inputWeight=$this->sanitaze($data->inputWeight);
            $data->inputHeight=$this->sanitaze($data->inputHeight);
            $data->inputSmoke=$this->sanitaze($data->inputSmoke);
            $data->inputDrink=$this->sanitaze($data->inputDrink);
            $data->inputAddictionsDescriptions=$this->sanitaze($data->inputAddictionsDescriptions);
            $data->inputEducation=$this->sanitaze($data->inputEducation);
            $data->inputMaritalStatus=$this->sanitaze($data->inputMaritalStatus);
            $data->inputBloodGroup=$this->sanitaze($data->inputBloodGroup);
            $data->inputMemebershipAsl=$this->sanitaze($data->inputMemebershipAsl);
            $data->inputDoctorName=$this->sanitaze($data->inputDoctorName);
            $data->inputDoctorPhone=$this->sanitaze($data->inputDoctorPhone);

            $sql = "INSERT INTO users (
                    profileActivationEmail,
                    personalCodiceFiscale, 
                    personalFirstName, 
                    personalLastName,
                    personalGender,
                    personalBirthDay,
                    personalBirthPlace,
                    personalAddress,
                    personalProfession,
                    profilePhoneNumber,
                    styleWeight,
                    styleHeight,
                    styleSmoke,
                    styleDrink,
                    styleDrugs,
                    styleEducation,
                    styleMaritalStatus,
                    additionalBloodGroup,
                    additionalAsl,
                    additionalDoctorName,
                    additionalDoctorPhone,
                    profilePhotoLink,
                    accountStatus,
                    accountType,
                    additionalCheckedList)
             VALUES (
                    '$data->inputEmail',
                    '$data->inputFiscalCode', 
                    '$data->inputName', 
                    '$data->inputSurname',
                    '$data->inputGender',
                    '$data->inputBirthDay',
                    '$data->inputBirthPlace',
                    '$data->inputAddress',
                    '$data->inputProfession',
                    '$data->inputPersonalPhone',
                    '$data->inputWeight',
                    '$data->inputHeight',
                    '$data->inputSmoke',
                    '$data->inputDrink',
                    '$data->inputAddictionsDescriptions',
                    '$data->inputEducation',
                    '$data->inputMaritalStatus',
                    '$data->inputBloodGroup',
                    '$data->inputMemebershipAsl',
                    '$data->inputDoctorName',
                    '$data->inputDoctorPhone',
                    '$data->inputUploadPhoto',
                    'pending',
                    'user',
                    '$data->checkedList')";

            $response=array();

            $result=$this->data->sql($sql);

            if($result===true){
                $response['response']=true;
                $response['message']="Successfully saved";
            }else{
                $response['response']=false;
                $response['message']="Error saving";
            }//END if

            echo(json_encode($response));


        }//END saveData

        function registerUser(){
    
            $data=$this->postedData;

            $attivation=date("d/m/Y");
            $date=date("d-m-Y");
            $expiration=date('d/m/Y', strtotime($date. ' + 15 days'));

            $data->userEmail=$this->sanitaze($data->userEmail);
            $data->userPassword=$this->sanitaze($data->userPassword);

            $sql = "INSERT INTO users (
                    profileActivationEmail,
                    accountPassword,
                    accountStatus,
                    profileCreationData,
                    accountExpiration,
                    accountType)
             VALUES (
                    '$data->userEmail',
                    '$data->userPassword', 
                    'pending',
                    '$attivation',
                    '$expiration',
                    'user')";

            $response=array();

            $result=$this->data->sql($sql);

            if($result===true){
                $this->sessionNewUser($data);
            }else{
                $response['response']=false;
                $response['message']="Error adding user";
                echo(json_encode($response));
            }//END if

        }//END registerUser

        function registerAffiliate(){
    
            $data=$this->postedData;

            $attivation=date("d/m/Y");
            $date=date("d-m-Y");
            $expiration=date('d/m/Y', strtotime($date. ' + 15 days'));

            $data->affiliateEmail=$this->sanitaze($data->affiliateEmail);
            $data->affiliatePassword=$this->sanitaze($data->affiliatePassword);

            $sql = "INSERT INTO affiliates (
                    affiliateActivationEmail,
                    affiliateProfession,
                    accountPassword,
                    accountStatus,
                    affiliateCreationData,
                    accountExpiration,
                    accountType)
             VALUES (
                    '$data->affiliateEmail',
                    '$data->affiliateType',
                    '$data->affiliatePassword', 
                    'pending',
                    '$attivation',
                    '$expiration',
                    'affiliate')";

            $response=array();

            $result=$this->data->sql($sql);

            if($result===true){

                $this->sessionNewAffiliate($data);
            }else{
                $response['response']=false;
                $response['message']="Error adding affiliate";
                echo(json_encode($response));
            }//END if

        }//END registerAffiliate

        function loadUserDataList(){

            $sql = "SELECT * FROM users";

            $result=$this->data->sql($sql);

            $response=array();

            if ($result->num_rows > 0) {

                $response['response']=true;
                $response['message']="Successfully uploaded";

                while($row = $result->fetch_assoc()) {
                   $row['accountPassword']="*****";
                   $response['data']['users'][]=$row;
                }//END while

            } else {
                   $response['response']=false;
                   $response['message']="Error loading";
            }//END if

            echo(json_encode($response));


        }//END loadUserDataList

        function sessionNewUser($data){

            //CHECK IF THERE ARE USER WITH THIS CREDENTIALS
            $userEmail=$data->userEmail;
            $userPassword=$data->userPassword;

            $sql = "SELECT * FROM users WHERE profileActivationEmail='$userEmail' AND accountPassword='$userPassword'";

            $result=$this->data->sql($sql);

            $response=array();

            if($result->num_rows > 0){
               $response['response']=true;
               $response['message']="User successfully logged in";

               while($row = $result->fetch_assoc()) {
                   $response['data']['user']=$row;
                }//END while

                $_SESSION["id"] = $response['data']['user']['id'];
                $_SESSION["type"] = $response['data']['user']['accountType'];
                $_SESSION["status"] = $response['data']['user']['accountStatus'];
                $_SESSION["active"] = true;

                $jsonEvent['type']="inizio";
                $jsonEvent['message']="Oggi hai creato il tuo profilo";
                $jsonEvent=json_encode($jsonEvent);
                $this->messageEvent->pushEvent($jsonEvent);

            }else{
               $response['response']=false;
               $response['message']="Unknown user";
            }//END if

            echo(json_encode($response));

        }//END sessionNewUser

        function loadAffiliateProfile(){

            if($_SESSION["active"]===true){

                $idAffiliate=$_SESSION["idAffiliate"];

                $sql = "SELECT * FROM affiliates WHERE id='$idAffiliate'";

                $result=$this->data->sql($sql);

                $response=array();
    
                if ($result->num_rows > 0) {
    
                    $response['response']=true;
                    $response['message']="Profile loaded!";
    
                    while($row = $result->fetch_assoc()) {
                       $row['accountPassword']="*****";

                       $row['timeLine']=$this->messageEvent->getEvents();

                       if(strlen($row['timeLine'])<=3){

                            $jsonEvent['type']="avviso";
                            $jsonEvent['message']="Ciao nuovo utente!";
                            $jsonEvent=json_encode($jsonEvent);
                            $this->messageEvent->pushEvent($jsonEvent);

                            $row['timeLine']=$this->messageEvent->getEvents();   

                       };//END if

                       //USE UTF FUNCTION FOR CONVERT UTF CHARS
                       $row['timeLine']=$this->UTF($row['timeLine']);

                       $response['data']['affiliate']=$row;

                    }//END while
    
                } else {
                       $response['response']=false;
                       $response['message']="Error loading affiliate profile!";
                }//END if

            }else{
                    $response['response']=false;
                    $response['message']="Session expired!";
            }//END if

            echo(json_encode($response));

        }//END loadAffiliateProfile

        function loadUserProfile(){

            if($_SESSION["active"]===true){

                $idUser=$_SESSION["id"];

                $sql = "SELECT * FROM users WHERE id='$idUser'";

                $result=$this->data->sql($sql);

                $response=array();
    
                if ($result->num_rows > 0) {
    
                    $response['response']=true;
                    $response['message']="Profile loaded!";
    
                    while($row = $result->fetch_assoc()) {

                       $row['accountPassword']="*****";

                       $row['timeLine']=$this->messageEvent->getEvents();

                       if(strlen($row['timeLine'])<=3){

                            $jsonEvent['type']="avviso";
                            $jsonEvent['message']="Ciao nuovo utente!";
                            $jsonEvent=json_encode($jsonEvent);
                            $this->messageEvent->pushEvent($jsonEvent);

                            $row['timeLine']=$this->messageEvent->getEvents();   

                       };//END if

                        //USE UTF FUNCTION FOR CONVERT UTF CHARS
                        $row['timeLine']=$this->UTF($row['timeLine']);
                        $row['diet']=$this->UTF($row['diet']);

                        $response['data']['user']=$row;

                    }//END while
    
                } else {
                       $response['response']=false;
                       $response['message']="Error loading profile!";
                }//END if

            }else{
                    $response['response']=false;
                    $response['message']="Session expired!";
            }//END if

            echo(json_encode($response));

        }//END loadUserProfile

        function loadUserPricing(){

            if($_SESSION["active"]===true){

                $this->data=new sqlConnect;
                $this->data->connect();

                $userType=$_SESSION["type"];
                $table=null;

                if($userType=='affiliate'){
                    $userId=$_SESSION["idAffiliate"];
                    $table='affiliates';
                };//END if

                if($userType=='user'){
                    $userId=$_SESSION["id"];
                    $table='users';
                };//END if

                if($table!=null){

                    $sql = "SELECT accountExpiration,id,accountType,accountStatus FROM $table WHERE id='$userId'";

                    $result=$this->data->sql($sql);

                    if ($result->num_rows > 0) {
    
                        $response['response']=true;
                        $response['message']="Profile loaded!";
        
                        while($row = $result->fetch_assoc()) {
                         
    
                           $response['data']['user']=$row;
    
                        }//END while
        
                    } else {
                           $response['response']=false;
                           $response['message']="Error loading profile!";
                           $response['message']=$sql;
                    }//END if

                };//END if

            }//END if


            echo(json_encode($response));

        }//END loadUserPricing

        function UTF($string){

            $str = str_replace('\u','u',$string);
            $str_replaced = preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $str);

            return $str_replaced;

        }//END UTF

        function loadUserCard(){

            if($_SESSION["active"]===true){

                $idUser=$_SESSION["id"];

                $sql = "SELECT * FROM users WHERE id='$idUser'";

                $result=$this->data->sql($sql);

                $response=array();
    
                if ($result->num_rows > 0) {
    
                    $response['response']=true;
                    $response['message']="Profile loaded!";

                    while($row = $result->fetch_assoc()) {

                        //ADDITIONALCHECKLIST
                        $additionalCheckedList=$row['additionalCheckedList'];

                        if(strlen($additionalCheckedList)==0){
                            $row['additionalCheckedList']=null;
                        };//END if

                       //PRIVACY SETTINGS
                       $row['accountPassword'] = str_repeat("*", strlen($row['accountPassword'])); 

                       $privacySetting=json_decode($row['privacySetting'], false);

                        if($privacySetting->privacyName=='false'){
                            $row['personalFirstName']=str_replace(".","",$row['personalFirstName']);
                            $row['personalLastName']=str_replace(".","",$row['personalLastName']);
                            $row['personalFirstName']=str_replace(" ","",$row['personalFirstName']);
                            $row['personalLastName']=str_replace(" ","",$row['personalLastName']);
                            $row['personalFirstName']=substr($row['personalFirstName'],0,1).".";
                            $row['personalLastName']=substr($row['personalLastName'],0,1).".";
                        };//END if

                       if($privacySetting->privacyPhoto=='false'){
                            $row['profilePhotoLink']=null;
                       };//END if

                       if($privacySetting->privacyCard=='false'){
                            $row['personalCodiceFiscale'] = str_repeat("*", strlen($row['personalCodiceFiscale'])); 
                       };//END if

                       if($privacySetting->privacyAddress=='false'){
                            $row['personalAddress'] = str_repeat("*", strlen($row['personalAddress'])); 
                       };//END if

                       if($privacySetting->privacyEmail=='false'){
                            $row['profileActivationEmail'] = str_repeat("*", strlen($row['profileActivationEmail'])); 
                       };//END if

                       if($privacySetting->privacyPhone=='false'){
                            $row['profilePhoneNumber'] = str_repeat("*", strlen($row['profilePhoneNumber'])); 
                       };//END if

                       $response['data']['user']=$row;


                    }//END while
    
                } else {
                       $response['response']=false;
                       $response['message']="Error loading profile!";
                }//END if

            }else{
                    $response['response']=false;
                    $response['message']="Session expired!";
            }//END if

            echo(json_encode($response));

        }//END loadUserCard

        function searchId($id){

            if($id){

                $idUser=$id;

                $sql = "SELECT * FROM users WHERE id='$idUser'";

                $result=$this->data->sql($sql);

                $response=array();
    
                if ($result->num_rows > 0) {
    
                    $response['response']=true;
                    $response['message']="Profile loaded!";

                    while($row = $result->fetch_assoc()) {

                        //ADDITIONALCHECKLIST
                        $additionalCheckedList=$row['additionalCheckedList'];

                        if(strlen($additionalCheckedList)==0){
                            $row['additionalCheckedList']=null;
                        };//END if

                       //PRIVACY SETTINGS
                       $row['accountPassword'] = str_repeat("*", strlen($row['accountPassword'])); 

                       $privacySetting=json_decode($row['privacySetting'], false);

                        if($privacySetting->privacyName=='false'){
                            $row['personalFirstName']=str_replace(".","",$row['personalFirstName']);
                            $row['personalLastName']=str_replace(".","",$row['personalLastName']);
                            $row['personalFirstName']=str_replace(" ","",$row['personalFirstName']);
                            $row['personalLastName']=str_replace(" ","",$row['personalLastName']);
                            $row['personalFirstName']=substr($row['personalFirstName'],0,1).".";
                            $row['personalLastName']=substr($row['personalLastName'],0,1).".";
                        };//END if

                       if($privacySetting->privacyPhoto=='false'){
                            $row['profilePhotoLink']=null;
                       };//END if

                       if($privacySetting->privacyCard=='false'){
                            $row['personalCodiceFiscale'] = str_repeat("*", strlen($row['personalCodiceFiscale'])); 
                       };//END if

                       if($privacySetting->privacyAddress=='false'){
                            $row['personalAddress'] = str_repeat("*", strlen($row['personalAddress'])); 
                       };//END if

                       if($privacySetting->privacyEmail=='false'){
                            $row['profileActivationEmail'] = str_repeat("*", strlen($row['profileActivationEmail'])); 
                       };//END if

                       if($privacySetting->privacyPhone=='false'){
                            $row['profilePhoneNumber'] = str_repeat("*", strlen($row['profilePhoneNumber'])); 
                       };//END if

                       $response['data']['user']=$row;


                    }//END while
    
                } else {
                       $response['response']=false;
                       $response['message']="Error loading profile!";
                }//END if

            }else{
                    $response['response']=false;
                    $response['message']="Session expired!";
            }//END if

            echo(json_encode($response));

        }//END searchId

        function searchUserById($id){

            if($id){

                $idUser=$id;

                $sql = "SELECT * FROM users WHERE id='$idUser'";

                $result=$this->data->sql($sql);

                $response=array();
    
                if ($result->num_rows > 0) {
    
                    $response['response']=true;
                    $response['message']="Profile loaded!";

                    while($row = $result->fetch_assoc()) {

                        $response=$row;

                    }//END while
    
                }//END if

                return $response;

            }//END if


        }//END searchUserById

        function searchAffiliateById($id){

            if($id){

                $idAffiliate=$id;

                $sql = "SELECT * FROM affiliates WHERE id='$idAffiliate'";

                $result=$this->data->sql($sql);

                $response=array();
    
                if ($result->num_rows > 0) {
    
                    $response['response']=true;
                    $response['message']="Profile loaded!";

                    while($row = $result->fetch_assoc()) {

                        $response=$row;

                    }//END while
    
                }//END if

                return $response;

            }//END if


        }//END searchAffiliateById
        
        function chatHint(){

            $message=$this->postedData->message;

            if($_SESSION["active"]===true && $message!="" && $message!=" "){

                $idUser=$_SESSION["id"];

                $response=array();
                $symptoms=array();

                $checkup=$this->getSymptoms();

                if ($checkup) {
    
                    $response['response']=true;
                    $response['message']="Symptoms loaded!";

                    $symptoms=array_values(array_unique($checkup['symptom'],SORT_REGULAR));

                    $message = strtolower($message);

                    $length=strlen($message);

                    $hint="";

                    foreach($symptoms as $symptom) {

                        if(strpos($symptom, $message) !== false){
                            if ($hint === "") {
                                $hint = $symptom;
                            } else {
                                $hint .= " , $symptom";
                            }
                        }//END if

                    };//END foreach

                    $response['hints']=$hint;
    
                } else {
                       $response['response']=false;
                       $response['message']="Error loading profile!";
                }//END if

            }else{
                    $response['response']=false;
                    $response['message']="Session expired!";
            }//END if

                echo(json_encode($response));
            

        }//END chatHint

        function townHint(){

            $input=$this->postedData->input;

            if($_SESSION["active"]===true && $input!="" && $input!=" "){

                $idUser=$_SESSION["id"];

                $response=array();
                $towns=array();

                $sql = "SELECT * FROM zipcode";

                $result=$this->data->sql($sql);

                $response=array();
    
                if ($result->num_rows > 0) {
    
                    while($row = $result->fetch_assoc()) {

                        $towns[]=$row;

                    };//END while

                };//END if

                if ($towns) {
    
                    $response['response']=true;
                    $response['message']="Towns loaded!";

                    $input = strtolower($input);

                    $hint="";

                    foreach($towns as $town) {

                        $city=$town['Comune'];
                        $citySl = strtolower($city);

                        $citySl=trim($citySl, " "); 
                        $input=trim($input, " "); 

                        if(strpos($citySl, $input) !== false){
                            if ($hint === "") {
                                $hint = $city;
                            } else {
                                $hint .= " , $city";
                            }
                        }//END if

                    };//END foreach

                    $response['hints']=$hint;
    
                } else {
                       $response['response']=false;
                       $response['message']="Error loading profile!";
                }//END if

            }else{
                    $response['response']=false;
                    $response['message']="Session expired!";
            }//END if

                echo(json_encode($response));

        }//END townHint

        function findZipCode($userTown){

            $input=$this->postedData->input;

            $zipCode="";

            if($_SESSION["active"]===true && $userTown!="" && $userTown!=" "){

                $sql = "SELECT CAP FROM zipcode WHERE Comune='$userTown'";

                $result=$this->data->sql($sql);
    
                if ($result->num_rows > 0) {
    
                    while($row = $result->fetch_assoc()) {

                        $zipCode=$row['CAP'];

                    };//END while

                }//END if

            }//END if

            return $zipCode;

        }//END findZipCode

        function getSymptoms(){

            $checkup=array();
            $checkup['disease']=[];
            $checkup['symptom']=[];

            $sql = "SELECT * FROM checkup";

                $result=$this->data->sql($sql);
    
                if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()) {

                        $checkup['symptom'][]=$row['symptom'];
                        $checkup['disease'][]=$row['disease'];

                    }//END while

                    $checkup['symptom']=array_values(array_unique($checkup['symptom'],SORT_REGULAR));
                    $checkup['disease']=array_values(array_unique($checkup['disease'],SORT_REGULAR));
               
                };//END if

                    return $checkup;
                
        }//END getSymptoms

        function sessionNewAffiliate($data){

            //CHECK IF THERE ARE USER WITH THIS CREDENTIALS
            $affiliateType=$data->affiliateType;
            $affiliateEmail=$data->affiliateEmail;
            $affiliatePassword=$data->affiliatePassword;
    
            $sql = "SELECT * FROM affiliates WHERE affiliateActivationEmail='$affiliateEmail' AND accountPassword='$affiliatePassword'";
    
            $result=$this->data->sql($sql);
    
            $response=array();
    
                if($result->num_rows > 0){
                    $response['response']=true;
                    $response['message']="Affiliate successfully logged in";
    
                    while($row = $result->fetch_assoc()) {
                        $response['data']['affiliate']=$row;
                    }//END while
    
                    $_SESSION["idAffiliate"] = $response['data']['affiliate']['id'];
                    $_SESSION["type"] = $response['data']['affiliate']['accountType'];
                    $_SESSION["status"] = $response['data']['affiliate']['accountStatus'];
                    $_SESSION["active"] = true;
    
                    $jsonEvent['type']="inizio";
                    $jsonEvent['message']="Oggi hai creato il tuo profilo di affiliazione";
                    $jsonEvent=json_encode($jsonEvent);
                    $this->messageEvent->pushEvent($jsonEvent);
    
                }else{
                    $response['response']=false;
                    $response['message']="Unknown user";
                }//END if
    
                echo(json_encode($response));
    
        }//END sessionNewAffiliate

        
    }//END Class UserData

    $user=new UserData;
    $user->checkPost();

    $controller=new Controller;
    $controller->start();

?>



