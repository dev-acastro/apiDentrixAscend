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

     function getDatav0($endpoint, $data=NULL, $i = NULL ){
        $params = "";
        $id = "";

        global $token;

        if(isset($i)){
            $id = "/". $i;
        }

        if(isset($data)){
            $params = "?" . http_build_query($data, '', '&amp;');

        }
        $curl = curl_init('https://prod.hs1api.com/ascend-gateway/api/v0/'. $endpoint . $id . $params);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '. $token,
            'Organization-ID: 5e7b7774c9e1470c0d716320'
        ));

        $output = curl_exec($curl);

        curl_close($curl);

        return json_decode($output);
    }

function postData( $endpoint, $data){
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

function getTx($id){

    $data = [
        "filter" => "patient.id==".$id
    ];

    $cases =  getData("txcases", $data);



    foreach ($cases->data as $id => $case){
        $visits[$case->id] =  getData("visits", array("filter"=>"txCase.id==".$case->id))->data;

    }


    foreach ($visits as $visit){

        foreach ($visit as $iv){



            if(isset($iv->appointment->id)){
                $txAppoinments[$iv->id]  = getData("appointments", NULL, $iv->appointment->id);
            }

            foreach($iv->procedures as $procedure) {
                $txProcedures[$iv->id] = getDatav0("patientprocedures", NULL, $procedure->id );
            }
        }



    }


    $tx = [$cases, $visits, $txProcedures, $txAppoinments];

    print_r($tx);

    //return  $tx;



}





?>