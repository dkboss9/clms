<?php

/** Get Current Visitor's IP **/
function pds_get_ip() {

    //  IP
    $ip = '0.0.0.0';

    //  Check ip from share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
    //  To check ip is passed from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else    $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
}

/** Get Current Visitor's Device Details **/
function pds_get_device_details() {
    return $_SERVER['HTTP_USER_AGENT'];
}

/** Base64 Encode **/
function pds_base64_url_encode($input) {
    return base64_decode(strtr($input, '+/', '-_'));
}

/** Base64 Decode **/
function pds_base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}

function get_enroll_phase($phaseid=null){
    $phase = [
        '1'=> 'Case Start',
        '2'=> 'Contract Signed',
        '3'=> 'Document List',
        '4'=> 'Document Received',
        '5'=> 'Application Prepared',
        '6'=> 'Supervisor Checked',
        '7'=> 'Application Lodged',
        '8'=> 'Application Acknowledge',
        '9'=> 'Document Lodged',
        '10'=> 'Processing Commenced',
    ];

    if($phaseid)
        return $phase[$phaseid]??'';
    else
        return $phase;
}

function get_enroll_education_phase($phaseid=null){
    $phase = [
        '1'=> 'Case Start',
        '2'=> 'Contract Signed',
        '3'=> 'Offer letter processing',
        '4'=> 'Offer letter issued',
        '5'=> 'Coe Processing',
        '6'=> 'Coe issued',
        '7'=> 'Enrolled',
    ];

    if($phaseid)
        return $phase[$phaseid]??'';
    else
        return $phase;
}


?>
