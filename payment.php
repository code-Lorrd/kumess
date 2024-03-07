<?php
include 'components kumess/order.php';
//function to generate access token for payment
function generateAccessToken(){
    $consumerKey= 'YOUR_CONSUMER_KEY';
    $consumerSecret='YOUR_CONSUMER_SECRET';
    $credentials=base64_encode($consumerKey.':'.$consumerSecret);
    
    $url=
    'https://sandbox.safaricom.co.ke/oauth/vl/generate?grant_type=client_credentials';


    $options=array(
        'http'=> array(
        'header'=> "Authorization: Basic $credentials",
        'method'=> 'GET'
            
        ),
    );

    $context= stream_context_create($options);
    $response= file_get_contents($url,false,$context);
    $json=json_decode($response,true)

    return $json['access token'];
}


//function to initiate payment
function initiatePayment($accessToken,$amount,$phonenumber,$callbackUrl){
    $url=
    'https://sandbox.safaricom.co.ke/mpesa/stkpush/vl/processre quest';

    $timestamp-dat('YmdHis');
    $password=base64_encode('YOUR_SHORTCODE'.'YOUR_PASSKEY'.$timestamp);

    $data=array(
        'Businessshortcode'=>'YOUR_SHORTCODE',
        'password'=> $password,
        'timestamp'=> $timestamp,
        'Transactiontype'=>'Consumerpaybillonline',
        'amount'=>$amount,
        'partyA'=>$phonenumber,
        'PartyB'=>'YOUR_SHORTCODE',
        'phonenumber'=>$phonenumber,
        'CallBackUrl'=>$callbackUrl,
        'accountreference'=>'ORDER_ID',//replace with your order ID
        'TransactionDesc'=>'Payment for food order'//replace with a description of the transaction
    );

    $dataJson=json_encode($data);

    $options=array(
        'http'=>array(
            'header'=>"Content-Type: application/json\r\n",
                      "Authorization: bearer $accessToken\r\n",
            'method'=> 'POST',
            'content'=>$dataJson,          
        ),
    );


    $context=stream_context_create($options);
    $response=file_get_contents($url,false,$context);
    return json_decode($response,true);
};

//generate acces token
$accessToken= generateAccessToken();

//initiate payment
$amount='100';//This is an example in KES
$phonenumber='2547xxxxxxx';//This is an example of phone number
$callbackUrl='https://example.com';//Replace this with your call back URL
$response=initiatePayment($accessToken,$amount,$phonenumber,$callbackUrl);


//Handle payment Response
if($response && isset($response['ResponseCode'])&& $response['ResponseCode']=='0'){
    echo'Payment Initiated Successfully.Transaction ID:',
    $response['MerchantRequestID'];
}
else{
    echo'Failed to initiate payment:',
    $response['errorMessage'];
}
?>



   