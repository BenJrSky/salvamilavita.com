<?php

    session_start();

    require_once "post.php";

    class Message{

        public $typology;
        public $recipientId;
        public $recipientType;
        public $message;
        
    }//END Message

    class Controller{

        function start(){

            if($_SESSION["active"]===true){

                $this->data=new sqlConnect;
                $this->data->connect();

                $userType=$_SESSION["type"];

                if($userType=='affiliate'){
                    $userId=$_SESSION["idAffiliate"];
                    $this->getAffiliate($userId,$userType);
                };//END if

                if($userType=='user'){
                    $userId=$_SESSION["id"];
                    $this->getUser($userId,$userType);
                };//END if

            }//END if

        }//END start

        function getUser($id){

            $user;

            $sql = "SELECT * FROM users WHERE id='$id'";

            $result=$this->data->sql($sql);

            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {

                    $user=$row;

                }//END while

                $this->checkUser($user);
                
            }//END if

            

        }//END getUser

        function getAffiliate($id){

            $user;

            $sql = "SELECT * FROM affiliates WHERE id='$id'";

            $result=$this->data->sql($sql);

            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {

                    $user=$row;

                }//END while
                
            }//END if

            $this->checkAffiliate($user);

        }//END getAffiliate

        function checkUser($user){

            $post=new Post;
            $search=new Search;
            
            $userId=$user['id'];
            $userType=$user['accountType'];
            $userGender;

            if($user['personalGender']=='male'){
                $userGender='M';
            }else{
                $userGender='F';
            }//END if

            //CHECK IF THERE IS ZIPCODE
            $fisCode=$search->getFisCode($user['personalZipCode']);
            $userName=$user['personalFirstName'];

            //NOTIFY 001
            if($fisCode==null){

                $text=$userName." non hai ancora comunicato un codice postale valido. Per farlo, scegli il comune da dati personali.";

                $message=new Message;

                $message->typology="001";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if
                
            }//END if

            //CHECK AGE
            $checkAge=false;
            $age=0;
            $validate=new Validate;
            $checkDay=$validate->validateDate($user['personalBirthDay'], 'd/m/Y');

            if($checkDay==true){
                $birthDay=explode('/',$user['personalBirthDay']);
                $day=$birthDay[0];
                $month=$birthDay[1];
                $year=$birthDay[2];
                $today=new DateTime(date("d-m-Y"));
                $birthDay=new DateTime($day."-".$month."-".$year);
                $birthCod=new DateTime($year."-".$month."-".$day);
                $diff=$birthDay->diff($today);
                $age=$diff->y;
                $checkAge=true;
            }//END if

            //NOTIFY 002
            if($age<=0 || $age>120){

                $text="Ciao ".$userName." visionando la tua scheda ho notato che la tua data di nascita non è valida. Ti prego, controllala. Grazie.";

                $message=new Message;

                $message->typology="002";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $checkAge=false;
                
            }//END if

            //CHECK NAME
            $name=$user['personalFirstName'];
            $lastName=$user['personalLastName'];
            $checkName=true;

            //NOTIFY 003
            if(strlen($name)<=3 || strlen($lastName)<=3 ){

                $text="Ti suggerisco di indicare il tuo nome e cognome esatto. In questo modo sarà più semplice il controllo dei tuoi dati.";

                $message=new Message;

                $message->typology="003";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $checkName=false;
                
            }//END if

            //CHECK BIRTHPLACE
            $birthPlace=ucfirst($user['personalBirthPlace']);
            $birthPlace=str_replace(' ', '', $birthPlace);
            $townCode=$search->getTown($birthPlace);
            $checkTown=true;

            //NOTIFY 004
            if($townCode==null){

                $text="Il tuo comune di nascita non è corretto, verificalo e aggiorna il tuo profilo. Grazie ".$userName.".";

                $message=new Message;

                $message->typology="004";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $checkTown=false;
                
            }//END if

            //CODICE FISCALE CECKER
            $personalCodiceFiscale=str_replace(' ', '', $user['personalCodiceFiscale']);
            $personalCodiceFiscale=strtoupper($personalCodiceFiscale);

            if($checkName==true && $checkAge==true && $checkTown==true && $checkDay==true){

                $calc = new Calculator();
                $codiceFiscale=$calc->calcola($name, $lastName, $userGender, $birthCod, $townCode);
                $codiceFiscale=strtoupper($codiceFiscale);

                //NOTIFY 005
                if($personalCodiceFiscale!==$codiceFiscale){

                    $text="Il codice fiscale presente nella tua scheda non è corretto. Il tuo codice fiscale dovrebbe essere: <strong>".$codiceFiscale."</strong> ti consiglio di verificare ed aggiornare la tua scheda. A presto.";
    
                    $message=new Message;
    
                    $message->typology="005";
                    $message->recipientId=$userId;
                    $message->recipientType=$userType;
                    $message->message=$text;
    
                    $status=$search->checkNotify($message);
    
                    if($status==false){
                        $post->sendNotify($message);
                    }//END if
    
                    $checkTown=false;
                    
                }//END if

            }//END if

            //NOTIFY 006
            if(strlen($personalCodiceFiscale)<8 || strlen($personalCodiceFiscale)>16){

                $text="Il codice fiscale inserito non ha una lunghezza valida. Verifica ed inserisci il codice esatto.";

                $message=new Message;

                $message->typology="006";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $checkTown=false;
                
            }//END if

            //CHECK IF THERE IS EXPIRATION
            $exp = explode('/',$user['accountExpiration']);
            $day = $exp[0];
            $month=$exp[1];
            $year=$exp[2];
            $today=new DateTime(date("d-m-Y"));
            $expiration=new DateTime($day."-".$month."-".$year);

            //NOTIFY 007
            if($expiration<$today && $user['accountStatus']!=='expired'){

                $text=$userName." Il tuo abbonamento è scaduto. Puoi rinnovarlo dal tuo profilo.";

                $message=new Message;

                $message->typology="007";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $sql = "UPDATE users SET
                        accountStatus='expired'
                        WHERE id='$userId'";
                                  
                $result=$this->data->sql($sql);
                
            }//END if
                
            $this->deleteExpiredEmail($userId, $userType);

        }//checkUser

        function checkAffiliate($user){

            $post=new Post;
            $search=new Search;
            
            $userId=$user['id'];
            $userType=$user['accountType'];
            $userGender;

            if($user['affiliateGender']=='male'){
                $userGender='M';
            }else{
                $userGender='F';
            }//END if

            //CHECK IF THERE IS ZIPCODE
            $fisCode=$search->getFisCode($user['affiliateZipCode']);
            $userName=$user['affiliateFirstName'];

            //NOTIFY 001
            if($fisCode==null){

                $text=$userName." non hai ancora comunicato un codice postale valido. Per farlo, scegli il comune da dati personali.";

                $message=new Message;

                $message->typology="001";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if
                
            }//END if

            //CHECK AGE
            $age=0;
            $checkAge=false;
            $validate=new Validate;
            $checkDay=$validate->validateDate($user['affiliateBirthDay'], 'd/m/Y');

            if($checkDay==true){
                $birthDay=explode('/',$user['affiliateBirthDay']);
                $day=$birthDay[0];
                $month=$birthDay[1];
                $year=$birthDay[2];
                $today=new DateTime(date("d-m-Y"));
                $birthDay=new DateTime($day."-".$month."-".$year);
                $birthCod=new DateTime($year."-".$month."-".$day);
                $diff=$birthDay->diff($today);
                $age=$diff->y;
                $checkAge=true;
            }//END if

            //NOTIFY 002
            if($age<=0 || $age>120 || $checkAge==false){

                $text="Ciao ".$userName." visionando la tua scheda ho notato che la tua data di nascita non è valida. Ti prego, controllala. Grazie.";

                $message=new Message;

                $message->typology="002";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $checkAge=false;
                
            }//END if

            //CHECK NAME
            $name=$user['affiliateFirstName'];
            $lastName=$user['affiliateLastName'];
            $checkName=true;

            //NOTIFY 003
            if(strlen($name)<=3 || strlen($lastName)<=3 ){

                $text="Ti suggerisco di indicare il tuo nome e cognome esatto. In questo modo sarà più semplice il controllo dei tuoi dati.";

                $message=new Message;

                $message->typology="003";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $checkName=false;
                
            }//END if

            //CHECK BIRTHPLACE
            $birthPlace=ucfirst($user['affiliateBirthPlace']);
            $birthPlace=str_replace(' ', '', $birthPlace);
            $townCode=$search->getTown($birthPlace);
            $checkTown=true;

            //NOTIFY 004
            if($townCode==null){

                $text="Il tuo comune di nascita non è corretto, verificalo e aggiorna il tuo profilo. Grazie ".$userName.".";

                $message=new Message;

                $message->typology="004";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $checkTown=false;
                
            }//END if

            //CODICE FISCALE CECKER
            $personalCodiceFiscale=str_replace(' ', '', $user['affiliateCodiceFiscale']);
            $personalCodiceFiscale=strtoupper($personalCodiceFiscale);

            if($checkName==true && $checkAge==true && $checkTown==true && $checkDay==true){

                $calc = new Calculator();
                $codiceFiscale=$calc->calcola($name, $lastName, $userGender, $birthCod, $townCode);
                $codiceFiscale=strtoupper($codiceFiscale);

                //NOTIFY 005
                if($personalCodiceFiscale!==$codiceFiscale){

                    $text="Il codice fiscale presente nella tua scheda non è corretto. Il tuo codice fiscale dovrebbe essere: <strong>".$codiceFiscale."</strong> ti consiglio di verificare ed aggiornare la tua scheda. A presto.";
    
                    $message=new Message;
    
                    $message->typology="005";
                    $message->recipientId=$userId;
                    $message->recipientType=$userType;
                    $message->message=$text;
    
                    $status=$search->checkNotify($message);
    
                    if($status==false){
                        $post->sendNotify($message);
                    }//END if
    
                    $checkTown=false;
                    
                }//END if


            }//END if

            //NOTIFY 006
            if(strlen($personalCodiceFiscale)<8 || strlen($personalCodiceFiscale)>16){

                $text="Il codice fiscale inserito non ha una lunghezza valida. Verifica ed inserisci il codice esatto.";

                $message=new Message;

                $message->typology="006";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $checkTown=false;
                
            }//END if

            //CHECK IF THERE IS EXPIRATION
            $exp = explode('/',$user['accountExpiration']);
            $day = $exp[0];
            $month=$exp[1];
            $year=$exp[2];
            $today=new DateTime(date("d-m-Y"));
            $expiration=new DateTime($day."-".$month."-".$year);

            //EXPIRED
            if($user['accountStatus']=='expired'){
                header("Refresh: 10; URL=https://www.salvamilavita.com/pricing.php");
            }//END if

            //NOTIFY 007
            if($expiration<$today && $user['accountStatus']!=='expired'){

                $text=$userName." Il tuo abbonamento è scaduto. Puoi rinnovarlo dal tuo profilo.";

                $message=new Message;

                $message->typology="007";
                $message->recipientId=$userId;
                $message->recipientType=$userType;
                $message->message=$text;

                $status=$search->checkNotify($message);

                if($status==false){
                    $post->sendNotify($message);
                }//END if

                $sql = "UPDATE affiliates SET
                        accountStatus='expired'
                        WHERE id='$userId'";
                                  
                $result=$this->data->sql($sql);
                
            }//END if


            $this->deleteExpiredEmail($userId, $userType);

        }//checkUser

        function deleteExpiredEmail($userId, $userType){

            $check=new Delete;
            $check->expiredEmail($userId, $userType);

        }//deleteExpiredEmail

    }//END Controller

    class Delete{

        function expiredEmail($userId, $userType){

            $this->data=new sqlConnect;
            $this->data->connect();

            $emailList=[];

            $sql = "SELECT * FROM messagges WHERE (recipientId='$userId' AND recipientType='$userType' AND messageRead='1') OR (senderId='$userId' AND senderType='$userType' AND messageRead='1')";
            
            $result=$this->data->sql($sql);

            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {

                    $emailList[]=$row;

                };//END while

            }//END if

            if(count($emailList)>0){

                $validate=new Validate;
                $idList=[];

                foreach($emailList as $email){

                    $checkDay=$validate->validateDate($email['messageExpiration'], 'd/m/Y');

                    if($checkDay==true){

                        $expiration=explode('/',$email['messageExpiration']);
                        $day=$expiration[0];
                        $month=$expiration[1];
                        $year=$expiration[2];
                        $today=new DateTime(date("d-m-Y"));
                        $expirationDay=new DateTime($day."-".$month."-".$year);

                        if($today>$expirationDay){
                            $idList[]=$email['id'];
                        }
                    }//END if

                }//END foreach

            }//END if

            if(count($idList)>0){

                $idString = join("', '", $idList);

                $sql = "DELETE FROM messagges WHERE id in ('$idString')";

                $result=$this->data->sql($sql);
                
            }//END if

            //echo(json_encode($idList));

        }//END checkExpired

    }//END Delete

    class Search{

        function getFisCode($zip){

            $cod=null;

            $this->data=new sqlConnect;
            $this->data->connect();

            $sql = "SELECT COD FROM zipcode WHERE CAP='$zip'";

            $result=$this->data->sql($sql);

            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {

                    $cod=$row['COD'];

                };//END while

            }//END if

            return $cod;


        }//END getFisCode

        function getTown($town){

            $cod=null;

            $this->data=new sqlConnect;
            $this->data->connect();

            $sql = "SELECT COD,Comune FROM zipcode WHERE Comune LIKE '%$town%'";

            $result=$this->data->sql($sql);

            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {

                    $cod=$row['COD'];

                };//END while

            }//END if

            return $cod;


        }//END getFisCode

        function checkNotify($message){

            $status=false;

            $this->data=new sqlConnect;
            $this->data->connect();

            $typology=$message->typology;
            $id=$message->recipientId;
            $type=$message->recipientType;

            $sql = "SELECT * FROM messagges WHERE (typology='$typology' AND recipientId='$id' AND recipientType='$type')";

            $result=$this->data->sql($sql);

            if ($result->num_rows > 0) {

                $status=true;

            }//END if

            return $status;


        }//END checkNotify

    }//END Controll

    class Validate{

        function validateDate($date, $format = 'Y-m-d'){
            $d = DateTime::createFromFormat($format, $date);
            // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
            return $d && $d->format($format) === $date;
        }

    }//END Validate

    class Calculator{

            private $mesi = ['A', 'B', 'C', 'D', 'E', 'H', 'L', 'M', 'P', 'R', 'S', 'T'];
            private $vocali = ['A', 'E', 'I', 'O', 'U'];
            private $consonanti = ['B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Y', 'Z'];
            private $numeri = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            private $alfabeto = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

            private $matriceCodiceControllo = ["01" => 1, "00" => 0, "11" => 0, "10" => 1, "21" => 5, "20" => 2, "31" => 7, "30" => 3, "41" => 9, "40" => 4, "51" => 13, "50" => 5, "61" => 15, "60" => 6, "71" => 17, "70" => 7, "81" => 19, "80" => 8, "91" => 21, "90" => 9, "101" => 1, "100" => 0, "111" => 0, "110" => 1, "121" => 5, "120" => 2, "131" => 7, "130" => 3, "141" => 9, "140" => 4, "151" => 13, "150" => 5, "161" => 15, "160" => 6, "171" => 17, "170" => 7, "181" => 19, "180" => 8, "191" => 21, "190" => 9, "201" => 2, "200" => 10, "211" => 4, "210" => 11, "221" => 18, "220" => 12, "231" => 20, "230" => 13, "241" => 11, "240" => 14, "251" => 3, "250" => 15, "261" => 6, "260" => 16, "271" => 8, "270" => 17, "281" => 12, "280" => 18, "291" => 14, "290" => 19, "301" => 16, "300" => 20, "311" => 10, "310" => 21, "321" => 22, "320" => 22, "331" => 25, "330" => 23, "341" => 24, "340" => 24, "351" => 23, "350" => 25];

            public function calcola($nome, $cognome, $sesso, \DateTime $dataNascita, $codiceComune){
                $codiceFiscale = '';
                $nome = $this->sanitizeString($nome);
                $cognome = $this->sanitizeString($cognome);
                $sesso = $this->sanitizeString($sesso);

                $giorno = $dataNascita->format('d');
                $mese = $dataNascita->format('n');
                $anno = $dataNascita->format('y');


                // inizia con il calcolo dei primi sei caratteri corrispondenti al nome e cognome
                $codiceFiscale = $this->calcolaCognome($cognome) . $this->calcolaNome($nome);

                // calcola i dati corrispondenti alla data di nascita
                if ($sesso == 'F') {
                    $giorno += 40;
                }
                $codiceFiscale .= $anno . $this->mesi[$mese - 1] . $giorno;

                // aggiunge il codice del comune
                $codiceFiscale .= $codiceComune;

                // e finalmente calcola il codice controllo
                $codiceControllo = 0;
                $alfanumerico = array_merge($this->numeri, $this->alfabeto);
                for ($i = 0; $i < 15; $i++) {
                    $codiceControllo += $this->matriceCodiceControllo[strval(array_search($codiceFiscale[$i], $alfanumerico)) . strval((($i + 1) % 2))];
                }
                $codiceFiscale .= $this->alfabeto[$codiceControllo % 26];

                return $codiceFiscale;
            }//END calcola

            private function calcolaNome($string){
                $i = 0;
                $res = '';
                $cons = '';
                while (strlen($cons) < 4 && ($i + 1 <= strlen($string))) {
                    if (array_search($string[$i], $this->consonanti) !== false) {
                        $cons .= $string[$i];
                    }
                    $i++;
                }

                if (strlen($cons) > 3) {
                    $res = $cons[0] . $cons[2] . $cons[3];
                    return $res;
                } else {
                    $res = $cons;
                }

                // Se non bastano prendo le vocali
                $i = 0;
                while (strlen($res) < 3 && ($i + 1 <= strlen($string))) {
                    if (array_search($string[$i], $this->vocali) !== false) {
                        $res .= $string[$i];
                    }
                    $i++;
                }
                $res .= "XXX";
                return substr($res, 0, 3);
            }//END calcolaNome

            private function calcolaCognome($string){
                $res = '';
                $i = 0;
                while(strlen($res) < 3 && ($i + 1 <= strlen($string))) {
                    if (array_search($string[$i], $this->consonanti) !== false) {
                        $res .= $string[$i];
                    }
                    $i++;
                }

                // Se non bastano le consonanti, prendo le vocali
                $i = 0;
                while(strlen($res) < 3 && ($i + 1 <= strlen($string))) {
                    if (array_search($string[$i], $this->vocali) !== false) {
                        $res .= $string[$i];
                    }
                    $i++;
                }

                $res .= "XXX";
                return substr($res, 0, 3);
            }//END calcolaCognome

            private function sanitizeString($string){
                $string = trim($string);
                $string = strtoupper(iconv('UTF-8', 'ASCII//TRANSLIT', $string));
                $string = str_replace(' ', '', $string);
                return $string;
            }//END sanitizeString

    }//END CALCOLA

?>



