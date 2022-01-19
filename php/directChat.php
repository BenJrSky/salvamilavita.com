<?php

    session_start();

    include "timeLine.php";

    class DirectCheckUp{

        public $data;

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

        function getDeseas($symptoms){

            $originalSymptoms=$symptoms;
            $symptomsString = join("', '", $originalSymptoms);

            $folder=array();
            $folder=[];

            $diseasReport=array();
            $diseasReport['compatible']=[];
            $diseasReport['compatibleMatch']=[];
            $diseasReport['compatibleList']=[];
            $diseasReport['report']=false;
            $diseasReport['score']=[];

            $sql = "SELECT * FROM checkup WHERE symptom in ('$symptomsString')";

                $result=$this->data->sql($sql);
        
                if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()) {

                        $folder['list'][$row['disease']][]=$row['symptom'];
                        $folder['list'][$row['disease']]=array_values(array_unique($folder['list'][$row['disease']],SORT_REGULAR));
                        $diseasReport['diseaseList'][]=$row['disease'];

                    }//END while
            
                };//END if;

                //CHECK IF ALL SYMPTOMS ARE IN THE SAME DESEAS
                if(count($folder['list'])>0){

                    foreach ($folder['list'] as $disease => $symptom) {

                        //DISEASES WITH ALL SYMPTOMS
                        if((count(array_intersect($originalSymptoms, $symptom)) == count($originalSymptoms))){
                            $diseasReport['compatible'][$disease][]=$symptom;
                            $folder['diseases'][]=$disease;
                        };//END if

                    };//END foreach     

                };//END if

                //COLLECT ALL SYMPTOMS
                if(count($folder['diseases'])>0){

                    $folder['diseases']=array_values(array_unique($folder['diseases'],SORT_REGULAR));
                    $diseasesString = join("', '", $folder['diseases']);

                    $sql = "SELECT * FROM checkup WHERE disease in ('$diseasesString')";

                    $result=$this->data->sql($sql);
        
                    if ($result->num_rows > 0 && count($diseasReport['compatible'])>0) {

                        while($row = $result->fetch_assoc()) {

                            if (count($diseasReport['compatible'])>0) {

                                    $diseasReport['report']=true;

                                    foreach ($diseasReport['compatible'] as $disease => $symptom) {

                                        if($disease==$row['disease']){
                                            $diseasReport['compatible'][$disease][]=$row['symptom'];
                                            $diseasReport['compatible'][$disease]=array_values(array_unique($diseasReport['compatible'][$disease],SORT_REGULAR));
                                        };//END if

                                    };//END foreach   

                            };//END if          

                        }//END while

                        foreach ($diseasReport['compatible'] as $disease => $symptoms) {

                                $diseasReport['score'][$disease]['totalSymptoms']=count($symptoms);
                                $diseasReport['score'][$disease]['symptomsList']=$symptoms;
                                $diseasReport['score'][$disease]['countCompatible']=count(array_intersect($originalSymptoms, $symptoms));

                                $diseasReport['diseaseList'][]=$row['disease'];

                                foreach ($diseasReport['diseaseList'] as $item) {

                                    if($disease==$item){
                                        $diseasReport['compatibleList'][]=$item;
                                    };//END if

                                };//END foreach  

                                $diseasReport['compatibleList']=array_values(array_unique($diseasReport['compatibleList'],SORT_REGULAR));

                        };//END foreach  

                        //CLONING ARRAY FOR CHECKING THE SYMPTOMS MATCHES
                        $diseasReport['originalList']=$diseasReport['compatible'];

                        //CLEAN ARRAY TAKING OUT THE KNOWN SYMPTOMS
                        foreach ($diseasReport['compatible'] as $disease => $symptoms) {

                            if(count($diseasReport['compatible'][$disease])>1){
                                unset($diseasReport['compatible'][$disease][0]);
                            };//END if

                            foreach ($symptoms as $key => $symptom) {

                                if (in_array($symptom, $originalSymptoms)){
                                    unset($diseasReport['compatible'][$disease][$key]);
                                };//END if    

                            };//END foreach    

                        };//END foreach      

                        //CREATE ONE SINGLE ROW AND LIST OF SYMPTOMS
                        foreach ($diseasReport['compatible'] as $disease => $symptoms) {

                            foreach ($symptoms as $key => $symptom) {

                                $diseasReport['compatibleMatch'][$disease][]=$symptom;
                                $diseasReport['compatibleSymptoms'][]=$symptom;

                                $diseasReport['compatibleMatch']=array_values(array_unique($diseasReport['compatibleMatch'],SORT_REGULAR));

                            };//END foreach    


                        };//END foreach      

                    };//END if

                };//END if

                $diseasReport['compatibleMatch']=$diseasReport['compatible'];

                unset($diseasReport['compatible']);

                //$diseasReport=json_encode($diseasReport);

                if(count($diseasReport['compatibleMatch'])>0){
                    $_SESSION["checkup"]['checkFor']=$diseasReport['compatibleMatch'];
                };

                return $diseasReport;
                
        }//END getDeseas

        function includeSymptom(){

            $symptom=$_SESSION["checkup"]['currentSymptom'];

            $_SESSION["checkup"]['symptoms'][]=$symptom;
            $_SESSION["checkup"]['symptoms']=array_values(array_unique($_SESSION["checkup"]['symptoms'],SORT_REGULAR));
            
            $sessionDeseas=array();
            $sessionDeseas=$_SESSION["checkup"]['deseas'];
                           unset($_SESSION["checkup"]['deseas']);

            $list=array();
            $list=[];     
            
            //IF SYMPTOM ARE NOT IN SOME DESEAS DELETE DESEAS
            if(count($sessionDeseas['compatibleMatch'])>0){

                $id=null;

                foreach($sessionDeseas['compatibleMatch'] as $deseas => $symptoms){

                    foreach($sessionDeseas['originalList'] as $origDeseas => $origSymptoms){

                        if($deseas==$origDeseas){

                            $rap=count(array_intersect($_SESSION["checkup"]['symptoms'], $origSymptoms));
                            $cont=count($_SESSION["checkup"]['symptoms']);
                            $_SESSION["checkup"]["deseas"]["test"]="rap ".$rap." cont ".$cont;

                            //CHECK IF ALL SYMPTOMS ARE IN THE DESEAS
                            if((count(array_intersect($_SESSION["checkup"]['symptoms'],$origSymptoms)) == count($_SESSION["checkup"]['symptoms']))){
                                $_SESSION["checkup"]["deseas"]["complete"]=true;
                                $_SESSION["checkup"]["deseas"]["results"][]=$deseas;
                                $_SESSION["checkup"]["deseas"]["results"]=array_values(array_unique($_SESSION["checkup"]["deseas"]["results"],SORT_REGULAR));
                            };//END if

                        };//END if

                    };//END foreach     

                    if (!in_array($symptom, $symptoms)){
                        $id=$deseas;
                        unset($sessionDeseas['compatibleMatch'][$id]);
                    };//END if   

                };//END foreach

                $sessionDeseas['compatibleList']=[];

                foreach($sessionDeseas['compatibleMatch'] as $deseas => $symptoms){

                    $sessionDeseas['compatibleList'][]=array_search ($deseas, $sessionDeseas['compatibleMatch']);
                    $sessionDeseas['compatibleList']=array_values(array_unique($sessionDeseas['compatibleList'],SORT_REGULAR));
    
                };//END foreach

                $sessionDeseas['compatibleSymptoms']=[];

                foreach($sessionDeseas['compatibleMatch'] as $deseas => $symptoms){

                    foreach ($symptoms as $key => $symptom) {

                        if (!in_array($symptom, $_SESSION["checkup"]['symptoms'])){
                            if($symptom!==null && $symptom!=="" && $symptom!==" " && $symptom!==[]){
                                $sessionDeseas['compatibleSymptoms'][]=$symptom;
                            };//END if
                        };//END if   

                        $sessionDeseas['compatibleSymptoms']=array_values(array_unique($sessionDeseas['compatibleSymptoms'],SORT_REGULAR));

                    };//END foreach    

                };//END foreach    

            };//END if

            if(count($sessionDeseas['compatibleMatch'])==0){
                $_SESSION["checkup"]["deseas"]["complete"]=true;
            };//END if

            if(count($sessionDeseas['compatibleSymptoms'])<=1){
                $_SESSION["checkup"]["deseas"]["complete"]=true;
            };//END if

            if(strlen($sessionDeseas['compatibleSymptoms'][0])<3){
                $_SESSION["checkup"]["deseas"]["complete"]=true;
            };//END if

            $_SESSION["checkup"]['deseas']=$sessionDeseas;

            if(count($sessionDeseas)>0){
                $_SESSION["checkup"]['checkFor']=$sessionDeseas['compatibleMatch'];
            };

        }//END function

        function excludeSymptom(){

            $symptom=$_SESSION["checkup"]['currentSymptom'];

            $sessionDeseas=array();
            $sessionDeseas=$_SESSION["checkup"]['deseas'];
                     unset($_SESSION["checkup"]['deseas']);

            $list=array();
            $list=[];     
            
            //IF SYMPTOM ARE IN SOME DESEAS DELETE DESEAS
            if(count($sessionDeseas['compatibleMatch'])>0){

                $id=null;

                foreach($sessionDeseas['compatibleMatch'] as $deseas => $symptoms){

                    foreach($sessionDeseas['originalList'] as $origDeseas => $origSymptoms){

                        if($deseas==$origDeseas){

                            $rap=count(array_intersect($_SESSION["checkup"]['symptoms'], $origSymptoms));
                            $cont=count($_SESSION["checkup"]['symptoms']);
                            $_SESSION["checkup"]["deseas"]["test"]="rap ".$rap." cont ".$cont;

                            //CHECK IF ALL SYMPTOMS ARE IN THE DESEAS
                            if((count(array_intersect($_SESSION["checkup"]['symptoms'],$origSymptoms)) == count($_SESSION["checkup"]['symptoms']))){
                                $_SESSION["checkup"]["deseas"]["complete"]=true;
                                $_SESSION["checkup"]["deseas"]["results"][]=$deseas;
                                $_SESSION["checkup"]["deseas"]["results"]=array_values(array_unique($_SESSION["checkup"]["deseas"]["results"],SORT_REGULAR));
                            };//END if

                        };//END if

                    };//END foreach     

                    if (in_array($symptom, $symptoms)){
                        $id=$deseas;
                        unset($sessionDeseas['compatibleMatch'][$id]);
                    };//END if   

                };//END foreach
                       
                $sessionDeseas['compatibleList']=[];

                foreach($sessionDeseas['compatibleMatch'] as $deseas => $symptoms){

                    $sessionDeseas['compatibleList'][]=array_search ($deseas, $sessionDeseas['compatibleMatch']);
                    $sessionDeseas['compatibleList']=array_values(array_unique($sessionDeseas['compatibleList'],SORT_REGULAR));

                };//END foreach

                $sessionDeseas['compatibleSymptoms']=[];

                foreach($sessionDeseas['compatibleMatch'] as $deseas => $symptoms){

                    foreach ($symptoms as $key => $symptom) {

                        if($symptom!==null && $symptom!=="" && $symptom!==" " && $symptom!==[]){
                            $sessionDeseas['compatibleSymptoms'][]=$symptom;
                            $sessionDeseas['compatibleSymptoms']=array_values(array_unique($sessionDeseas['compatibleSymptoms'],SORT_REGULAR));
                        };//END if

                    };//END foreach    

                };//END foreach    

            };//END if

            if(count($sessionDeseas['compatibleMatch'])==0){
                $_SESSION["checkup"]["deseas"]["complete"]=true;
            };//END if

            if(count($sessionDeseas['compatibleSymptoms'])<=1){
                $_SESSION["checkup"]["deseas"]["complete"]=true;
            };//END if

            if(strlen($sessionDeseas['compatibleSymptoms'][0])<3){
                $_SESSION["checkup"]["deseas"]["complete"]=true;
            };//END if

            $_SESSION["checkup"]['deseas']=$sessionDeseas;

        }//END function

        function sieveSymptom(){

            $symptom=null;

            if(count($_SESSION["checkup"]['deseas']['compatibleSymptoms'])>0){

                $_SESSION["checkup"]["deseas"]["complete"]=false;
                $symptom=$_SESSION["checkup"]['deseas']['compatibleSymptoms'][0];

            };//END if

            if(count($_SESSION["checkup"]['deseas']['compatibleSymptoms'])<=1){

                $_SESSION["checkup"]["deseas"]["complete"]=true;
                $symptom=$_SESSION["checkup"]['deseas']['compatibleSymptoms'][0];

            };//END if

            return $symptom;

        }//END symptomsAnalyze

        function phraseBookChat(){

            $phrases=array();

            //GET HOUR
            if(date("H") > 21){
                $regards="buona notte";
            };//END if

            if(date("H") < 21){
                $regards="buona sera";
            };//END if

            if(date("H") < 18){
                $regards="buon pomeriggio";
            };//END if

            if(date("H") < 12){
                $regards="buon giorno";
            };//END if

            $phrases['presentation']['regards']['current']=$regards;

            $phrases['presentation']['regards']['phrases'][]="buon giorno";
            $phrases['presentation']['regards']['phrases'][]="buon pomeriggio";
            $phrases['presentation']['regards']['phrases'][]="buona sera";
            $phrases['presentation']['regards']['phrases'][]="buona notte";
            $phrases['presentation']['regards']['phrases'][]="buona giornata";

            $phrases['vocabulary']=[];
            $phrases['vocabulary']=array_merge($phrases['vocabulary'],$phrases['presentation']['regards']['phrases']);
            
            $hello=array();
            $hello[]="ciao";
            $hello[]="salve";
            $hello[]="benvenuto";

            $phrases['vocabulary']=array_merge($phrases['vocabulary'],$hello);

            //$phrases=json_decode(json_encode($phrases, JSON_FORCE_OBJECT));

            return $phrases;

        }//END phraseBookChat

        function directChat($message){

            $message=preg_replace("/\s+/", " ", $message);

            $this->data=new ConnectData;
            $this->data->connect();

            $saveEvent = new TimeLine;

            if($_SESSION["active"]===true){

                $idUser=$_SESSION["id"];

                $userData=null;

                $sql = "SELECT * FROM users WHERE id='$idUser'";

                $result=$this->data->sql($sql);

                $response=array();

                if ($result->num_rows > 0) {
    
                    $response['response']=true;
                    $response['message']="";

                    while($row = $result->fetch_assoc()) {

                        $username=$row['personalFirstName'];
                        $userData=$row;

                    }//END while
    
                } else {
                       $response['response']=false;
                       $response['message']="Error loading profile!";
                }//END if

                //GET ALL DESEASES AND SYMPTOMS
                $checkup=$this->getSymptoms();

                //GET PHRASES FOR CHAT
                $phrases=$this->phraseBookChat();

                if($_SESSION["checkup"]['active']===true){

                    $message = strtolower($message);

                    if ($message=='info'){
                        $_SESSION["checkup"]['phase']="000";
                        $_SESSION["checkup"]['replay']="020";
                    };//END if   

                    if ($message=='dieta'){
                        $_SESSION["checkup"]['phase']="000";
                        $_SESSION["checkup"]['replay']="021";
                    };//END if   

                    if ($message=='check'){
                        $_SESSION["checkup"]['phase']="001";
                        $_SESSION["checkup"]['replay']="001";
                    };//END if   

                    //PHASES 
                    if($_SESSION["checkup"]['phase']=="001"){

                        if(count($_SESSION["checkup"]['symptoms'])<=1){
                            $_SESSION["checkup"]['replay']="001";
                        };//END if

                    };//END if

                    if($_SESSION["checkup"]['phase']=="002"){

                        //ANSWERS LOGIC
                        if (in_array($message, $_SESSION["checkup"]['answers']['list']['true'])){
                            $_SESSION["checkup"]['replay']="002_true";
                        }else{
                            if (in_array($message, $_SESSION["checkup"]['answers']['list']['false'])){
                                $_SESSION["checkup"]['replay']="002_false";
                            }else{
                                $_SESSION["checkup"]['replay']="003";
                            };//END if   
                        };//END if   

                    };//END if

                    if($_SESSION["checkup"]['phase']=="003"){

                        //CHECK IF SYMTOM ARE IN THE LIST
                        if (in_array($message, $checkup['symptom'])){
                            $_SESSION["checkup"]['symptoms'][]=$message;
                            $_SESSION["checkup"]['symptoms']=array_values(array_unique($_SESSION["checkup"]['symptoms'],SORT_REGULAR));
                            $_SESSION["checkup"]['count']=0;
                        }else{
                            $_SESSION["checkup"]['count']=intval($_SESSION["checkup"]['count'])+1;
                        };//END if     

                        if(count($_SESSION["checkup"]['symptoms'])<=1){
                            $response['response']=false;
                        };//END if

                        if(count($_SESSION["checkup"]['symptoms'])>1){
                            $_SESSION["checkup"]['replay']="004";
                        };//END if

                        if(count($_SESSION["checkup"]['symptoms'])>2){
                            $_SESSION["checkup"]['replay']="005";
                        };//END if

                        if(intval($_SESSION["checkup"]['count'])>2){
                            $response['response']=true;
                            $_SESSION["checkup"]['replay']="009";
                        };//END if

                    };//END if

                    if($_SESSION["checkup"]['phase']=="004"){

                         //ANSWERS LOGIC
                         if (in_array($message, $_SESSION["checkup"]['answers']['list']['true'])){
                            $_SESSION["checkup"]['replay']="007_true";
                        }else{
                            if (in_array($message, $_SESSION["checkup"]['answers']['list']['false'])){
                                $_SESSION["checkup"]['replay']="007_false";
                            }else{
                                $_SESSION["checkup"]['replay']="006";
                            };//END if   
                        };//END if   

                    };//END if

                    if($_SESSION["checkup"]['phase']=="005"){

                        //CHECK IF SYMTOM ARE IN THE LIST
                        if (in_array($message, $checkup['symptom'])){
                            $_SESSION["checkup"]['symptoms'][]=$message;
                            $_SESSION["checkup"]['symptoms']=array_values(array_unique($_SESSION["checkup"]['symptoms'],SORT_REGULAR));
                            $_SESSION["checkup"]['count']=0;
                        }else{
                            $_SESSION["checkup"]['count']=intval($_SESSION["checkup"]['count'])+1;
                        };//END if    

                        if(count($_SESSION["checkup"]['symptoms'])<=3){
                            $response['response']=false;
                        };//END if

                        if(count($_SESSION["checkup"]['symptoms'])>3){
                            $_SESSION["checkup"]['replay']="008";
                        };//END if

                        if(intval($_SESSION["checkup"]['count'])>2){
                            $response['response']=true;
                            $_SESSION["checkup"]['replay']="010";
                        };//END if

                    };//END if

                    if($_SESSION["checkup"]['phase']=="006"){

                        //ANSWERS LOGIC
                        if (in_array($message, $_SESSION["checkup"]['answers']['list']['true'])){
                            $_SESSION["checkup"]['replay']="011_true";
                        }else{
                            if (in_array($message, $_SESSION["checkup"]['answers']['list']['false'])){
                                $_SESSION["checkup"]['replay']="011_false";
                            }else{
                                $_SESSION["checkup"]['replay']="012";
                            };//END if   
                        };//END if   

                    };//END if

                    if($_SESSION["checkup"]['phase']=="007"){

                        $getDeseas=array();
                        $getDeseas=$this->getDeseas($_SESSION["checkup"]['symptoms']); 
                        
                        $_SESSION["checkup"]['deseas']=$getDeseas;

                        if($getDeseas["report"]===true){
                            $_SESSION["checkup"]['replay']="014";
                        }else{

                            $_SESSION["checkup"]['replay']="013";
                         
                        };//END if

                    };//END if

                    if($_SESSION["checkup"]['phase']=="008"){

                        //ANSWERS LOGIC
                        if (in_array($message, $_SESSION["checkup"]['answers']['list']['true'])){
                            $_SESSION["checkup"]['replay']="015_true";
                        }else{
                            if (in_array($message, $_SESSION["checkup"]['answers']['list']['false'])){
                                $_SESSION["checkup"]['replay']="015_false";
                            }else{
                                $_SESSION["checkup"]['replay']="016";
                            };//END if   
                        };//END if   

                    };//END if

                    if($_SESSION["checkup"]['phase']=="009"){

                        if($_SESSION["checkup"]["deseas"]["complete"]==true){

                            if(count($_SESSION["checkup"]['deseas']['compatibleMatch'])>0){

                                $_SESSION["checkup"]['replay']="017";

                            }else{
                                $_SESSION["checkup"]['replay']="018";
                            };//END if

                        }else{
                                //ANSWERS LOGIC
                                 if (in_array($message, $_SESSION["checkup"]['answers']['list']['true'])){
                            
                                        $this->includeSymptom();
                                        $_SESSION["checkup"]['replay']="015_true";
                    
                                }else{
                                    if (in_array($message, $_SESSION["checkup"]['answers']['list']['false'])){
                                    
                                        $this->excludeSymptom();
                                        $_SESSION["checkup"]['replay']="015_true";

                                    }else{
                                        $_SESSION["checkup"]['replay']="016";
                                    };//END if   
                                 
                                };//END if   

                        };//END if
                        
                    };//END if

                    if($_SESSION["checkup"]['phase']=="010"){

                        //ANSWERS LOGIC
                        if (in_array($message, $_SESSION["checkup"]['answers']['list']['true'])){
                            
                            $symptoms = join(', ', $_SESSION["checkup"]['symptoms']);

                            $jsonEvent['type']="checkup";
                            $jsonEvent['message']="Il check-up di oggi ha dato esito negativo. I sintomi da te riportati sono: <b>".$symptoms."</b>.";
                            if(count($_SESSION["checkup"]['checkFor'])>0){

                                $checkFor="";

                                foreach($_SESSION["checkup"]["checkFor"] as $deseas =>$symptom){
                                    $checkFor=$checkFor." ".$deseas.",  ";
                                };//END foreach

                                $jsonEvent['message'].="Sebbene io non abbia trovato alcun riscontro preciso, credo sia opportuna una consulenza specialistica per le seguenti patologie: <b>".$checkFor."</b>. ";
                                $jsonEvent['message'].="Sceglierò, tra i medici presenti nel nostro elenco, quelli più vicini a te.";

                            };//IF

                            $jsonEvent=json_encode($jsonEvent);
                            $saveEvent->pushEvent($jsonEvent);

                            $response['refresh']=true;

                            $_SESSION["checkup"]['replay']="019_true";
                        }else{
                            $_SESSION["checkup"]['replay']="019_false";
                        };//END if   

                    };//END if

                    if($_SESSION["checkup"]['phase']=="011"){

                        //ANSWERS LOGIC
                        if (in_array($message, $_SESSION["checkup"]['answers']['list']['true'])){
                            
                            $resultDesease = "";
                            $symptoms = join(', ', $_SESSION["checkup"]['symptoms']);

                            foreach($_SESSION["checkup"]["deseas"]["compatibleMatch"] as $deseas =>$symptom){
                                $resultDesease=$resultDesease." ".$deseas." ";
                            };//END foreach

                            $jsonEvent['type']="checkup";
                            $jsonEvent['message']="Il check-up di oggi ha dato esito positivo. I sintomi da te riportati sono: <b>".$symptoms."</b> mentre le patologie riscontrate sono: <b>".$resultDesease."</b>.";

                            if(count($_SESSION["checkup"]['checkFor'])>0){

                                $checkFor="";

                                foreach($_SESSION["checkup"]["checkFor"] as $deseas =>$symptom){
                                    $checkFor=$checkFor." ".$deseas.",  ";
                                };//END foreach

                                $jsonEvent['message'].="Considerando i tuoi sintomi, ritengo necessaria la consulenza specialistica per le seguenti patologie: <b>".$checkFor."</b>. ";
                                $jsonEvent['message'].="Sceglierò, tra i medici presenti nel nostro elenco, quelli più vicini a te.";

                            };//IF

                            $jsonEvent=json_encode($jsonEvent);

                            $saveEvent->pushEvent($jsonEvent);

                            $response['refresh']=true;

                            $_SESSION["checkup"]['replay']="019_true";
                        }else{
                            $_SESSION["checkup"]['replay']="019_false";
                        };//END if   

                    };//END if

                    //INFO
                    if($_SESSION["checkup"]['phase']=="012"){

                        $choose=false;

                        if($message=='c'){
                            $choose=true;
                            $_SESSION["checkup"]['phase']="001";
                            $_SESSION["checkup"]['replay']="001";
                            $_SESSION["checkup"]['symptoms']=[];
                        };//IF

                        if($message=='d'){
                            $choose=true;
                            $_SESSION["checkup"]['replay']="021";
                            $_SESSION["checkup"]['symptoms']=[];
                        };//IF

                        if($choose==false){
                            $choose=true;
                            $_SESSION["checkup"]['phase']="001";
                            $_SESSION["checchoosekup"]['replay']="001";
                            $_SESSION["checkup"]['symptoms']=[];
                        };//IF

                        

                       

                    };//END if

                    //DIETA
                    if($_SESSION["checkup"]['phase']=="013"){

                        //ANSWERS LOGIC
                        if (in_array($message, $_SESSION["checkup"]['answers']['list']['true'])){
                            $_SESSION["checkup"]['replay']="022_true";
                        }else{
                            if (in_array($message, $_SESSION["checkup"]['answers']['list']['false'])){
                                $_SESSION["checkup"]['replay']="022_false";
                            }else{
                                $_SESSION["checkup"]['replay']="023";
                            };//END if   
                        };//END if   

                    };//END if

                    if($_SESSION["checkup"]['phase']=="014"){

                        //CHECK HEIGHT AND WEIGHT
                        $height=floatval($userData['styleHeight']);
                        $weight=floatval($userData['styleWeight']);
                        $gender=$userData['personalGender'];

                        $validate=new ValidateDirect;

                        $checkDay=$validate->validateDate($userData['personalBirthDay'], 'd/m/Y');
                        $checkAge=false;

                        if($checkDay==true){
                            $birthDay=explode('/',$userData['personalBirthDay']);
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

                        if($height==0 || $weight==0 || $height>230 || $weight>=400 || $checkAge==false || $age==0 || $age<18 || $age>120){

                            $_SESSION["checkup"]['replay']="025";

                        }else{

                            //CALCOLO IL PESO IDEALE
                            if($gender=='male'){
                                $idealWeight=floatval(($height-100)-(($height-150)/4));
                            }else{
                                $idealWeight=floatval(($height-100)-(($height-150)/2));
                            };//IF

                            //CALCOLO BMI
                            $bmi=round(floatval($weight/(($height/100)*($height/100))),2);

                            if($bmi<16.50){
                                $class="Sottopeso severo";
                                $label="aumento massa e peso";
                                $type="gain";
                            };//IF

                            if($bmi>16.50 && $bmi<18.40){
                                $class="Sottopeso";
                                $label="aumento massa e peso";
                                $type="gain";
                            };//IF

                            if($bmi>18.40 && $bmi<25.00){
                                $class="Normale";
                                $label="mantenimento (raggiungimento del peso ideale)";
                                $type="keep";
                            };//IF

                            if($bmi>25.00 && $bmi<30.00){
                                $class="Sovrapeso";
                                $label="perdita del peso";
                                $type="lose";
                            };//IF

                            if($bmi>30.00 && $bmi<35.00){
                                $class="Obesità di primo grado";
                                $label="perdita del peso";
                                $type="lose";
                            };//IF

                            if($bmi>35.00 && $bmi<40.00){
                                $class="Obesità di secondo grado";
                                $label="perdita del peso";
                                $type="lose";
                            };//IF

                            if($bmi>40.00){
                                $class="Obesità di terzo grado";
                                $label="perdita del peso";
                                $type="lose";
                            };//IF

                            //CONSUMO CALORICO BASALE
                            if($gender=='male'){
                                $bmr=round(floatval(1.5*(66.47+(13.75*$weight)+(5.003*$height)-(6.755*$age))),0);  
                            }else{
                                $bmr=round(floatval(1.5*(655.1+(9.563*$weight)+(1.85*$height)-(4.676*$age))),0);
                            };//IF

                            if($type=="lose"){
                                //GRAMMS TO LOSE PAR WEEK
                                $gramms=round(floatval($weight*10),0);
                                $gramms==0?$gramms=0.1:null;
                                //KG TO LOSE FOR REACHING THE NORMAL WEIGHT
                                $weightGoal=round(floatval($weight-$idealWeight),0);
                                //CHILOCAL PER DAY
                                $chiloCalDay=round(($bmr-($gramms/1000*7500/7)),0);
                                //TIMES IN WEEK
                                $weeks=round(floatval(1+(($weightGoal*1000)/$gramms)),0);
                                $month=round(floatval($weeks/4),1);
                                $goalType="perdere";
                            };//IF

                            if($type=="keep"){
                                if($weight>$idealWeight){
                                    $gramms=round(floatval($weight*10),0);
                                    $gramms==0?$gramms=0.1:null;
                                    $chiloCalDay=round(($bmr-($gramms/1000*7500/7)),0);
                                    $weightGoal=round(floatval($weight-$idealWeight),0);
                                    $weeks=round(floatval(1+(($weightGoal*1000)/$gramms)),0);
                                    $month=round(floatval($weeks/4),1);
                                    $goalType="perdere";
                                }else{
                                    $chiloCalDay=round(($bmr+($bmr*0.3)),0);
                                    $gramms=round(floatval($chiloCalDay*0.3*7/7.5),0);
                                    $gramms==0?$gramms=0.1:null;
                                    $weightGoal=round(floatval($idealWeight-$weight),0);
                                    $weeks=round(floatval(1+(($weightGoal*1000)/$gramms)),0);
                                    $month=round(floatval($weeks/4),1);
                                    $goalType="aumentare";
                                };//IF
                            };//IF

                            if($type=="gain"){
                                 //CHILOCAL PER DAY
                                 $chiloCalDay=round(($bmr+($bmr*0.3)),0);
                                 //GRAMMS TO GAIN PAR WEEK
                                 $gramms=round(floatval($chiloCalDay*7/7.5),0);
                                 $gramms==0?$gramms=0.1:null;
                                 //KG TO GAIN FOR REACHING THE NORMAL WEIGHT
                                 $weightGoal=round(floatval($idealWeight-$weight),0);
                                 //TIMES IN WEEK
                                 $weeks=round(floatval(1+(($weightGoal*1000)/$gramms)),0);
                                 $month=round(floatval($weeks/4),1);
                                 $goalType="aumentare";
                            };//IF

                            $_SESSION["checkup"]['diet']['data']['height']=$height;
                            $_SESSION["checkup"]['diet']['data']['weight']=$weight;
                            $_SESSION["checkup"]['diet']['data']['gender']=$gender;
                            $_SESSION["checkup"]['diet']['data']['age']=$age;
                            $_SESSION["checkup"]['diet']['data']['idealWeight']=$idealWeight;
                            $_SESSION["checkup"]['diet']['data']['bmi']=$bmi;
                            $_SESSION["checkup"]['diet']['data']['class']=$class;
                            $_SESSION["checkup"]['diet']['data']['type']=$type;
                            $_SESSION["checkup"]['diet']['data']['label']=$label;
                            $_SESSION["checkup"]['diet']['data']['bmr']=$bmr;
                            $_SESSION["checkup"]['diet']['data']['goal']['type']=$goalType;
                            $_SESSION["checkup"]['diet']['data']['goal']['value']=$gramms;
                            $_SESSION["checkup"]['diet']['data']['goal']['weeks']=$weeks;
                            $_SESSION["checkup"]['diet']['data']['goal']['month']=$month;
                            $_SESSION["checkup"]['diet']['data']['goal']['weightGoal']=$weightGoal;
                            $_SESSION["checkup"]['diet']['data']['goal']['chiloCalDay']=$chiloCalDay;

                        };//IF


                        $_SESSION["checkup"]['replay']="024";

                    };//END if

                    if($_SESSION["checkup"]['phase']=="015"){

                        //ANSWERS LOGIC
                        if (in_array($message, $_SESSION["checkup"]['answers']['list']['true'])){
                            $_SESSION["checkup"]['replay']="026_true";
                        }else{
                            if (in_array($message, $_SESSION["checkup"]['answers']['list']['false'])){
                                $_SESSION["checkup"]['replay']="026_false";
                            }else{
                                $_SESSION["checkup"]['replay']="027";
                            };//END if   
                        };//END if   

                    };//END if

                    if($_SESSION["checkup"]['phase']=="016"){

                        $height=$_SESSION["checkup"]['diet']['data']['height'];
                        $weight=$_SESSION["checkup"]['diet']['data']['weight'];
                        $age=$_SESSION["checkup"]['diet']['data']['age'];
                        $label=$_SESSION["checkup"]['diet']['data']['label'];
                        $class=$_SESSION["checkup"]['diet']['data']['class'];
                        $gender=$_SESSION["checkup"]['diet']['data']['gender'];
                        $idealWeight=$_SESSION["checkup"]['diet']['data']['idealWeight'];


                    };//END if

                    if($_SESSION["checkup"]['phase']=="017"){

                        $chiloCalDay=$_SESSION["checkup"]['diet']['data']['goal']['chiloCalDay'];

                        //CARB GRAMMS
                        $carboidrati=round(floatval($chiloCalDay*0.50/4),0);
                        $proteine=round(floatval($chiloCalDay*0.15/4),0);
                        $grassi=round(floatval($chiloCalDay*0.35/9),0);

                        $_SESSION["checkup"]['diet']['data']['distribution']['carboidrati']=$carboidrati;
                        $_SESSION["checkup"]['diet']['data']['distribution']['proteine']=$proteine;
                        $_SESSION["checkup"]['diet']['data']['distribution']['grassi']=$grassi;

                        $_SESSION["checkup"]['replay']="028";

                    };//END if





                    $symptoms = join(', ', $_SESSION["checkup"]['symptoms']);
                    $answers = join(', ', $_SESSION["checkup"]['answers']['list']);

                }else{

                    $_SESSION["checkup"]['active']=true;
                    $_SESSION["checkup"]['phase']="001";
                    $_SESSION["checkup"]['replay']="001";
                    $_SESSION["checkup"]['symptoms']=[];

                    if ($message=='info'){
                        $_SESSION["checkup"]['phase']="000";
                        $_SESSION["checkup"]['replay']="020";
                    };//END if   

                    if ($message=='dieta'){
                        $_SESSION["checkup"]['phase']="000";
                        $_SESSION["checkup"]['replay']="021";
                    };//END if   

                    if ($message=='check'){
                        $_SESSION["checkup"]['phase']="001";
                        $_SESSION["checkup"]['replay']="001";
                    };//END if   

                    $_SESSION["checkup"]['answers']['list']=[];
                    $_SESSION["checkup"]['answers']['list']['true'][]="si";
                    $_SESSION["checkup"]['answers']['list']['true'][]="certo";
                    $_SESSION["checkup"]['answers']['list']['true'][]="ok";
                    $_SESSION["checkup"]['answers']['list']['true'][]="yes";
                    $_SESSION["checkup"]['answers']['list']['true'][]="va bene";
                    $_SESSION["checkup"]['answers']['list']['true'][]="perfetto";
                    $_SESSION["checkup"]['answers']['list']['true'][]="forse";
                    $_SESSION["checkup"]['answers']['list']['true'][]="credo di si";
                    $_SESSION["checkup"]['answers']['list']['true'][]="sono d'accordo";
                    $_SESSION["checkup"]['answers']['list']['true'][]="salva";

                    $_SESSION["checkup"]['answers']['list']['false'][]="no";
                    $_SESSION["checkup"]['answers']['list']['false'][]="basta";
                    $_SESSION["checkup"]['answers']['list']['false'][]="fermati";
                    $_SESSION["checkup"]['answers']['list']['false'][]="credo di no";
                    $_SESSION["checkup"]['answers']['list']['false'][]="non lo so";
                    $_SESSION["checkup"]['answers']['list']['false'][]="non credo";
                    $_SESSION["checkup"]['answers']['list']['false'][]="non sono d'accordo";
                    $_SESSION["checkup"]['answers']['list']['false'][]="stop";

                };//END if 

                $sayHi=$phrases['presentation']['regards']['current'];

                //REPLY HANDLE
                $replay=$_SESSION["checkup"]['replay'];

                if($replay=="001"){
                    $responses=array();
                    $responses=[];
                    $responses[]=$sayHi." ".$username.". Sono la Dottoressa Hope, e sono qui per assisterti in questa sessione di Check-up. Vuoi Iniziare?";
                    $responses[]="Salve ".$username.", ".$sayHi.". Mi chiamo Hope e sono la Dottoressa virtuale pronta ad accompagnarti in questo Check-up. Iniziamo?";
                    $responses[]="Ciao ".$username.", ".$sayHi.". Sono la Dottoressa Hope, l'assistente virtuale per questo check-up. Vuoi iniziare?";
                    $responses[]=$sayHi." ".$username.". Il mio nome è Hope, assistente virtuale programmata per assisterti nel Check-up prevenzione. Iniziamo?";
                    $responses[]="Eccomi ".$sayHi." ".$username.". Sono la Dottoressa Hope, ed oggi ti assisterò nel check-up prevenzione. Vuoi iniziare il check-up?";
                    
                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="002";
                };//END if

                if($replay=="002_true"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Perfetto ".$username."! Inizia elencandomi i tuoi sintomi, inserisci correttamente almeno 3 sintomi...";
                    $responses[]="Molto bene ".$username.". Inserisci uno per uno i tuoi sintomi. Prova ad inserirne correttamente almeno 3...";
                    $responses[]="Iniziamo... Allora ".$username.". Descrivimi i tuoi sintomi attuali. Se riesci inserisci correttamente almeno 3 sintomi...";
                    $responses[]="Benissimo ".$username."! Per questo check-up, ho bisogno che tu inserisca correttamente almeno 3 sintomi...";
                    $responses[]="Ok allora iniziamo il check-up. ".$username."! Inserisci uno per uno i tuoi attuali sintomi. Digita correttamente almeno 3 sintomi...";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="003";
                };//END if

                if($replay=="002_false"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Va bene, allora ".$sayHi." ci vediamo presto.";
                    $responses[]="Come desideri ".$username.". ".$sayHi." a presto.";
                    $responses[]="Bene, sarà per la prossima volta. Arrivederci ".$username." e ".$sayHi.".";
                    $responses[]="Perfetto. Scrivimi quando vorrai iniziare il check-up. ".$sayHi." Arrivederci.";
                    $responses[]="Ok ".$username.". ".$sayHi.".";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['checkFor']=[];
                    $_SESSION["checkup"]['symptoms']=[];
                    $_SESSION["checkup"]['phase']="001";
                };//END if

                if($replay=="003"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Non ho capito, Prova a rispondermi semplicemente con: si oppure no.";
                    $responses[]=$username." Non ho capito, Digita semplicemente con: si o no.";
                    $responses[]="Scusa ".$username." Non capisco, scrivi semplicemente: si oppure no.";
                    $responses[]="Mi dispiace ".$username." Non ho compreso la tua risposta. Rispondi con: si oppure no.";
                    $responses[]="Sono spiacente ma non capisco. Rispondermi semplicemente digitando: si oppure no.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="002";
                };//END if

                if($replay=="004"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Benissimo, inserisci ancora qualche altro sintomo.";
                    $responses[]="Molto bene, inserisci qualche altro sintomo.";
                    $responses[]="Perfetto, inserisci un altro sintomo...";
                    $responses[]="Continua cosi e digita un ultimo sintomo.";
                    $responses[]="Ok, aggiungi un altro sintomo alla lista.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="003";
                };//END if

                if($replay=="005"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Vediamo, i tuoi sintomi sono: <b>".$symptoms."</b>. Hai ancora qualche altro sintomo?";
                    $responses[]="Allora, i sintomi da te inseriti sono: <b>".$symptoms."</b>. Hai altri sintomi da aggiungere?";
                    $responses[]="Perfetto. Diamo un occhiata ai tuoi sintomi: <b>".$symptoms."</b>. Vuoi aggiungere altri sintomi?";
                    $responses[]="Molto bene, i tuoi sintomi attuali sono: <b>".$symptoms."</b>. Vuoi aggiungere un altro sintomo?";
                    $responses[]="Benissimo, i tuoi sintomi sono: <b>".$symptoms."</b>. Hai altri sintomi in questo momento?";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="004";
                };//END ifd

                if($replay=="006"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Non ho capito, Prova a rispondermi semplicemente con: si oppure no.";
                    $responses[]=$username." Non ho capito, Digita semplicemente con: si o no.";
                    $responses[]="Scusa ".$username." Non capisco, scrivi semplicemente: si oppure no.";
                    $responses[]="Mi dispiace ".$username." Non ho compreso la tua risposta. Rispondi con: si oppure no.";
                    $responses[]="Sono spiacente ma non capisco. Rispondermi semplicemente digitando: si oppure no.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="004";
                };//END if

                if($replay=="007_false"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Va bene ".$username.", Confermi i sintomi e procediamo con il check-up?.";
                    $responses[]="Perfetto ".$username.", Confermi i sintomi e continuiamo con il check-up?.";
                    $responses[]="Molto bene ".$username.", Per continuare devi confermare i tuoi sintomi.";
                    $responses[]="Ok, allora ".$username.", Confermi i sintomi ed andiamo avanti con il check-up?.";
                    $responses[]="Benissimo ".$username.", Confermi i tuoi sintomi e continuiamo con questo check-up?.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="006";
                };//END if

                if($replay=="007_true"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Benissimo, continua ad elencarmi i sintomi.";
                    $responses[]="Va bene, continua ad aggiungere altri sintomi.";
                    $responses[]="Come preferisci. Allora aggiungi altri sintomi.";
                    $responses[]="Perfetto, digita ancora altri sintomi.";
                    $responses[]="Molto bene, continua ad elencare altri sintomi.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="005";
                };//END if

                if($replay=="008"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Va bene cosi. Ho abbastanza dati. I sintomi da te inseriti sono: ".$symptoms." Vuoi continuare il check-up?.";
                    $responses[]="Perfetto ho abbastanza dati per continuare. I sintomi da te inseriti sono: ".$symptoms." Vuoi procedere con il check-up?.";
                    $responses[]="Molto bene. Ho abbastanza informazioni. I tuoi attuali sintomi sono: ".$symptoms." Vuoi procedere con il check-up?.";
                    $responses[]="Bene, basta cosi. Ho sufficienti dati per continuare. I sintomi da te inseriti sono: ".$symptoms." Vuoi procedere con il check-up?.";
                    $responses[]="Per ora è abbastanza. I sintomi da te inseriti sono: ".$symptoms." Vuoi continuare il check-up?.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="006";
                };//END if

                if($replay=="009"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Perfavore ".$username.", inserisci i sintomi correttamente.";
                    $responses[]=$username.", Perfavore, digita correttamente i tuoi sintomi.";
                    $responses[]="Per piacere ".$username.", inserisci i sintomi in modo giusto.";
                    $responses[]=$username.", è necessario che tu inserisca correttamente i sintomi.";
                    $responses[]="Cortesemente ".$username.", inserisci i sintomi in modo appropriato.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="003";
                };//END if

                if($replay=="010"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Sono spiacente ".$username.", non conosco questi sintomi. Perfavore inserisci altri sintomi.";
                    $responses[]="Mi spiace ".$username.", non conosco questi sintomi. Per piacere inserisci altri sintomi.";
                    $responses[]="Sono desolata ".$username.", non conosco questi sintomi. Per piacere inseriscine degli altri.";
                    $responses[]="Scusami ".$username.", non conosco questi sintomi. Per cortesia inserisci altri sintomi.";
                    $responses[]="Mi dispiace ".$username.", non conosco questi sintomi. Per piacere inseriscine degli altri.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="005";
                };//END if

                if($replay=="011_false"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Come preferisci. Contattami non appena vorrai proseguire con il check-up. ".$sayHi. " ".$username;
                    $responses[]="Come desideri. Scrivimi non appena vorrai continuare questo check-up. ".$sayHi. " ".$username;
                    $responses[]="Va bene ".$username." Contattami quando vorrai effettuare un check-up. ".$sayHi.".";
                    $responses[]="Ok ".$username." Sarò a tua disposizione quando vorrai proseguire il tuo check-up. ".$sayHi.".";
                    $responses[]="Perfetto. Aspetterò che tu mi scriva per un nuovo check-up. ".$sayHi. " ".$username;

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['checkFor']=[];
                    $_SESSION["checkup"]['symptoms']=[];
                    $_SESSION["checkup"]['phase']="001";
                };//END if

                if($replay=="011_true"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Vediamo... lasciami dare un occhiata alla tua scheda sanitatria. Se necessario dovrò farti qualche domanda riguardo il tuo stato di salute. Avvisami non appena senti di poter continuare.";
                    $responses[]="Lasciami pensare. Potrebbe essere necessario porti ulteriori quesiti. Scrivimi <b>ok</b> non appena senti di voler continuare.";
                    $responses[]="Allora... Dammi qualche secondo per visonare la tua cartella. In seguito, potrei farti alcune domande sul tuo stato di salute. Scrivimi <b>ok</b> per proseguire.";
                    $responses[]="Perfetto. Ora visionerò la tua scheda e valuterò l'ipotesi di porti ulteriori domande riguardanti i tuoi sintomi. Scrivi <b>ok</b> per continuare.";
                    $responses[]="Molto bene. Ora elaborerò i tuoi dati. Scrivi <b>ok</b> non appena senti di voler proseguire con il check-up.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="007";
                };//END if

                if($replay=="012"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Non ho capito, Prova a rispondermi semplicemente con: si oppure no.";
                    $responses[]=$username." Non ho capito, Digita semplicemente con: si o no.";
                    $responses[]="Scusa ".$username." Non capisco, scrivi semplicemente: si oppure no.";
                    $responses[]="Mi dispiace ".$username." Non ho compreso la tua risposta. Rispondi con: si oppure no.";
                    $responses[]="Sono spiacente ma non capisco. Rispondermi semplicemente digitando: si oppure no.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="006";
                };//END if

                if($replay=="013"){

                    if(count($_SESSION["checkup"]['checkFor'])>0){
                        $integration="";
                        $checkFor="";
                        foreach($_SESSION["checkup"]["checkFor"] as $deseas =>$symptom){
                            $checkFor=$checkFor." ".$deseas.",  ";
                        };//END foreach
                        $integration.="Considerato quando detto fin'ora, ritengo necessaria una consulenza specialistica per le seguenti patologie: <b>".$checkFor."</b></br>";
                        $integration.="Sceglierò, tra i medici presenti nel nostro elenco, quelli più vicini a te li comunicherò al più presto.";
                    };//IF

                    $responses=array();
                    $responses=[];
                    $responses[]="Eccomi ".$username.", analizzando i tuoi sintomi, non ho riscontrato analogie con importanti patologie. Sebbene sintomi quali ".$symptoms.", siano da tenere sotto controllo, non sono presenti segnali esplici. ".$integration." ".$sayHi." ".$username." e a presto.";
                    $responses[]="Allora ".$username.", valutando attentamente sintomi quali: ".$symptoms.", è necessaria la presenza di altri segnali per poterli accumunare a certe patologie. ".$integration.". Ciao ".$username." e a presto.";
                    $responses[]="Bene ".$username.", Non ho trovato malattie importanti analoghe ai sintomi da te riportati. Comunque sintomi quali: ".$symptoms.", sono da tenere sotto controllo. ".$integration." " .$sayHi." ".$username.".";
                    $responses[]="Perfetto ".$username.", Abbiamo concluso il check-up. I tuoi sintomi non sono riconducibili a particolari patologie. ".$integration." " .$sayHi." ".$username.".";
                    $responses[]="Abbiamo terminato. Allora ".$username.", il tuo check-up ha dato esito negativo. I tuoi sintomi non sono riconducibili a particolari patologie. ".$integration." ".$sayHi." ".$username.".";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['checkFor']=[];
                    $_SESSION["checkup"]['symptoms']=[];
                    $_SESSION["checkup"]['phase']="001";
                };//END if

                if($replay=="014"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Studiando i tuoi sintomi, ho trovato analogie con alcune patologie. Pertanto è necessario approfondire il check-up con ulteriori domande. Siamo pronti?";
                    $responses[]="Ho valutato la tua scheda ed ho rilevato analogie con alcune patologie. Credo sia opportuno approfondire il check-up con altre domande. Vuoi continuare?";
                    $responses[]="I tuoi sintomi sono comuni ad alcune patologie. Però per poterle accomunare ho bisogno di ulteriori informazioni. Vuoi procedere con il check-up?";
                    $responses[]="Valutando i sintomi da te provati, credo sia necessario porti ulteriori quesiti per comprendere meglio il tuo stato di salute. Procediamo il check-up?";
                    $responses[]="Allora, i tuoi sintomi sono comuni a diverse patologie. Pertanto dovrò farti ulteriori domande per poter capire meglio il tuo stato di salute. Continuiamo il check-up?";
                
                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="008";
                };//END if

                if($replay=="015_false"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Come preferisci. Contattami non appena vorrai proseguire con il check-up. ".$sayHi. " ".$username;
                    $responses[]="Come desideri. Scrivimi non appena vorrai continuare con il check-up. ".$sayHi. " ".$username;
                    $responses[]="Molto bene. Allora contattami qualora vorrai affettuare il check-up. ".$sayHi. " ".$username;
                    $responses[]="Va bene. Scrivimi non appena vorrai effettuare un nuovo check-up prevenzione. ".$sayHi. " ".$username;
                    $responses[]="Capisco. Allora contattami quando vorrai affettuare un check-up. ".$sayHi. " ".$username;

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['checkFor']=[];
                    $_SESSION["checkup"]['symptoms']=[];
                    $_SESSION["checkup"]['phase']="001";
                };//END if

                if($replay=="015_true"){

                    $_SESSION["checkup"]['currentSymptom']=$this->sieveSymptom();

                    if($_SESSION["checkup"]["deseas"]["complete"]!=true){

                        $responses=array();
                        $responses=[];
                        $responses[]="Bene, continuiamo, dimmi se è presente: <b>".$_SESSION["checkup"]['currentSymptom']."</b>?.";
                        $responses[]="Continuiamo, allora è presente: <b>".$_SESSION["checkup"]['currentSymptom']."</b>?.";
                        $responses[]="Tra i tuoi sintomi, c'è anche: <b>".$_SESSION["checkup"]['currentSymptom']."</b>?.";
                        $responses[]="Hai la sensazione di avere: <b>".$_SESSION["checkup"]['currentSymptom']."</b>?.";
                        $responses[]="In questo momento senti: <b>".$_SESSION["checkup"]['currentSymptom']."</b>?.";
                        
                        $key=array_rand($responses,1);
                        $doctorMessage=$responses[$key];
                        $_SESSION["checkup"]["phase"]="009";
                        
                    }else{

                        if(count($_SESSION["checkup"]['deseas']['compatibleMatch'])>0){
                            $replay="017";
                        }else{
                            $replay="018";
                        };//END if

                    };//END if

                };//END if

                if($replay=="016"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Non ho capito, Prova a rispondermi semplicemente con: si oppure no.";
                    $responses[]=$username." Non ho capito, Digita semplicemente con: si o no.";
                    $responses[]="Scusa ".$username." Non capisco, scrivi semplicemente: si oppure no.";
                    $responses[]="Mi dispiace ".$username." Non ho compreso la tua risposta. Rispondi con: si oppure no.";
                    $responses[]="Sono spiacente ma non capisco. Rispondermi semplicemente digitando: si oppure no.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="009";
                };//END if

                if($replay=="017"){

                    if(count($_SESSION["checkup"]['checkFor'])>0){
                        $integration="";
                        $checkFor="";
                        foreach($_SESSION["checkup"]["checkFor"] as $deseas =>$symptom){
                            $checkFor=$checkFor." ".$deseas.",  ";
                        };//END foreach
                        $integration.="Considerato quando da te riportato, ritengo comunque necessaria una consulenza specialistica per le seguenti patologie: <b>".$checkFor."</b>. ";
                        $integration.="Sceglierò, tra i medici presenti nel nostro elenco, quelli più vicini a te li comunicherò al più presto.";
                    };//IF

                    $resultString = "";

                    foreach($_SESSION["checkup"]["deseas"]["compatibleMatch"] as $deseas =>$symptom){
                        $resultString=$resultString." <b>".$deseas."</b> ";
                    };//END foreach

                    $responses=array();
                    $responses=[];
                    $responses[]=$username." abbiamo terminato, i sintomi da te accusati risultano positivi alle seguenti patologie: ".$resultString.". ".$integration." Se desideri posso salvare questo risultato nel tuo diario. Scrivi semplicemente <b>salva</b>.";
                    $responses[]=$username." il tuo check-up prevenzione è terminato, i dati raccolti lasciano pensare che tu soffra delle seguenti patologie: ".$resultString.". ".$integration." Se ritieni opportuno, posso salvare questo risultato nel tuo diario. Scrivi semplicemente <b>salva</b>.";
                    $responses[]=$username." abbiamo completato il check-up, i sintomi da te riportati sono tipici delle seguenti patologie: ".$resultString.". ".$integration." Se desideri posso conservare questo risultato nel tuo diario. Scrivi semplicemente <b>salva</b>.";
                    $responses[]=$username." il tuo check-up è concluso. I sintomi raccolti sono riconducibili alle seguenti patologie: ".$resultString.". ".$integration." Se desideri posso conservare questo risultato nel tuo diario. Scrivi semplicemente <b>salva</b>.";
                    $responses[]=$username." questo check-up termina qui. Dai dati posso evincere che i tuoi sintomi appartengono alle seguenti patologie: ".$resultString.". ".$integration." Se ritieni opportuno, posso tenere questo risultato nel tuo diario. Scrivi semplicemente <b>salva</b>.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="011";
                };//END if

                if($replay=="018"){

                    if(count($_SESSION["checkup"]['checkFor'])>0){
                        $integration="";
                        $checkFor="";
                        foreach($_SESSION["checkup"]["checkFor"] as $deseas =>$symptom){
                            $checkFor=$checkFor." ".$deseas.",  ";
                        };//END foreach
                        $integration.="Considerato quando detto fin'ora, ritengo necessaria una consulenza specialistica per le seguenti patologie: <b>".$checkFor."</b>.</br>";
                        $integration.="Sceglierò, tra i medici presenti nel nostro elenco, quelli più vicini a te li comunicherò al più presto.";
                    };//IF

                    $responses=array();
                    $responses=[];
                    $responses[]=$username." Abbiamo terminato. Sebbene sintomi quali: <b>".$symptoms."</b> necessitano di maggior approfondimento, non ho riscontrato similitudini con patologie importanti. ".$integration.". Se desideri, posso comunque salvare i sintomi nel tuo diario. Per farlo scrivi semplicemente <b>salva</b>.";
                    $responses[]="Check-up concluso! Allora ".$username." questa sessione di check-up prevenzione è terminata. Non ho riscontrato segnali che facciano pensare a particolari patologie. Ritengo opportuno tenere sotto controllo sintomi quali: <b>".$symptoms."</b>. ".$integration." Se desideri, posso comunque salvare questi dati nel tuo diario. Per farlo scrivi semplicemente <b>salva</b>.";
                    $responses[]=$username." la sessione di check-up prevenzione è competata. Non ho trovato analogie tra i tuoi sintomi attuali e particolari patologie. Credo comunque che sia il caso di non trascurare sintomi quali: <b>".$symptoms."</b>. ".$integration." Se desideri, posso comunque tenere in memoria questi risultati nel tuo diario. Per farlo scrivi semplicemente <b>salva</b>.";
                    $responses[]="Il tuo Check-up è concluso! ".$username." Esaminando sintomi quali: <b>".$symptoms."</b>, con  non ho trovato nulla che possa ricondurre a particolari patologie. ".$integration." Se desideri, posso comunque salvare questi dati nel tuo diario. Per farlo scrivi semplicemente <b>salva</b>.";
                    $responses[]=$username." questa sessione di check-up prevenzione è terminata. Non abbiamo riscontrato similitudini tra i tuoi sintomi attuali e particolari patologie. Penso comunque che sia opportuno effettuare ulteriori controlli in quanto sintomi quali: <b>".$symptoms."</b> non devono essere trascurati. ".$integration." Se sei d'accordo, posso tenere in memoria questi dati nel tuo diario. Per farlo scrivi semplicemente <b>salva</b>.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="010";
                };//END if

                if($replay=="019_true"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Perfetto, ho salvato tutto. A presto ".$sayHi.".";
                    $responses[]="Molto bene, ho salvato tutto. ".$sayHi.".";
                    $responses[]="Ecco, ho salvato i Dati. ".$sayHi.".";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['checkFor']=[];
                    $_SESSION["checkup"]['symptoms']=[];
                    $_SESSION["checkup"]['phase']="001";
                };//END if

                if($replay=="019_false"){
                    $responses=array();
                    $responses=[];
                    $responses[]="A presto, ".$username.", ".$sayHi.".";
                    $responses[]=$username." allora è tutto, ".$sayHi.".";
                    $responses[]="Ci sentiamo presto, ".$sayHi.".";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]=[];
                    $_SESSION["checkup"]=[];
                    $_SESSION["checkup"]['phase']="001";
                };//END if

                //INFO
                if($replay=="020"){

                    $services="";
                    $services.="<ul>";
                    $services.="<li><b>check</b>: Check-up Prevenzione;</li>";
                    $services.="<li><b>dieta</b>: Check-up Dieta;</li>";
                    $services.="</ul>";

                    $responses=array();
                    $responses=[];
                    $responses[]="Allora ".$username." i servizi disponibili sono: ".$services." Digita il codice corrispondente per iniziare.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="012";
                };//END if

                if($replay=="021"){
                    $responses=array();
                    $responses=[];
                    $responses[]="<b>DIETA PERSONALIZZATA</b></br> ".$sayHi." ".$username.". Sono la Dottoressa Hope, e sono qui per assisterti nella creazione della tua dieta. Vuoi Iniziare?";
                    $responses[]="<b>DIETA PERSONALIZZATA</b></br> Salve ".$username.", ".$sayHi.". Mi chiamo Hope e sono la Dottoressa virtuale pronta ad accompagnarti nella realizzazione della tua dieta. Iniziamo?";
                    $responses[]="<b>DIETA PERSONALIZZATA</b></br> Ciao ".$username.", ".$sayHi.". Sono la Dottoressa Hope, l'assistente virtuale per questa sessione di dieta personalizzata. Vuoi iniziare?";
                    $responses[]="<b>DIETA PERSONALIZZATA</b></br> ".$sayHi." ".$username.". Il mio nome è Hope, assistente virtuale programmata per assisterti nella stesura della dieta personalizzata. Iniziamo?";
                    $responses[]="<b>DIETA PERSONALIZZATA</b></br> Eccomi ".$sayHi." ".$username.". Sono la Dottoressa Hope, ed oggi ti assisterò nella creazione della tua dieta. Vuoi iniziare?";
                    
                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="013";
                };//END if

                if($replay=="022_true"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Perfetto inizierò controllando la tua scheda sanitaria. Scrivi <b>ok</b> per proseguire.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="014";
                };//END if

                if($replay=="022_false"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Va bene, allora ".$sayHi." ci vediamo presto.";
                    $responses[]="Come desideri ".$username.". ".$sayHi." a presto.";
                    $responses[]="Bene, sarà per la prossima volta. Arrivederci ".$username." e ".$sayHi.".";
                    $responses[]="Perfetto. Scrivimi quando vorrai iniziare la dieta. ".$sayHi." Arrivederci.";
                    $responses[]="Ok ".$username.". ".$sayHi.".";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['checkFor']=[];
                    $_SESSION["checkup"]['symptoms']=[];
                    $_SESSION["checkup"]['active']=false;
                };//END if

                if($replay=="023"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Non ho capito, Prova a rispondermi semplicemente con: si oppure no.";
                    $responses[]=$username." Non ho capito, Digita semplicemente con: si o no.";
                    $responses[]="Scusa ".$username." Non capisco, scrivi semplicemente: si oppure no.";
                    $responses[]="Mi dispiace ".$username." Non ho compreso la tua risposta. Rispondi con: si oppure no.";
                    $responses[]="Sono spiacente ma non capisco. Rispondermi semplicemente digitando: si oppure no.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="013";
                };//END if

                if($replay=="024"){

                    //CHECK HEIGHT AND WEIGHT
                    $height=$_SESSION["checkup"]['diet']['data']['height'];
                    $weight=$_SESSION["checkup"]['diet']['data']['weight'];
                    $age=$_SESSION["checkup"]['diet']['data']['age'];
                    $label=$_SESSION["checkup"]['diet']['data']['label'];
                    $class=$_SESSION["checkup"]['diet']['data']['class'];
                    $idealWeight=$_SESSION["checkup"]['diet']['data']['idealWeight'];

                    $responses=array();
                    $responses=[];
                    $idealWeight=$_SESSION["checkup"]['diet']['data']['idealWeight'];
                    $responses[]="Allora, dai dati evinti nella tua scheda sanitaria, ho potuto constatare che: la tua età è di <b>".$age." anni</b>, la tua altezza è di <b>".$height." cm</b>, mentre il tuo peso è di <b>".$weight." kg</b>.</br> Pertanto calcolando il tuo BMI (sitema di valutazione peso), ho ottenuto un valore pari a <b>".$bmi."</b>, il quale suggerisce che il tuo stato di peso attuale è <b>".$class."</b>.</br>Il tuo peso ideale, dai calcoli effettuati è pari a: <b>".$idealWeight." Kg</b>.</br>Il piano dietetico che ti suggerisco pertanto è quello relativo a: <b>".$label."</b>.</br>Se sei d'accordo procediamo.";
                    $responses[]=$username." , dai dati raccolti nel tuo profilo sanitario, ho notato che: la tua età è di <b>".$age." anni</b>, la tua altezza è di <b>".$height." cm</b>, mentre il tuo peso è di <b>".$weight." kg</b>.</br> Pertanto calcolando il tuo BMI (sitema di valutazione peso), ho ottenuto un valore pari a <b>".$bmi."</b>, il quale suggerisce che il tuo stato di peso attuale è <b>".$class."</b>.</br>Il tuo peso ideale, dai calcoli effettuati è pari a: <b>".$idealWeight." Kg</b>.</br>Il piano dietetico che ti suggerisco pertanto è quello relativo a: <b>".$label."</b>.</br>Se sei d'accordo andiamo avanti.";
                    $responses[]="Ecco, ".$username." dal tuo profilo ho recuperato i seguenti dati evinti, età: <b>".$age." anni</b>, altezza: <b>".$height." cm</b> e peso <b>".$weight." kg</b>.</br> Pertanto calcolando il tuo BMI (sitema di valutazione peso), ho ottenuto un valore pari a <b>".$bmi."</b>, il quale suggerisce che il tuo stato di peso attuale è <b>".$class."</b>.</br>Il tuo peso ideale, dai calcoli effettuati è pari a: <b>".$idealWeight." Kg</b>.</br>Il piano dietetico che ti suggerisco pertanto è quello relativo a: <b>".$label."</b>.</br>Se sei d'accordo procediamo con la stesura della dieta.";
                    $responses[]=$username." , ho recuperato la tua scheda sanitaria ed ho preso nota dei tuoi dati notando che: la tua età è di <b>".$age." anni</b>, la tua altezza è di <b>".$height." cm</b>, mentre il tuo peso è di <b>".$weight." kg</b>.</br> Pertanto calcolando il tuo BMI (sitema di valutazione peso), ho ottenuto un valore pari a <b>".$bmi."</b>, il quale suggerisce che il tuo stato di peso attuale è <b>".$class."</b>.</br>Il tuo peso ideale, dai calcoli effettuati è pari a: <b>".$idealWeight." Kg</b>.</br>Il piano dietetico che ti suggerisco è quello relativo a: <b>".$label."</b>.</br>Se sei d'accordo andiamo avanti.";
                    $responses[]="Bene, dai dati raccolti sul tuo profilo, ho evinto che: la tua età è di <b>".$age." anni</b>, la tua altezza è di <b>".$height." cm</b>, mentre il tuo peso è di <b>".$weight." kg</b>.</br> Pertanto calcolando il tuo BMI (sitema di valutazione peso), ho ottenuto un valore pari a <b>".$bmi."</b>, il quale suggerisce che il tuo stato di peso attuale è <b>".$class."</b>.</br>Il tuo peso ideale, dai calcoli effettuati è pari a: <b>".$idealWeight." Kg</b>.</br>Il piano dietetico che ti suggerisco pertanto è quello relativo a: <b>".$label."</b>.</br>Se sei d'accordo continuiamo.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="015";
                };//END if

                if($replay=="025"){
                    $responses=array();
                    $responses=[];
                    $responses[]="I dati inseriti nella tua scheda sanitaria non sono corretti. </br> Controlla altezza e peso, dopodichè registrali nella tua scheda e ricontattami per procedere con la dieta. </br> ".$sayHi." ci vediamo presto.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['checkFor']=[];
                    $_SESSION["checkup"]['symptoms']=[];
                    $_SESSION["checkup"]['active']=false;
                };//END if

                if($replay=="026_true"){

                   //CHECK HEIGHT AND WEIGHT
                   $height=$_SESSION["checkup"]['diet']['data']['height'];
                   $weight=$_SESSION["checkup"]['diet']['data']['weight'];
                   $age=$_SESSION["checkup"]['diet']['data']['age'];
                   $label=$_SESSION["checkup"]['diet']['data']['label'];
                   $bmr=$_SESSION["checkup"]['diet']['data']['bmr'];
                   $goalType=$_SESSION["checkup"]['diet']['data']['goal']['type'];
                   $gramms=$_SESSION["checkup"]['diet']['data']['goal']['value'];
                   $weeks=$_SESSION["checkup"]['diet']['data']['goal']['weeks'];
                   $month=$_SESSION["checkup"]['diet']['data']['goal']['month'];
                   $weightGoal=$_SESSION["checkup"]['diet']['data']['goal']['weightGoal'];
                   $idealWeight=$_SESSION["checkup"]['diet']['data']['idealWeight'];
                   $chiloCalDay=$_SESSION["checkup"]['diet']['data']['goal']['chiloCalDay'];

                   $type=$_SESSION["checkup"]['diet']['data']['type'];

                   $weeks<=1?$labelWeek="settimana":$labelWeek="settimane";
                   $month==1?$labelMonth="mese":$labelMonth="mesi";

                   $responses=array();
                   $responses=[];
                   $responses[]=$username.", il tuo peso ideale è <b>".$idealWeight." Kg</b>, pertanto l'obbiettivo di questa dieta sarà farti <b>".$goalType." peso</b>.</br> Considerata la tua scheda sanitaria, ritengo che per il raggiungimento del risultato, sia opportuno ".$goalType." <b>".$gramms." grammi</b> a settimana."."</br>Nel corso di questo programma farò in modo di farti ".$goalType." <b>".$weightGoal." Kg</b>.</br>Il tempo stimato è di <b>".$weeks." ".$labelWeek."</b> (".$month." ".$labelMonth.").</br>Concedimi qualche minuto per preparare il tuo piano.</br>Premmi un tasto per continuare...";

                   $key=array_rand($responses,1);
                   $doctorMessage=$responses[$key];
                   $_SESSION["checkup"]['phase']="017";

                };//END if

                if($replay=="026_false"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Va bene, allora ".$sayHi." ci vediamo presto.";
                    $responses[]="Come desideri ".$username.". ".$sayHi." a presto.";
                    $responses[]="Bene, sarà per la prossima volta. Arrivederci ".$username." e ".$sayHi.".";
                    $responses[]="Perfetto. Scrivimi quando vorrai iniziare la dieta. ".$sayHi." Arrivederci.";
                    $responses[]="Ok ".$username.". ".$sayHi.".";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['checkFor']=[];
                    $_SESSION["checkup"]['symptoms']=[];
                    $_SESSION["checkup"]['active']=false;
                };//END if

                if($replay=="027"){
                    $responses=array();
                    $responses=[];
                    $responses[]="Non ho capito, Prova a rispondermi semplicemente con: si oppure no.";
                    $responses[]=$username." Non ho capito, Digita semplicemente con: si o no.";
                    $responses[]="Scusa ".$username." Non capisco, scrivi semplicemente: si oppure no.";
                    $responses[]="Mi dispiace ".$username." Non ho compreso la tua risposta. Rispondi con: si oppure no.";
                    $responses[]="Sono spiacente ma non capisco. Rispondermi semplicemente digitando: si oppure no.";

                    $key=array_rand($responses,1);
                    $doctorMessage=$responses[$key];
                    $_SESSION["checkup"]['phase']="014";
                };//END if

                if($replay=="028"){

                   //CHECK HEIGHT AND WEIGHT
                   $height=$_SESSION["checkup"]['diet']['data']['height'];
                   $weight=$_SESSION["checkup"]['diet']['data']['weight'];
                   $age=$_SESSION["checkup"]['diet']['data']['age'];
                   $label=$_SESSION["checkup"]['diet']['data']['label'];
                   $bmr=$_SESSION["checkup"]['diet']['data']['bmr'];
                   $class=$_SESSION["checkup"]['diet']['data']['class'];
                   $goalType=$_SESSION["checkup"]['diet']['data']['goal']['type'];
                   $gramms=$_SESSION["checkup"]['diet']['data']['goal']['value'];
                   $weeks=$_SESSION["checkup"]['diet']['data']['goal']['weeks'];
                   $month=$_SESSION["checkup"]['diet']['data']['goal']['month'];
                   $weightGoal=$_SESSION["checkup"]['diet']['data']['goal']['weightGoal'];
                   $idealWeight=$_SESSION["checkup"]['diet']['data']['idealWeight'];
                   $chiloCalDay=$_SESSION["checkup"]['diet']['data']['goal']['chiloCalDay'];
                   $carboidrati=$_SESSION["checkup"]['diet']['data']['distribution']['carboidrati'];
                   $proteine=$_SESSION["checkup"]['diet']['data']['distribution']['proteine'];
                   $grassi=$_SESSION["checkup"]['diet']['data']['distribution']['grassi'];

                   $type=$_SESSION["checkup"]['diet']['data']['type'];

                   $weeks<=1?$labelWeek="settimana":$labelWeek="settimane";
                   $month==1?$labelMonth="mese":$labelMonth="mesi";

                   $responses=array();
                   $responses=[];
                   $responses[]="Molto bene ".$username.", per questa dieta, ho elaborato il tuo fabisogno calorico gioranliero nella misura di: </br><b>".$chiloCalDay." Kcal</b> giornaliere.</br></br> Al giorno, dovrai assumere i macronutrineti principali nelle seguenti proporzioni:</br>- Carboidrati <b>".$carboidrati."g</b>;</br>- Proteine <b>".$proteine."g</b>;</br>- Grassi <b>".$grassi."g</b>;</br></br>Tieni a mente che per ".$goalType." ".$weightGoal."Kg ti serviranno ".$weeks." ".$labelWeek." e per questo ho attivato il tuo <b>Diario alimentare</b> con la quale potrai facilmente monitorare la tua dieta.</br>Inizia subito col accedere al tuo diario e buona dieta.</br>Ci sentiamo presto.";

                   $key=array_rand($responses,1);
                   $doctorMessage=$responses[$key];
                   $_SESSION["checkup"]['phase']="017";

                   $jsonEvent['type']="dieta";
                   $jsonEvent['message']="Oggi hai iniziato la tua dieta.</br>";
                   $jsonEvent['message'].="I tuoi parametri attuali sono:</br>";
                   $jsonEvent['message'].="- altezza <b>".$height." cm</b>; </br>";
                   $jsonEvent['message'].="- peso <b>".$weight." Kg</b>; </br>";
                   $jsonEvent['message'].="- età <b>".$age." anni</b>; </br>";
                   $jsonEvent['message'].="- stato <b>".$class."</b>; </br>";
                   $jsonEvent['message'].="- bmr <b>".$bmr." Kcal/giorno</b>; </br></br>";
                   $jsonEvent['message'].="Il programma dietetico reltivo a ".$label." durerà :<b>".$weeks." ".$labelWeek."</b> (".$month." ".$labelMonth."), durante il quale dovrai <b>".$goalType." ".$weightGoal." Kg</b>.</br>";
                   $jsonEvent['message'].="Il tuo peso futuro sarà di <b>".$idealWeight." Kg</b>;</br>";
                   $jsonEvent['message'].="Durante la dieta dovrai assumere ogni giorno:</br>";
                   $jsonEvent['message'].="- Calorie <b>".$chiloCalDay." Kcal/giorno</b>, Di cui:</br>";
                   $jsonEvent['message'].="- Carboidrati <b>".$carboidrati."g</b>;</br>";
                   $jsonEvent['message'].="- Proteine <b>".$proteine."g</b>;</br>";
                   $jsonEvent['message'].="- Grassi <b>".$grassi."g</b>;</br></br>";
                   $jsonEvent['message'].="Il <b>diario alimentare</b> è ora attivo, utilizzalo per monitorare la tua dieta.</br>";
                   $jsonEvent['message'].="Buona fortuna!";

                   $dieta=[];
                   $dieta['status']='active';
                   $dieta['start']=date("d/m/Y");
                   $dieta['height']=$height;
                   $dieta['currentWeight']=$weight;
                   $dieta['idealWeight']=$idealWeight;
                   $dieta['age']=$age;
                   $dieta['label']=$label;
                   $dieta['class']=$class;
                   $dieta['bmr']=$bmr;
                   $dieta['chiloCal']=$chiloCalDay;
                   $dieta['weightGoal']=$weightGoal;
                   $dieta['chiloCal']=$chiloCalDay;
                   $dieta['gramms']=$gramms;
                   $dieta['carboidrati']=$carboidrati;
                   $dieta['proteine']=$proteine;
                   $dieta['grassi']=$grassi;
                   $dieta['weeks']=$weeks;
                   $dieta['labelWeek']=$labelWeek;
                   $dieta['month']=$month;
                   $dieta['labelMonth']=$labelMonth;
                   $dieta['type']=$type;

                   $dieta=json_encode($dieta);

                   $setDiet = "UPDATE users SET diet='$dieta'
                               WHERE id='$idUser'";

                    $this->data->sql($setDiet);
                   
                   $jsonEvent=json_encode($jsonEvent);
                   $saveEvent->pushEvent($jsonEvent);
                   $response['refresh']=true;

                   $_SESSION["checkup"]=[];
                   $_SESSION["checkup"]=[];
                   $_SESSION["checkup"]['phase']="001";

                };//END if


                $response['message']=$doctorMessage;

            }else{
                    $response['response']=false;
                    $response['message']="Session expired!";
            }//END if

            echo(json_encode($response));

        }//END directChat

    };//END directCheckUp

    class ValidateDirect{

        function validateDate($date, $format = 'Y-m-d'){
            $d = DateTime::createFromFormat($format, $date);
            // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
            return $d && $d->format($format) === $date;
        }

    }//END Validate

?>



