<?php

class authorization {

    public function getToken(){
        $curl = curl_init('https://prod.hs1api.com/oauth/client_credential/accesstoken?grant_type=client_credentials');
        curl_setopt($curl, CURLOPT_POSTFIELDS, "client_id=kdqoHWRZ1YB5M99QVrtc9p4v2kxSct89&client_secret=IqHYGkvrsN7eFfRe");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));

        $output = curl_exec($curl);
        curl_close($curl);

        $token = json_decode($output);

        return $token->access_token ;
    }



}

?>