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

function campaign_status(){
    $data = [
        "Active","Hold","Completed"
    ];

    return $data;
}

function campaign_priority(){
    $data = [
        "High","Urgent"
    ];

    return $data;
}

function time_elapsed_string( $date )
{
    $time_difference = time() - strtotime($date);

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return  $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}



?>
