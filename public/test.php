<?php
$appid = "d044135f-653d-89eb-2912-f69f68d9ab64";
$post_data =  array();
$post_data['requestId'] = "1005";
$post_data['appReference'] = "test@fleetops.com";
$post_data['secret'] = "Fl3310p5";
$post_url = "https://posapi.usebillbox.com/webpos/listPayOptions";
$curl = curl_init($post_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'content-type: application/json',
            'appid: '.$appid ));
$response = curl_exec($curl); 
print_r($response);
if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
    echo $error_msg;
}
curl_close($curl);