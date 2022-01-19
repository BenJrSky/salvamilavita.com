<?php

session_start();

class Payment{

    function charge(){

      $data = $_POST['additional_data'];
      $data_amount = $_POST['data-amount'];
      $data_currency = $_POST['data-currency'];
      $data_name = $_POST['data-name'];
      $data_email = $_POST['data-email'];
      
      if($token = $_POST['stripeToken']){

        include "../php/config_stripe.php";
        include "../stripe/init.php";

        \Stripe\Stripe::setApiKey($stripe['secret_key']);
    
        $application_fee = intval($data_amount * 0.2);
    
        $customer = \Stripe\Customer::create(array(
            "email" => $data_email,
            "card"  => $token
        ));
    
        if($charge = \Stripe\Charge::create(array(
                  "customer" => $customer->id,
                  "amount"   => $data_amount,
                  "currency" => $data_currency
              ))){
        
              echo("SUCCESSFULLY CHARGED ".$data);
    
              $netCharge = intval(($data_amount*0.97)-30);
              $taxCharge = intval(($netCharge*0.36)-30); 
              $payment = intval((($netCharge-$taxCharge)*0.97)-30); 
    
              if($balance = \Stripe\Balance::retrieve()){
    
                $available = $balance->available->amount;
    
                if($available>=$netCharge){
    
                    //TAX
                    $taxFound = new \Stripe\StripeClient(
                      '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'
                    );
    
                    if($taxFound->payouts->create([
                      'amount' => $taxCharge,
                      'currency' => 'eur'
                    ])){
                      echo("TAX SUCCESSFULLY PAYD ");
                    }
    
                    //PAYMENT
                    $paymentFound = new \Stripe\StripeClient(
                      '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'
                    );
    
                    if($paymentFound->payouts->create([
                      'amount' => $payment,
                      'currency' => 'eur'
                    ])){
                      echo("EARN SUCCESSFULLY SEND");
                    } 
    
                }//END PAYMENTS
    
              }//balance
  
    
        }//if $charge

        $this->update();
    
      }//if token


    }//charge

    function update(){

      $data_subscription = $_POST['data-subscription'];

      include "../php/config.php";

      $this->data=new sqlConnect;
      $this->data->connect();

      $date=date("d-m-Y");

      switch($data_subscription){
        case "1":
          $expiration=date('d/m/Y', strtotime($date.' + 1 year'));
        break;
        case "5":
          $expiration=date('d/m/Y', strtotime($date.' + 5 year'));
        break;
        case "10":
          $expiration=date('d/m/Y', strtotime($date.' + 10 year'));
        break;
        
      }
    
      $userId=$_SESSION["id"];
      $affiliateId=$_SESSION["idAffiliate"];
      
      if($_SESSION["type"]=='user'){
  
          $sql = "UPDATE users SET
                      accountExpiration='$expiration',
                      accountStatus='active'
                      WHERE id='$userId'";
                                  
          $result=$this->data->sql($sql);
          $_SESSION["status"]="active";
          if($result===true){
            header("Location: https://www.salvamilavita.com/success.html");  
          }else{
            header("Location: https://www.salvamilavita.com/error.html");
          }//if
  
      }

      if($_SESSION["type"]=='affiliate'){
  
        $sql1 = "UPDATE affiliates SET
                    accountExpiration='$expiration',
                    accountStatus='active'
                    WHERE id='$affiliateId'";
                                
        $result=$this->data->sql($sql1);

        if($result===true){
          $_SESSION["status"]="active";
          header("Location: https://www.salvamilavita.com/affiliate.html");  
        }else{
          header("Location: https://www.salvamilavita.com/error.html");
        }//if

    }
  
    }//update



}//Payment


$pay = new Payment;
$pay->charge();






?>