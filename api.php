<?php

include 'authorization.php';

$auth = new authorization();
$token = $auth->getToken();

function getPatients($id=""){
    global $token;

    $curl = curl_init('https://prod.hs1api.com/ascend-gateway/api/v1/patients/'.$id);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer '. $token,
        'Organization-ID: 5e7b7774c9e1470c0d716320'
    ));

    $output = curl_exec($curl);

    curl_close($curl);

    return $output;


}

function getAppoinments(){
    global $token;

    $curl = curl_init('https://prod.hs1api.com/ascend-gateway/api/v1/appointments');

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer '. $token,
        'Organization-ID: 5e7b7774c9e1470c0d716320'
    ));

    $output = curl_exec($curl);

    curl_close($curl);

    return $output;
}



function getData($endpoint, $data=NULL, $i = NULL ){
    $params = "";
    $id = "";

    global $token;

    if(isset($i)){
        $id = "/". $i;
    }

    if(isset($data)){
        $params = "?" . http_build_query($data, '', '&amp;');

    }
    $curl = curl_init('https://prod.hs1api.com/ascend-gateway/api/v1/'. $endpoint . $id . $params);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer '. $token,
        'Organization-ID: 5e7b7774c9e1470c0d716320'
    ));

    $output = curl_exec($curl);

    curl_close($curl);

    return json_decode($output);
}

function postData( $endpoint, $data=NULL){
    global $token;
    $body = json_encode($data);


    $curl = curl_init('https://prod.hs1api.com/ascend-gateway/api/v1/'. $endpoint);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer '. $token,
        'Organization-ID: 5e7b7774c9e1470c0d716320',
        'Accept: application/json',
        'Content-Type: application/json',
    ));

    $output = curl_exec($curl);

    curl_close($curl);

    return $output;
}

function getTx(){

    $cases =  getData("txcases", array("filter" => "patient.id==7000001169539"));

    foreach ($cases->data as $id => $case){
        $visits[$case->id] =  getData("visits", array("filter"=>"txCase.id==".$case->id));

    }

    foreach ($visits as $visit){
       $txAppoinments[$visit->id]  = getData("appointments", NULL, $visit->appointmet->id);

       foreach($visit->procedures as $procedure) {
           $txProcedures[$visit->id] = getData("patientprocedures", NULL, $procedure->id );
       }

    }
    return $cases ;



}





?>