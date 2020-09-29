<?php

// exemple:

// $url = 'URL de sua API';
// $data = [
//     "login"=>"ntdsoft",
//     "password"=>"ocaminhodejesus"
// ];
// var_dump( requestUrl($url, 'post', $data) );



/**
 * this function request data from one api or url / esta função requere dados de uma api ou url
 * 
 * 
 * @param string $url the url from api / a url da api
 * @param 'get' | 'post' | 'put' | 'delete' $method the method from request / o methodo da requisição
 * @param any[] $data the data from methods POST and PUT / os dados dos methodos POST e PUT
 * @param boolean $json if true the data return in JSON, if not, return a string / se true os dados retornam em JSON, se não, retorna uma string
 * @return { ok:0 | 1, data:object , erro:string, error:string}
 */
function requestUrl($url, $method='get', $data=null, $json=true){
    $ch = curl_init();
    $method = strtolower($method);
    if(is_array($data)){
        $query = '';
        foreach($data as $key => $val){
            if($query) $query .= '&';
            $query .= urlencode($key) . '=' . urlencode($val);
        }
        $data = $query;
    }
    if($method === 'get'){
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    }else if($method === 'delete'){
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    }else if($method === 'post'){
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }else if($method === 'put'){
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, []);
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    } 
    $result = curl_exec($ch);
    return $json ? json_decode($result) : $result ;
    curl_close($ch);
}