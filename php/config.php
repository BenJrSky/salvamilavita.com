<?php
    ini_set('display_errors', 0);

    include "sqlParams.php";

    class sqlConnect{

        public $servername;
        public $username;
        public $password;
        public $dbname;
        public $connection;
        public $sql;

        function set_environment(){

            $parameters2=new SqlParamers;
            $parameters2->init();

            $this->servername = $parameters2->servername;
            $this->username = $parameters2->username;
            $this->password = $parameters2->password;
            $this->dbname = $parameters2->dbname;


        }//END set_environment

        function connect(){

            $this->set_environment();

            //CONNECT
            $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            if($this->connection->connect_error){
                die("CONNECTION FAILED: " . $this->connection->connect_error . "\r\n");
            }else{
                //echo "CONNECTED SUCCESFULLY \r\n";
            }
            //END if

        }//END connect

        function sql($mySql){

            $result=$this->connection->query($mySql);

            if (!$this->connection->error) {
                return $result;
            } else {
                return $result;
            }//END if

            

        }//END function

    }//END class Connect

    class ConnectData{

        public $servername;
        public $username;
        public $password;
        public $dbname;
        public $connection;
        public $sql;

        function set_environment(){

            $parameters=new SqlParamers;
            $parameters->init();

            $this->servername = $parameters->servername;
            $this->username = $parameters->username;
            $this->password = $parameters->password;
            $this->dbname = $parameters->dbname;

        }//END set_environment


        function connect(){

            $this->set_environment();

            //CONNECT
            $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            if($this->connection->connect_error){
                die("CONNECTION FAILED: " .$this->connection->connect_error . "\r\n");
            }else{
                //echo "CONNECTED SUCCESFULLY \r\n";
                $this->set_tables();
            }
            //END if

        }//END connect

        function set_tables(){

            include "checkup.php";
            include "zipcode.php";
            include "foods.php";

            //CHECK IF TABLE CHECKUP EXIST
            $this->sql = "SELECT * FROM checkup";

            $result = $this->connection->query($this->sql);

            if (!$result) {
                $this->connection->query($sqlCheckupTable);
                $this->connection->query($sqlCheckupQuery);
            }//END if

            //CHECK IF TABLE ZIPCODE EXIST
            $this->sql = "SELECT * FROM zipcode";

            $result = $this->connection->query($this->sql);

            if (!$result) {
                $this->connection->query($sqlZipcodeTable);
                $this->connection->query($sqlZipQuery);
            }//END if

             //CHECK IF TABLE CHECKUP EXIST
             $this->sql = "SELECT * FROM foods";

             $result = $this->connection->query($this->sql);
 
             if (!$result) {
                 $this->connection->query($sqlFoodsTable);
                 $this->connection->query($sqlFoodsQuery);
             }//END if

            //CHECK IF TABLE POSTES EXIST
            $this->sql = "SELECT * FROM postes";

            $result = $this->connection->query($this->sql);

            if (!$result) {
                $this->sql = "CREATE TABLE postes (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    typology VARCHAR(30) DEFAULT ' ',
                    picture TEXT,
                    likes TEXT,
                    comments TEXT,
                    postDate VARCHAR(30) DEFAULT ' ',
                    postHour VARCHAR(30) DEFAULT ' ',
                    postUpdate VARCHAR(30) DEFAULT ' ',
                    hourUpdate VARCHAR(30) DEFAULT ' ',
                    userId VARCHAR(30) DEFAULT ' ',
                    userType VARCHAR(30) DEFAULT ' ',
                    postExpiration VARCHAR(30) DEFAULT ' ',
                    postTitle VARCHAR(80) DEFAULT ' ',
                    postMessage VARCHAR(500) DEFAULT ' ')";
                
                $this->connection->query($this->sql);
            }//END if

            //CHECK IF TABLE TIMELINE EXIST
            $this->sql = "SELECT * FROM timeline";

            $result = $this->connection->query($this->sql);

            if (!$result) {
                $this->sql = "CREATE TABLE timeline (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    userId VARCHAR(30) DEFAULT ' ',
                    userType VARCHAR(30) DEFAULT ' ',
                    eventDate VARCHAR(30) DEFAULT ' ',
                    eventHour VARCHAR(30) DEFAULT ' ',
                    eventType VARCHAR(30) DEFAULT ' ',
                    eventMessage TEXT)";
                
                $this->connection->query($this->sql);
            }//END if

            //CHECK IF TABLE PAYMENTS EXIST
            $this->sql = "SELECT * FROM paypal_payments";

            $result = $this->connection->query($this->sql);

            if (!$result) {
                $this->sql = "CREATE TABLE paypal_payments (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    item_no VARCHAR(255) DEFAULT ' ',
                    transaction_id VARCHAR(255) DEFAULT ' ',
                    payment_amount FLOAT(10,2) NOT NULL,
                    currency_code VARCHAR(5) DEFAULT ' ',
                    payment_status VARCHAR(255) DEFAULT ' ',
                    userId VARCHAR(30) DEFAULT ' ',
                    userType VARCHAR(30) DEFAULT ' ')";
                
                $this->connection->query($this->sql);
            }//END if

            //CHECK IF TABLE PAYPAL POST EXIST
            $this->sql = "SELECT * FROM paypal_post";

            if (!$result) {
                $this->sql = "CREATE TABLE paypal_post (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    post TEXT)";
                
                $this->connection->query($this->sql);
            }//END if

            //CHECK IF TABLE FOOD DIARY POST EXIST
            $this->sql = "SELECT * FROM food_diary";

            $result = $this->connection->query($this->sql);

            if (!$result) {
                $this->sql = "CREATE TABLE food_diary (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    userId VARCHAR(10) DEFAULT ' ',
                    userType VARCHAR(30) DEFAULT ' ',
                    foodName VARCHAR(100) DEFAULT ' ',
                    foodGrams VARCHAR(30) DEFAULT ' ',
                    carboGrams VARCHAR(30) DEFAULT ' ',
                    protGrams VARCHAR(30) DEFAULT ' ',
                    fatGrams VARCHAR(30) DEFAULT ' ',
                    kilocal VARCHAR(30) DEFAULT ' ',
                    foodDate VARCHAR(10) DEFAULT ' ',
                    foodHour VARCHAR(10) DEFAULT ' ',
                    label VARCHAR(30) DEFAULT ' ',
                    foodExpiration VARCHAR(30) DEFAULT ' ')";
                
                $this->connection->query($this->sql);
            }//END if

            //CHECK IF TABLE MESSAGES EXIST
            $this->sql = "SELECT * FROM messagges";

            $result = $this->connection->query($this->sql);

            if (!$result) {
                $this->sql = "CREATE TABLE messagges (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    senderId VARCHAR(10) DEFAULT ' ',
                    senderType VARCHAR(30) DEFAULT ' ',
                    recipientId VARCHAR(10) DEFAULT ' ',
                    recipientType VARCHAR(30) DEFAULT ' ',
                    messageText VARCHAR(200) DEFAULT ' ',
                    messageDate VARCHAR(30) DEFAULT ' ',
                    messageHour VARCHAR(30) DEFAULT ' ',
                    typology VARCHAR(30) DEFAULT ' ',
                    messageRead tinyint(1) DEFAULT 0,
                    messageDateRead VARCHAR(30) DEFAULT ' ',
                    messageHourRead VARCHAR(30) DEFAULT ' ',
                    messageExpiration VARCHAR(30) DEFAULT ' ')";
                
                $this->connection->query($this->sql);
            }//END if
 

             //CHECK IF TABLE COMMENTS EXIST
             $this->sql = "SELECT * FROM comments";

             $result = $this->connection->query($this->sql);
 
             if (!$result) {
                 $this->sql = "CREATE TABLE comments (
                     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                     typology VARCHAR(30) DEFAULT ' ',
                     likes TEXT,
                     postId VARCHAR(30) DEFAULT ' ',
                     postDate VARCHAR(30) DEFAULT ' ',
                     postHour VARCHAR(30) DEFAULT ' ',
                     postUpdate VARCHAR(30) DEFAULT ' ',
                     hourUpdate VARCHAR(30) DEFAULT ' ',
                     userId VARCHAR(30) DEFAULT ' ',
                     userType VARCHAR(30) DEFAULT ' ',
                     postExpiration VARCHAR(30) DEFAULT ' ',
                     postMessage VARCHAR(500) DEFAULT ' ')";
                 
                 $this->connection->query($this->sql);
             }//END if

            //CHECK IF TABLE AFFILIATES EXIST
            $this->sql = "SELECT * FROM affiliates";

            $result = $this->connection->query($this->sql);

            if (!$result) {
                $this->sql = "CREATE TABLE affiliates (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    affiliateCodiceFiscale VARCHAR(30) DEFAULT ' ',
                    affiliateCompany VARCHAR(100) DEFAULT ' ',
                    affiliateFirstName VARCHAR(30) DEFAULT ' ',
                    affiliateLastName VARCHAR(30) DEFAULT ' ',
                    affiliateGender VARCHAR(10) DEFAULT ' ',
                    affiliateBirthDay VARCHAR(10) DEFAULT ' ',
                    affiliateBirthPlace VARCHAR(30) DEFAULT ' ',
                    affiliateAddress VARCHAR(100) DEFAULT ' ',
                    affiliateProfession VARCHAR(100) DEFAULT ' ',
                    affiliateZipCode VARCHAR(10) DEFAULT ' ',
                    affiliateTown VARCHAR(50) DEFAULT ' ',
                    affiliateDescription TEXT,
                    timeLine TEXT,
                    affiliatePhotoLink TEXT,
                    affiliateCreationData VARCHAR(100) DEFAULT ' ',
                    affiliateActivationEmail VARCHAR(100) DEFAULT ' ',
                    affiliateRecoveryEmail VARCHAR(100) DEFAULT ' ',
                    affiliatePhoneNumber VARCHAR(30) DEFAULT ' ',
                    accountStatus VARCHAR(10) DEFAULT ' ',
                    accountType VARCHAR(10) DEFAULT ' ',
                    accountPayment VARCHAR(10) DEFAULT ' ',
                    accountPassword VARCHAR(30) DEFAULT ' ',
                    accountPrice VARCHAR(10) DEFAULT ' ',
                    accountPromotions VARCHAR(30) DEFAULT ' ',
                    accountExpiration VARCHAR(30) DEFAULT ' ',
                    accountNotifications TEXT
                    )";
                
                $this->connection->query($this->sql);
            }//END if

            //CHECK IF TABLE USERS EXIST
            $this->sql = "SELECT * FROM users";

            $result = $this->connection->query($this->sql);

            if ($result) {
                $tablaExist=true;
                //echo "TABLE ALREADY EXIST! \r\n";
            }else { 
                $tablaExist=false;
                //echo "TABLE DOESN'T EXIST! \r\n";
            }//END if

            //CREATE TABLE USERS
            if($tablaExist===false){

                $this->sql = "CREATE TABLE users (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        personalCodiceFiscale VARCHAR(30) DEFAULT ' ',
                        personalFirstName VARCHAR(30) DEFAULT ' ',
                        personalLastName VARCHAR(30) DEFAULT ' ',
                        personalGender VARCHAR(10) DEFAULT ' ',
                        personalBirthDay VARCHAR(10) DEFAULT ' ',
                        personalBirthPlace VARCHAR(30) DEFAULT ' ',
                        personalAddress VARCHAR(100) DEFAULT ' ',
                        personalProfession VARCHAR(100) DEFAULT ' ',
                        personalZipCode VARCHAR(10) DEFAULT ' ',
                        personalTown VARCHAR(50) DEFAULT ' ',
                        styleWeight VARCHAR(5) DEFAULT ' ',
                        styleHeight VARCHAR(5) DEFAULT ' ',
                        styleSmoke VARCHAR(30) DEFAULT ' ',
                        styleDrink VARCHAR(30) DEFAULT ' ',
                        styleDrugs VARCHAR(100) DEFAULT ' ',
                        styleEducation VARCHAR(30) DEFAULT ' ',
                        styleMaritalStatus VARCHAR(30) DEFAULT ' ',
                        additionalAsl VARCHAR(30) DEFAULT ' ',
                        additionalDoctorName VARCHAR(100) DEFAULT ' ',
                        additionalDoctorPhone VARCHAR(30) DEFAULT ' ',
                        additionalCheckedList TEXT,
                        additionalBloodGroup VARCHAR(5) DEFAULT ' ',
                        timeLine TEXT,
                        additionalilnesses VARCHAR(100) DEFAULT ' ',
                        privacySetting TEXT,
                        diet TEXT,
                        allergyRespiratory VARCHAR(30) DEFAULT ' ',
                        allergyOthers VARCHAR(30) DEFAULT ' ',
                        vaccinationsTypes VARCHAR(100) DEFAULT ' ',
                        diseasesTypes VARCHAR(100) DEFAULT ' ',
                        missingOrgans VARCHAR(100) DEFAULT ' ',
                        profilePhotoLink TEXT,
                        profileCertificateLink VARCHAR(200) DEFAULT ' ',
                        profileDocumentLink VARCHAR(200) DEFAULT ' ',
                        profileCreationData VARCHAR(100) DEFAULT ' ',
                        profileActivationEmail VARCHAR(100) DEFAULT ' ',
                        profileRecoveryEmail VARCHAR(100) DEFAULT ' ',
                        profilePhoneNumber VARCHAR(30) DEFAULT ' ',
                        accountStatus VARCHAR(10) DEFAULT ' ',
                        accountType VARCHAR(10) DEFAULT ' ',
                        accountPayment VARCHAR(10) DEFAULT ' ',
                        accountPassword VARCHAR(30) DEFAULT ' ',
                        accountPrice VARCHAR(10) DEFAULT ' ',
                        accountPromotions VARCHAR(30) DEFAULT ' ',
                        accountExpiration VARCHAR(30) DEFAULT ' ',
                        accountNotifications TEXT
                        )";
                    
                    $this->connection->query($this->sql);

            }//END if

        }//END function


        function sql($mySql){

            $result=$this->connection->query($mySql);

            if (!$this->connection->error) {
                return $result;
            } else {
                return $result;
            }//END if

            

        }//END function


    }//END class ConnectData

   $dataApp=new ConnectData;
   $dataApp->connect();

?>