<?php

    session_start();

    class TimeLine{

        public $data;

        function getEvents(){

            if($_SESSION["active"]===true){

                $this->data=new sqlConnect;
                $this->data->connect();

                $userType=$_SESSION["type"];

                if($userType=='affiliate'){
                    $userId=$_SESSION["idAffiliate"];
                };//END if

                if($userType=='user'){
                    $userId=$_SESSION["id"];
                };//END if

                $timeline=array();
                $timeline=[];

                $data=array();
                $data=[];

                $sql = "SELECT * FROM timeline WHERE userId='$userId' AND userType='$userType' ORDER BY id DESC LIMIT 200";
    
                $result=$this->data->sql($sql);
                
                if($result->num_rows > 0){
                    
                    while($row = $result->fetch_assoc()) {
                        $data[]=$row;
                    }//END while
    
                }//END if

                foreach($data as $day){

                    $timeline['events'][$day['eventDate']][]=$day;

                }//END foreach
    
                return json_encode($timeline);

            };//END if    

        }//END pushAffiliateEvent

        function pushEvent($jsonEvent){

            if($_SESSION["active"]===true){

                $jsonEvent=json_decode($jsonEvent);

                $this->data=new sqlConnect;
                $this->data->connect();

                $userType=$_SESSION["type"];

                if($userType=='affiliate'){
                    $userId=$_SESSION["idAffiliate"];
                };//END if

                if($userType=='user'){
                    $userId=$_SESSION["id"];
                };//END if

                $eventDate=date("d/m/Y");
                $eventHour=date("H:i:s");
                $eventType=$jsonEvent->type;
                $eventMessage=$jsonEvent->message;
                
                $sql = "INSERT INTO timeline (
                                userId,
                                userType,
                                eventDate,
                                eventHour,
                                eventType,
                                eventMessage)
                        VALUES (
                                '$userId',
                                '$userType', 
                                '$eventDate', 
                                '$eventHour',
                                '$eventType',
                                '$eventMessage')";

                    $result=$this->data->sql($sql);

            };//END if    

        }//END pushEvent

    };//END TimeLine

?>



