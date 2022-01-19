<?php

    session_start();

    require_once "timeLine.php";


    class Post{

        public $data;

        function sanitaze($string){

            $value = $string;
            $value = str_replace("'", '"', $value); 
            $value = strip_tags($value);
            $value=htmlentities($value, ENT_QUOTES, 'UTF-8');
            
            return $value;

        }//END sanitaze

        function public($post){

            if($_SESSION["active"]===true){

                $this->data=new sqlConnect;
                $this->data->connect();

                $date=date("d/m/Y");
                $time=date("H:i:s");
                $title=$this->sanitaze($post->title);
                $text=$this->sanitaze($post->text);
                $picture=$post->picture;
                $userType= $_SESSION["type"];

                if(strlen($picture)<50){
                    $picture=null;
                };//END if

                if($_SESSION["type"]=='affiliate'){
                    $userId=$_SESSION["idAffiliate"];
                };//END if

                if($_SESSION["type"]=='user'){
                    $userId=$_SESSION["id"];
                };//END if

                $sql = "INSERT INTO postes (
                    picture,
                    postDate,
                    postHour,
                    postUpdate,
                    hourUpdate,
                    userId,
                    userType,
                    postTitle,
                    postMessage)
             VALUES (
                    '$picture', 
                    '$date',
                    '$time',
                    '$date',
                    '$time',
                    '$userId',
                    '$userType',
                    '$title',
                    '$text')";

            $response=array();

            $result=$this->data->sql($sql);

            if($result===true){
                $response['response']=true;
                $response['message']="Post uploaded";
            }else{
                $response['response']=false;
                $response['message']="Error adding post";
            }//END if

            echo(json_encode($response));
                
            };//END if  

        }//END 

        function get($post){

            $data=array();
            $element=array();
            $idList=array();
            $idListPost=array();

            $users=array();
            $users=[];

            $affiliates=array();
            $affiliates=[];

            $idList=[];
            $idListPost=[];

            $rowComments=array();
            $rowComments=[];

            $currentComment=array();
            $currentComment=[];

            $this->data=new sqlConnect;
            $this->data->connect();


            if($post->filter!=null || $post->filter!=""){

                $sql = "SELECT * FROM postes WHERE postMessage LIKE '%$post->filter%' 
                OR postTitle LIKE '%$post->filter%' 
                OR postDate LIKE '%$post->filter%'
                OR postUpdate LIKE '%$post->filter%' 
                ORDER BY postDate DESC, postHour DESC LIMIT 200";

            }else{

                $sql = "SELECT * FROM postes ORDER BY postUpdate DESC, hourUpdate DESC LIMIT 200";

            };//END if


            $result=$this->data->sql($sql);

            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {

                    $element['postTitle']=$row['postTitle'];
                    $element['postMessage']=$row['postMessage'];
                    $element['userType']=$row['userType'];
                    $element['userId']=$row['userId'];
                    $element['postHour']=$row['hourUpdate'];
                    $element['postDate']=$row['postUpdate'];
                    $element['postId']=$row['id'];
                    $element['userInfo']['fullName']=null;
                    $element['userInfo']['picture']=null;
                    $element['userInfo']['gender']=null;
                    $element['comments']=[];

                    if(strlen($row['picture'])>5){
                        $element['picture']=$row['picture'];
                    }else{
                        $element['picture']=null;
                    };
                    
                    $data['post'][$row['postDate']][]=$element;

                    if($element['userType']=='affiliate'){
                        $idList['affiliate'][]=$element['userId'];
                    };//END IF

                    if($element['userType']=='user'){
                        $idList['user'][]=$element['userId'];
                    };//END IF

                    $idListPost[]=$row['id'];

                }//END while

                if(count($idListPost)>0){

                    $stringPost=join("', '", $idListPost);

                    //GET COMMENTS
                    $sql = "SELECT * FROM comments WHERE postId in ('$stringPost') ORDER BY postDate DESC, postHour DESC";

                    $result=$this->data->sql($sql);

                    if ($result->num_rows > 0) {

                        while($row = $result->fetch_assoc()) {

                            $currentComment['postId']=$row['postId'];
                            $currentComment['userInfo']['userId']=$row['userId'];
                            $currentComment['userInfo']['userType']=$row['userType'];
                            $currentComment['userInfo']['fullName']=null;
                            $currentComment['userInfo']['picture']=null;
                            $currentComment['userInfo']['gender']=null;
                            $currentComment['postDate']=$row['postDate'];
                            $currentComment['postHour']=$row['postHour'];
                            $currentComment['postMessage']=$row['postMessage'];

                            $rowComments[]=$currentComment;

                            if($row['userType']=='affiliate'){
                                $idList['affiliate'][]=$row['userId'];
                            };//END IF
        
                            if($row['userType']=='user'){
                                $idList['user'][]=$row['userId'];
                            };//END IF
        
                            $idListPost[]=$row['id'];
                        
                        }//END while
                        
                    }//END if

                }//END if    

                if(count($idList['user'])>0){
                    $idList['user']=array_values(array_unique($idList['user'],SORT_REGULAR));
                };//END if

                if(count($idList['affiliate'])>0){
                    $idList['affiliate']=array_values(array_unique($idList['affiliate'],SORT_REGULAR));
                };//END if

                if(count($idList['user'])>0){

                    $usersId=join("', '", $idList['user']);

                    //GET USERS
                    $sql = "SELECT * FROM users WHERE id in ('$usersId')";

                    $result=$this->data->sql($sql);

                    if ($result->num_rows > 0) {

                        while($row = $result->fetch_assoc()) {

                            $privacySetting=json_decode($row['privacySetting'], false);

                            if($privacySetting->privacyName=='false'){
                                $row['personalFirstName']=str_replace(".","",$row['personalFirstName']);
                                $row['personalLastName']=str_replace(".","",$row['personalLastName']);
                                $row['personalFirstName']=str_replace(" ","",$row['personalFirstName']);
                                $row['personalLastName']=str_replace(" ","",$row['personalLastName']);
                                $row['personalFirstName']=substr($row['personalFirstName'],0,1).".";
                                $row['personalLastName']=substr($row['personalLastName'],0,1).".";
                            };//END if

                            $row['fullName']=$row['personalFirstName']." ".$row['personalLastName'];

                            if(strlen( $row['profilePhotoLink'])<5){
                                $row['profilePhotoLink']=null;
                            };    

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

                            $users[]=$row;

                        }//END while
                        
                    }//END if

                };//END IF

                if(count($idList['affiliate'])>0){

                    $affiliatesId=join("', '", $idList['affiliate']);

                    //GET AFFILIATES
                    $sql = "SELECT * FROM affiliates WHERE id in ('$affiliatesId')";

                    $result=$this->data->sql($sql);

                    if ($result->num_rows > 0) {

                        while($row = $result->fetch_assoc()) {

                            if(strlen( $row['affiliatePhotoLink'])<5){
                                $row['affiliatePhotoLink']=null;
                            };    

                            $row['fullName']=$row['affiliateFirstName']." ".$row['affiliateLastName'];
                            $affiliates[]=$row;
                        }//END while
                        
                    }//END if

                };//END IF

                $postList=array();
                $postList=[];

                foreach ($data['post'] as $key => $days) {

                    foreach ($days as $post) {
                        
                        if($post['userType']=='affiliate'){

                            foreach ($affiliates as $affiliate) {

                                if($affiliate['id']==$post['userId']){

                                    $post['userInfo']['fullName']=$affiliate['fullName'];
                                    $post['userInfo']['picture']=$affiliate['affiliatePhotoLink'];
                                    $post['userInfo']['gender']=$affiliate['affiliateGender'];

                                    $postList['post'][$post['postDate']][]=$post;

                                }//END if

                            }//END foreach

                        }//END if
                        
                        if($post['userType']=='user'){

                            foreach ($users as $user) {

                                if($user['id']==$post['userId']){

                                    $post['userInfo']['fullName']=$user['fullName'];
                                    $post['userInfo']['picture']=$user['profilePhotoLink'];
                                    $post['userInfo']['gender']=$user['personalGender'];

                                    $postList['post'][$post['postDate']][]=$post;

                                }//END if

                            }//END foreach

                        }//END if

                     }//END foreach

                }//END foreach

                $completeComments=array();
                $completeComments=[];

                $newComment=array();
                $newComment=[];

                foreach($rowComments as $comment){

                    if($comment['userInfo']['userType']=='affiliate'){

                        foreach ($affiliates as $affiliate) {

                            if($affiliate['id']==$comment['userInfo']['userId']){

                                $newComment=$comment;

                                $newComment['userInfo']['fullName']=$affiliate['fullName'];
                                $newComment['userInfo']['picture']=$affiliate['affiliatePhotoLink'];
                                $newComment['userInfo']['gender']=$affiliate['affiliateGender'];

                                $completeComments[]=$newComment;

                            }//END if

                        }//END foreach

                    }//END if
                    
                    if($comment['userInfo']['userType']=='user'){

                        foreach ($users as $user) {

                            if($user['id']==$comment['userInfo']['userId']){

                                $newComment=$comment;

                                $newComment['userInfo']['fullName']=$user['fullName'];
                                $newComment['userInfo']['picture']=$user['profilePhotoLink'];
                                $newComment['userInfo']['gender']=$user['personalGender'];

                                $completeComments[]=$newComment;

                            }//END if

                        }//END foreach

                    }//END if

                }//END foreach


                $puzleList=array();
                $puzleList=[];

                //PUT COMMENT INTO EACH POST
                foreach ($postList['post'] as $key => $days) {

                    foreach ($days as $post) {

                        foreach ($completeComments as $comment) {

                            if($comment['postId']==$post['postId']){

                                $post['comments'][]=$comment;
    
                            }//END if

                        }//END foreach

                        $puzleList['post'][$post['postDate']][]=$post;
                        
                     }//END foreach

                }//END foreach

                $response['response']=true;
                $response['message']="Postes getted";
                $response['data']=$puzleList;
           
            }else{

                $puzleList['post']=[];
                $response['response']=true;
                $response['message']="no post found";
                $response['data']=[];

            }//END if

            echo(json_encode($response));

        }//END 

        function comment($post){

            if($_SESSION["active"]===true){

                $this->data=new sqlConnect;
                $this->data->connect();

                $date=date("d/m/Y");
                $time=date("H:i:s");
                $postId=$post->postId;
                $text=$this->sanitaze($post->text);
                $userType= $_SESSION["type"];

                if($_SESSION["type"]=='affiliate'){
                    $userId=$_SESSION["idAffiliate"];
                };//END if

                if($_SESSION["type"]=='user'){
                    $userId=$_SESSION["id"];
                };//END if

                $sql = "UPDATE postes SET 
                        postUpdate='$date',
                        hourUpdate='$time'
                        WHERE id='$postId'";

                $this->data->sql($sql);

                $sql = "INSERT INTO comments (
                    postId,
                    postDate,
                    postHour,
                    userId,
                    userType,
                    postMessage)
             VALUES (
                    '$postId', 
                    '$date',
                    '$time',
                    '$userId',
                    '$userType',
                    '$text')";

            $response=array();

            $result=$this->data->sql($sql);

            if($result===true){
                $response['response']=true;
                $response['message']="Post uploaded";
            }else{
                $response['response']=false;
                $response['message']="Error adding post";
            }//END if

            echo(json_encode($response));
                
            };//END if  

        }//END 

        function sendMessage($post){

            if($_SESSION["active"]===true && strlen($post->message)>0){

                $this->data=new sqlConnect;
                $this->data->connect();

                $recipientId=$this->sanitaze($post->recipientId);
                $recipientType=$this->sanitaze($post->recipientType);
                $messageText=$this->sanitaze($post->message);
                $messageDate=date("d/m/Y");
                $messageHour=date("H:i:s");
                $date=date("d-m-Y");
                $expiration=date('d/m/Y', strtotime($date. ' + 30 days'));
                $senderType=$_SESSION["type"];

                if($senderType=='affiliate'){
                    $senderId=$_SESSION["idAffiliate"];
                };//END if

                if($senderType=='user'){
                    $senderId=$_SESSION["id"];
                };//END if

                $sql = "INSERT INTO messagges (
                    recipientId,
                    recipientType,
                    messageText,
                    messageDate,
                    messageHour,
                    messageExpiration,
                    senderType,
                    senderId)
             VALUES (
                    '$recipientId', 
                    '$recipientType',
                    '$messageText',
                    '$messageDate',
                    '$messageHour',
                    '$expiration',
                    '$senderType',
                    '$senderId')";

            $response=array();

            if($senderId!==$recipientId){
                $result=$this->data->sql($sql);
            }else{
                $result=false;
            }//END if
            
            if($result===true){
                $response['response']=true;
                $response['message']="Message sent";
            }else{
                $response['response']=false;
                $response['message']="Error sending this message";
            }//END if

            echo(json_encode($response));
                
            };//END if  

        }//END 

        function sendNotify($post){

                $this->data=new sqlConnect;
                $this->data->connect();

            if($post){

                $recipientId=$post->recipientId;
                $recipientType=$post->recipientType;
                $typology=$post->typology;
                $messageText=$post->message;
                $messageDate=date("d/m/Y");
                $messageHour=date("H:i:s");
                $date=date("d-m-Y");
                $expiration=date('d/m/Y', strtotime($date. ' + 1 days'));

                $senderType='admin';
                $senderId=99999999;
                
                $sql = "INSERT INTO messagges (
                    recipientId,
                    recipientType,
                    messageText,
                    messageDate,
                    messageHour,
                    messageExpiration,
                    typology,
                    senderType,
                    senderId)
             VALUES (
                    '$recipientId', 
                    '$recipientType',
                    '$messageText',
                    '$messageDate',
                    '$messageHour',
                    '$expiration',
                    '$typology',
                    '$senderType',
                    '$senderId')";

            $this->data->sql($sql);

            }//END if
       
        }//END 

        function getMessagesIndex($post){

            $response=array();
            
            if($_SESSION["active"]===true){

                $this->data=new sqlConnect;
                $this->data->connect();

                $messages=array();
                $messages=[];

                $sentMessages=array();
                $sentMessages=[];

                $countNotReadYet=0;

                $idList=array();
                $idList=[];

                $users=array();
                $users=[];

                $affiliates=array();
                $affiliates=[];

                $userType=$_SESSION["type"];

                if($userType=='affiliate'){
                    $userId=$_SESSION["idAffiliate"];
                };//END if

                if($userType=='user'){
                    $userId=$_SESSION["id"];
                };//END if

                $sql = "SELECT * FROM messagges WHERE
                 (senderId='$userId' AND senderType='$userType') OR 
                 (recipientId='$userId' AND recipientType='$userType') 
                ORDER BY messageDate ASC, messageHour ASC";

                $result=$this->data->sql($sql);

                if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()) {

                        $sentMessages[]=$row;

                        if($row['recipientType']=='affiliate'){
                            $idList['affiliate'][]=$row['recipientId'];
                        };//END IF
    
                        if($row['recipientType']=='user'){
                            $idList['user'][]=$row['recipientId'];
                        };//END IF

                        if($row['senderType']=='affiliate'){
                            $idList['affiliate'][]=$row['senderId'];
                        };//END IF
    
                        if($row['senderType']=='user'){
                            $idList['user'][]=$row['senderId'];
                        };//END IF

                        if($row['senderType']=='admin'){
                            $idList['admin'][]=$row['senderId'];
                        };//END IF

                        if($row['messageRead']==0){
                            $countNotReadYet++;
                        }//END if
    
                    }//END while
                    
                }//END if

                if(count($idList['user'])>0){

                    $idList['user']=array_values(array_unique($idList['user'],SORT_REGULAR));
                    $users=$this->getUsers($idList['user']);

                };//END if

                if(count($idList['affiliate'])>0){

                    $idList['affiliate']=array_values(array_unique($idList['affiliate'],SORT_REGULAR));
                    $affiliates=$this->getAffiliates($idList['affiliate']);

                };//END if

                //ADMIN USER
                $admin=array();
                $admin=[];
                $admin['id']=99999999;
                $admin['fullName']='Amministrazione';
                $admin['accountType']='admin';
                $admin['personalGender']='female';
                $admin['profilePhotoLink']=null;

                $idList['admin'][]=$admin;


                $messages['affiliate']=[];
                $messages['user']=[];

                $countNotReadYet=0;

                foreach ($sentMessages as $message) {

                    if($message['recipientType']=='affiliate'){
                        $messages['affiliate'][$message['recipientId']]['message'][]=$message;
                        $messages['affiliate'][$message['recipientId']]['count']=0;

                    };//END IF

                    if($message['recipientType']=='user'){
                        $messages['user'][$message['recipientId']]['message'][]=$message;
                        $messages['user'][$message['recipientId']]['count']=0;
                    };//END IF

                    if($message['senderType']=='affiliate'){
                        $messages['affiliate'][$message['senderId']]['message'][]=$message;
                        $messages['affiliate'][$message['senderId']]['count']=$messages['affiliate'][$message['senderId']]['count']+0;
                        if($message['messageRead']==0){
                            $messages['affiliate'][$message['senderId']]['count']++;
                            $countNotReadYet++;
                        }
                    };//END IF

                    if($message['senderType']=='user'){
                        $messages['user'][$message['senderId']]['message'][]=$message;
                        $messages['user'][$message['senderId']]['count']=$messages['user'][$message['senderId']]['count']+0;
                        if($message['messageRead']==0){
                            $messages['user'][$message['senderId']]['count']++;
                            $countNotReadYet++;
                        }
                    };//END IF

                    if($message['recipientType']=='admin'){
                        $messages['admin'][$message['recipientId']]['message'][]=$message;
                        $messages['admin'][$message['recipientId']]['count']=0;
                        $messages['admin'][$message['recipientId']]['info']=$admin;
                    };//END IF

                    if($message['senderType']=='admin'){
                        $messages['admin'][$message['senderId']]['message'][]=$message;
                        $messages['admin'][$message['senderId']]['count']=$messages['admin'][$message['senderId']]['count']+0;
                        if($message['messageRead']==0){
                            $messages['admin'][$message['senderId']]['count']++;
                            $countNotReadYet++;
                        }//END if

                        $messages['admin'][$message['senderId']]['info']=$admin;

                    };//END IF


                };//END foreach

                foreach ($users as $user) {

                    $messages['user'][$user['id']]['info']=$user;

                };//END foreach

                foreach ($affiliates as $affiliate) {

                    $messages['affiliate'][$affiliate['id']]['info']=$affiliate;

                };//END foreach

                $messages['currentUser']["type"]=$userType;
                $messages['currentUser']["id"]=$userId;
                $messages['currentUser']["toRead"]=$countNotReadYet;

                //DELECT SESSION USER
                unset($messages[$userType][$userId]);

                $response['response']=true;
                $response['data']=$messages;

            }else{

                $response['response']=false;
                $response['data']=[];

            }//END if

            echo(json_encode($response));

        }//END 

        function notifyRead($post){

            $response=array();
            
            if($_SESSION["active"]===true){

                $this->data=new sqlConnect;
                $this->data->connect();

                $dataCurentId=$post->dataCurentId;
                $dataCurentType=$post->dataCurentType;
                $dataUserId=$post->dataUserId;
                $dataUserType=$post->dataUserType;

                $sql = "UPDATE messagges SET 
                messageRead=1
                WHERE (senderId='$dataUserId' AND senderType='$dataUserType') 
                AND (recipientId='$dataCurentId' AND recipientType='$dataCurentType')";

                $result=$this->data->sql($sql);

                if($result===true){
                    $response['response']=true;
                    $response['message']="Read message notificated";
                }else{
                    $response['response']=false;
                    $response['message']="Error";
                }//END if

                echo(json_encode($response));

            }//END if

        }//END function

        function getUsers($arrayId){

            $users=array();
            $users=[];

            if(count($arrayId)>0){

                $idString=join("', '", $arrayId);

                //GET USERS
                $sql = "SELECT id,personalFirstName,accountType,personalLastName,privacySetting,personalGender,profilePhotoLink FROM users WHERE id in ('$idString')";

                $result=$this->data->sql($sql);

                if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()) {

                        $privacySetting=json_decode($row['privacySetting'], false);

                        if($privacySetting->privacyName=='false'){
                            $row['personalFirstName']=str_replace(".","",$row['personalFirstName']);
                            $row['personalLastName']=str_replace(".","",$row['personalLastName']);
                            $row['personalFirstName']=str_replace(" ","",$row['personalFirstName']);
                            $row['personalLastName']=str_replace(" ","",$row['personalLastName']);
                            $row['personalFirstName']=substr($row['personalFirstName'],0,1).".";
                            $row['personalLastName']=substr($row['personalLastName'],0,1).".";
                        };//END if

                        $row['fullName']=$row['personalFirstName']." ".$row['personalLastName'];

                        if(strlen( $row['profilePhotoLink'])<5){
                            $row['profilePhotoLink']=null;
                        };    

                        if($privacySetting->privacyPhoto=='false'){
                                $row['profilePhotoLink']=null;
                        };//END if

                        //$row['profilePhotoLink']=null;


                        $users[]=$row;

                    }//END while
                    
                }//END if

            }//END if

            return $users;

        }//END get Users

        function getAffiliates($arrayId){

            $users=array();
            $users=[];

            if(count($arrayId)>0){

                $idString=join("', '", $arrayId);

                    //GET AFFILIATES
                    $sql = "SELECT id,affiliateFirstName,accountType,affiliateLastName,affiliateGender,affiliatePhotoLink FROM affiliates WHERE id in ('$idString')";

                    $result=$this->data->sql($sql);

                    if ($result->num_rows > 0) {

                        while($row = $result->fetch_assoc()) {

                            if(strlen( $row['affiliatePhotoLink'])<5){
                                $row['affiliatePhotoLink']=null;
                            };    

                            $row['profilePhotoLink']=$row['affiliatePhotoLink'];

                            //$row['affiliatePhotoLink']=null;

                            $row['fullName']=$row['affiliateFirstName']." ".$row['affiliateLastName'];
                            $users[]=$row;

                        }//END while
                    
                    }//END if

            };//END if

            return $users;

        }//END get Users

    }//END Post


?>



