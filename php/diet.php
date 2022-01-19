<?php

    session_start();

    include "config.php";
    include "post.php";


    class Diet{

        public $postedData;
        public $typoly;
        public $data;
        public $messageEvent;     

        function checkRequst(){

            $this->data=new ConnectData;
            $this->data->connect();

            $this->messageEvent = new TimeLine;

            if ($_SERVER["REQUEST_METHOD"] === "POST"){

                $this->postedData = $_POST['data'];

                $this->postedData = json_decode($this->postedData, false);

                $this->typology=$this->postedData->typology;
    
                switch ($this->typology) {
                    case "foodHint":
                        $this->foodHint();
                        break;   
                    case "foodInfo":
                        $this->foodInfo();
                        break;   
                    case "foodRecord":
                        $this->foodRecord();
                        break;

                    case "diaryRecord":
                        $this->diaryRecord();
                        break;
                    
                    case "deleteFood":
                        $this->deleteFood();
                        break;

                    default:
                       // code to be executed if n is different from all labels;
                }//END switch
        
            };//END if

        }//END checkRequst

        function foodRecord(){

             if($_SESSION["active"]===true && $this->postedData->data){

                $this->data=new sqlConnect;
                $this->data->connect();

                if($_SESSION["type"]=='affiliate'){
                    $userId=$_SESSION["idAffiliate"];
                };//END if

                if($_SESSION["type"]=='user'){
                    $userId=$_SESSION["id"];
                 };//END if

                 $data = $this->postedData->data;

                 $food = new stdClass;
                 $food->foodName = $data->food;
                 $food->foodGrams = $data->weight;
                 $food->userId = $userId;
                 $food->userType = $_SESSION["type"];

                 $food->foodDate = date("d/m/Y");
                 $food->foodHour = date("H:i:s");

                 $date = date("d-m-Y");
                 $expiration = date('d/m/Y', strtotime($date. ' + 365 days'));

                 $food->foodExpiration = $expiration;

                 $meal= new Food;
                 $info=$meal->searchByName($food->foodName);

                 if($info!=null){

                    $carboidrati = round(floatval($info['carboidrati'])*4,2);
                    $proteine = round(floatval($info['proteine'])*4,2);
                    $grassi = round(floatval($info['grassi'])*9,2);

                    $food->kilocal = round(floatval((($carboidrati)+($proteine)+($grassi))/100*$food->foodGrams),2);

                    $food->carboGrams = round(floatval($carboidrati/4/100*$food->foodGrams),2);
                    $food->protGrams = round(floatval($proteine/4/100*$food->foodGrams),2);
                    $food->fatGrams = round(floatval($grassi/9/100*$food->foodGrams),2);

                    if($proteine>=$carboidrati && $proteine>=$grassi){
                        $food->label = "fdSuccess";
                    }//IF

                    if($carboidrati>=$proteine && $carboidrati>=$grassi){
                        $food->label = "fdWarning";
                    }//IF

                    if($grassi>=$carboidrati && $grassi>=$proteine){
                        $food->label = "fdDanger";
                    }//IF

                    if($carboidrati>=$grassi && $grassi>=$proteine){
                        $food->label = "fdWarning";
                    }//IF

                    $meal->save($food);

                 }//IF


                 $response['response']=true;
                 $response['message']="ok";
                 $response['data']=$food;
                
            }else{

                $response['response']=false;
                $response['message']="Error";

            };//END if  

            echo(json_encode($response));

        }//foodRecord

        function foodHint(){

            $input=$this->postedData->input;

            if($_SESSION["active"]===true && $input!="" && $input!=" "){

                $response=array();
                $foods=array();

                $sql = "SELECT * FROM foods";

                $result=$this->data->sql($sql);

                $response=array();
    
                if ($result->num_rows > 0) {
    
                    while($row = $result->fetch_assoc()) {

                        $foods[]=$row;

                    };//END while

                };//END if

                if ($foods) {
    
                    $response['response']=true;
                    $response['message']="Foods loaded!";

                    $input = strtolower($input);

                    $hints=[];
               
                    foreach($foods as $food) {

                        $hint=new stdClass;

                        $carboidrati = round(floatval($food['carboidrati'])*4,2);
                        $proteine = round(floatval($food['proteine'])*4,2);
                        $grassi = round(floatval($food['grassi'])*9,2);

                        $hint->name=$food['nome'];
    
                        if($proteine>=$carboidrati && $proteine>=$grassi){
                            $hint->label = "fdSuccess";
                        }//IF
    
                        if($carboidrati>=$proteine && $carboidrati>=$grassi){
                            $hint->label = "fdWarning";
                        }//IF
    
                        if($grassi>=$carboidrati && $grassi>=$proteine){
                            $hint->label = "fdDanger";
                        }//IF
    
                        if($carboidrati>=$grassi && $grassi>=$proteine){
                            $hint->label = "fdWarning";
                        }//IF

                        $name=$hint->name;
                        $nameSl = strtolower($name);

                        $nameSl=trim($nameSl, " "); 
                        $input=trim($input, " "); 

                        if(strpos($nameSl, $input) !== false){
                            $hints[]=$hint;
                        }//END if

                    };//END foreach

                    $response['hints']=$hints;

                } else {
                       $response['response']=false;
                       $response['message']="Error loading profile!";
                }//END if

            }else{
                    $response['response']=false;
                    $response['message']="Session expored!";
            }//END if

                echo(json_encode($response));

        }//END foodHint

        function foodInfo(){

            $input=$this->postedData->input;

            if($_SESSION["active"]===true && $input!="" && $input!=" "){

                $response=array();

                $input = strtolower($input);

                $sql = "SELECT * FROM foods WHERE nome='$input'";

                $result=$this->data->sql($sql);

                $response=array();
    
                if ($result->num_rows > 0) {
    
                    while($row = $result->fetch_assoc()) {

                        $food=$row;

                    };//END while

                };//END if

                if ($food) {

                    $info = new stdClass;
                    $info->nome = $food['nome'];

                    $info->carboidrati = round($food['carboidrati'],2);
                    $info->proteine = round($food['proteine'],2);
                    $info->grassi = round($food['grassi'],2);
                    $info->acqua = round($food['acqua'],2);

                    $info->kcal = round(floatval(($info->carboidrati*4)+($info->proteine*4)+($info->grassi*9)),2);
                    $info->carCanvas = round(floatval($info->carboidrati*4/$info->kcal*100),2);
                    $info->proCanvas = round(floatval($info->proteine*4/$info->kcal*100),2);
                    $info->graCanvas = round(floatval($info->grassi*9/$info->kcal*100),2);

                    $response['response']=true;
                    $response['message']="Food loaded!";
                    $response['info']=$info;
    
                } else {
                       $response['response']=false;
                       $response['message']="Error loading profile!";
                }//END if

            }else{
                    $response['response']=false;
                    $response['message']="Session expored!";
            }//END if

                echo(json_encode($response));

        }//END foodInfo

        function deleteFood(){

            $foodId=$this->postedData->input;

            if($_SESSION["active"]===true && $foodId!="" && $foodId!=" "){

                $userId=$_SESSION["id"];

                $sql = "DELETE FROM food_diary WHERE id='$foodId' AND userId='$userId'";

                $result=$this->data->sql($sql);
    
                if ($result) {  
                   $this->diaryRecord();
                };//END if

            }//END if


        }//END deleteFood

        function diaryRecord(){

            if($_SESSION["active"]===true){

               $this->data=new sqlConnect;
               $this->data->connect();

               if($_SESSION["type"]=='user'){

                   $userId=$_SESSION["id"];

                   $search = new Food;
                   $diary = $search->getDiary($userId);

                   $meal=$diary->foods;
                   $overview=$diary->overview;

                   if($diary->status='active'){

                    //TODAY GRAPH
                    foreach($meal as $food){

                        $diary->kcalIngested = round(floatval($diary->kcalIngested + $food['kilocal']),2);
                        $diary->carboidratiIngested = round(floatval($diary->carboidratiIngested + $food['carboGrams']),2);
                        $diary->proteineIngested = round(floatval($diary->proteineIngested + $food['protGrams']),2);
                        $diary->fatIngested = round(floatval($diary->fatIngested + $food['fatGrams']),2);

                    }//foreach

                    $graph=[];
                    $graphResult=[];

                    $today = date("d-m-Y");
                    $day = str_replace('/', '-', $diary->start);

                    while($day!=$today){

                        $dayFormated = str_replace('-', '/', $day);

                        $graph[$dayFormated]=[];
                        $graph[$dayFormated]['kcalIngested'] = 0;
                        $graph[$dayFormated]['carboidratiIngested'] = 0;
                        $graph[$dayFormated]['proteineIngested'] = 0;
                        $graph[$dayFormated]['fatIngested'] = 0;
                        $graph[$dayFormated]['score'] = 0;

                        $day = date('d-m-Y',strtotime($day . "+1 days"));

                    }

                    $score=0;

                    //OVERVIEW GRAFH
                    foreach($overview as $day => $foods){

                        foreach($foods as $food){

                            $graph[$day]['kcalIngested'] = round(floatval($graph[$day]['kcalIngested'] + $food['kilocal']),2);
                            $graph[$day]['carboidratiIngested'] = round(floatval($graph[$day]['carboidratiIngested'] + $food['carboGrams']),2);
                            $graph[$day]['proteineIngested'] = round(floatval($graph[$day]['proteineIngested'] + $food['protGrams']),2);
                            $graph[$day]['fatIngested'] = round(floatval($graph[$day]['fatIngested'] + $food['fatGrams']),2);

                        }

                    }//foreach

                    $labelDay="";
                    $labelScore="";
                    $i=1;

                    foreach($graph as $day => $foods){

                        foreach($foods as $food){

                            $kcalCarb = round(floatval($graph[$day]['carboidratiIngested'])*4,2);
                            $kcalProt = round(floatval($graph[$day]['proteineIngested'])*4,2);
                            $kcalFat = round(floatval($graph[$day]['fatIngested'])*9,2);
    
                            if(($kcalFat>1) && ($kcalFat>$kcalCarb && $kcalFat>$kcalProt)){
                                $score = round(floatval($score-3),0);
                            }
    
                            if(($kcalCarb>1) && ($kcalCarb>$kcalFat && $kcalCarb>$kcalProt)){
                                $score = round(floatval($score+1),0);
                            }
    
                            if(($kcalProt>1) && ($kcalProt>$kcalFat && $kcalProt>$kcalCarb)){
                                $score = round(floatval($score+2),0);
                            }
    
                        }

                        //GRAPH DAY POINTS
                        $graphResult['label'][]=$day;
                        $graphResult['score'][]=$score;

                        $graph[$day]['score']=$score;

                    }//foreach

                    

                    $graphResult['label'] = array_reverse($graphResult['label']);
                    $graphResult['score'] = array_reverse($graphResult['score']);

                    $graphResult['label'] = array_slice($graphResult['label'],0,5);
                    $graphResult['score'] = array_slice($graphResult['score'],0,5);

                    $graphResult['label'] = array_reverse($graphResult['label']);
                    $graphResult['score'] = array_reverse($graphResult['score']);

                    $diary->overview=$graphResult;

                   }//if

                    $diary->kcalRemaining = round(floatval($diary->kcalDay - $diary->kcalIngested),2);
                    $diary->carboidratiRemaining = round(floatval($diary->carboidratiDay - $diary->carboidratiIngested),2);
                    $diary->proteineRemaining = round(floatval($diary->proteineDay - $diary->proteineIngested),2);
                    $diary->fatRemaining = round(floatval($diary->grassiDay - $diary->fatIngested),2);

                    $diary->kcalRemaining<=0?$diary->kcalRemaining=0:null;
                    $diary->carboidratiRemaining<=0?$diary->carboidratiRemaining=0:null;
                    $diary->proteineRemaining<=0?$diary->proteineRemaining=0:null;
                    $diary->fatRemaining<=0?$diary->fatRemaining=0:null;

                   if($diary){

                        $response['diary']=$diary;

                   }//if


                };//END if

                

                // $data = $this->postedData->data;

                // $food = new stdClass;
                // $food->foodName = $data->food;
                // $food->foodGrams = $data->weight;
                // $food->userId = $userId;
                // $food->userType = $_SESSION["type"];

                // $food->foodDate = date("d/m/Y");
                // $food->foodHour = date("H:i:s");

                // $date = date("d-m-Y");
                // $expiration = date('d/m/Y', strtotime($date. ' + 365 days'));

                // $food->foodExpiration = $expiration;

                

                // if($info!=null){

                //    $carboidrati = round($info['carboidrati'],2);
                //    $proteine = round($info['proteine'],2);
                //    $grassi = round($info['grassi'],2);

                //    $food->kilocal = round(floatval((($carboidrati*4)+($proteine*4)+($grassi*9))/100*$food->foodGrams),2);

                //    $food->carboGrams = round(floatval($carboidrati/100*$food->foodGrams),2);
                //    $food->protGrams = round(floatval($proteine/100*$food->foodGrams),2);
                //    $food->fatGrams = round(floatval($grassi/100*$food->foodGrams),2);

                //    $meal->save($food);

                // }//IF


                $response['response']=true;
                $response['message']="ok";
                
               
           }else{

               $response['response']=false;
               $response['message']="Error";

           };//END if  

           echo(json_encode($response));

        }//foodRecord


    }//Diet


    class Food{

        public $data;
        public $food;
        public $diet;
        public $meal;
        public $diary;
        public $overview;

        function searchByName($name){

            $this->data=new ConnectData;
            $this->data->connect();

            $this->food=null;

            if($name){

                $sql = "SELECT * FROM foods WHERE nome = '$name'";

                $result=$this->data->sql($sql);
    
                if ($result->num_rows > 0) {
    
                    while($row = $result->fetch_assoc()) {

                        $this->food=$row;

                    };//END while

                };//END if


            }//IF

            return  $this->food;

        }//byName

        function save($food){

            $this->data=new ConnectData;
            $this->data->connect();

            $this->food=null;

            if($food){

                $sql = "INSERT INTO food_diary (
                    userId ,
                    userType,
                    foodName,
                    foodGrams,
                    carboGrams,
                    protGrams,
                    fatGrams,
                    kilocal,
                    foodDate,
                    foodHour,
                    label,
                    foodExpiration)
             VALUES (
                    '$food->userId',
                    '$food->userType',
                    '$food->foodName',
                    '$food->foodGrams',
                    '$food->carboGrams',
                    '$food->protGrams',
                    '$food->fatGrams',
                    '$food->kilocal',
                    '$food->foodDate',
                    '$food->foodHour',
                    '$food->label',
                    '$food->foodExpiration')";


                $this->data->sql($sql);

            }//IF

        }//save

        function getDiary($id){

            $this->data=new ConnectData;
            $this->data->connect();

            $this->diet=null;

            $this->diary = new stdClass;
            $this->diary->start=null;
            $this->diary->kcalDay=1000;
            $this->diary->kcalIngested=0;
            $this->diary->kcalRemaining=0;
            $this->diary->carboidratiDay=1000;
            $this->diary->carboidratiIngested=0;
            $this->diary->carboidratiRemaining=0;
            $this->diary->proteineDay=1000;
            $this->diary->proteineIngested=0;
            $this->diary->proteineRemaining=0;
            $this->diary->grassiDay=1000;
            $this->diary->fatIngested=0;
            $this->diary->fatRemaining=0;
            $this->diary->status='expired';
            $this->diary->foods=[];
            $this->diary->overview=[];
            $this->diary->graph=[];

            if($id){

                $sql = "SELECT diet FROM users WHERE id='$id'";

                $result=$this->data->sql($sql);
    
                if ($result->num_rows > 0) {
    
                    while($row = $result->fetch_assoc()) {

                        if(strlen($row['diet'])>10){

                            $today = date("d/m/Y");

                            $diet = json_decode($row['diet']);

                            $this->diary->start=$diet->start;
                            $this->diary->kcalDay=$diet->chiloCal;
                            $this->diary->kcalIngested=0;
                            $this->diary->kcalRemaining=0;
                            $this->diary->carboidratiDay=round(floatval($diet->carboidrati),2);
                            $this->diary->carboidratiIngested=0;
                            $this->diary->carboidratiRemaining=0;
                            $this->diary->proteineDay=round(floatval($diet->proteine),2);
                            $this->diary->proteineIngested=0;
                            $this->diary->proteineRemaining=0;
                            $this->diary->grassiDay=round(floatval($diet->grassi),2);
                            $this->diary->fatIngested=0;
                            $this->diary->fatRemaining=0;
                            $this->diary->status=$diet->status;
                            $this->diary->foods=$this->getTodayMeals($id);
                            $this->diary->overview=$this->getMeals($id);

                            

                        }//if
                        
                    };//END while

                };//END if

            }//IF

            return  $this->diary;

        }//getDiary

        function getTodayMeals($id){

            $this->data=new ConnectData;
            $this->data->connect();

            $this->meal=[];

            if($id){

                $today = date("d/m/Y");

                $sql = "SELECT * FROM food_diary WHERE userId='$id' AND foodDate='$today'";

                $result=$this->data->sql($sql);
    
                if ($result->num_rows > 0) {
    
                    while($row = $result->fetch_assoc()) {

                        $food = $row;

                        $this->meal[]=$food;
                       
                    };//END while

                };//END if

            }//IF

            return  $this->meal;

        }//getTodayMeals

        function getMeals($id){

            $this->data=new ConnectData;
            $this->data->connect();

            $this->meal=[];

            if($id){

                $sql = "SELECT * FROM food_diary WHERE userId='$id'";

                $result=$this->data->sql($sql);
    
                if ($result->num_rows > 0) {
    
                    while($row = $result->fetch_assoc()) {

                        $food = $row;

                        $this->meal[$food['foodDate']][]=$food;
                       
                    };//END while

                };//END if

            }//IF

            return  $this->meal;

        }//getMeals

    }//FoodSearch


    $diet=new Diet;
    $diet->checkRequst();



 ?>   
