<?php

function pds_upload_file($file, $path='/', $maxsize=2, $filter='allow', $exts='*') {
	if(!file_exists($path))	wp_mkdir_p($path);
	$filename = str_ireplace(array(' ', '%', '#', '?', '\\', '/'), '', $file['name']);
	$validFile = true;
	$error = false;
	if($filter!='all' && $filter!='allow_all' && $exts!='' && $exts!='*') {
		switch(strtolower($filter)) {
			case 'allow':
			case 'only_allow':
				$validFile = (bool)preg_match("/(\.(" . implode('|', explode(',', $exts)) . "))$/iu", $filename);
				break;
			case 'block':
			case 'only_block':
				$validFile = !(bool)preg_match("/(\.(" . implode('|', explode(',', $exts)) . "))$/iu", $filename);
				break;
		}
	}
	if($maxsize>0) {
		$allowed_size = $maxsize * (1024 *1024);
		$file_size = $file['size'];
		if($file_size>$allowed_size)	$error = 'size';
	}
	if($validFile) {
		$filename = pds_fix_duplicate_filename($filename);
		@move_uploaded_file($file['tmp_name'], $path . $filename);
	} else {
		$error = 'ext';
	}
	return array('filename'=>$filename, 'error'=>$error);
}

function pds_valid_date_format($date) {
	$converted = str_replace('/', '-', $date);
	$preg = "/^((((19|20)(([02468][048])|([13579][26]))-02-29))|((20[0-9][0-9])|(19[0-9][0-9]))-((((0[1-9])|
			(1[0-2]))-((0[1-9])|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|
			(1[0-2]))-(29|30)))))$/";
	return (bool)preg_match($preg, $converted);
}

function pds_valid_email($value) {
	//$preg = "/^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))/i";
	//$preg = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/i";
	//$preg = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
	$preg = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
	return (bool)preg_match($preg, $value);
}

function pds_valid_phonenumber($number) {
	$preg = "/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/i";
	return (bool)preg_match($preg, $number);
}

function pds_valid_time_format($time) {
	$preg = "/(0?\d|1[0-2]):(0\d|[0-5]\d) (AM|PM)/i";
	return (bool)preg_match($preg, $time);
}

function pds_valid_number($number) {
	$preg = "/^\d+/i";
	return (bool)preg_match($preg, $number);
}

function pds_valid_url($url) {
	$preg = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
	return (bool)preg_match($preg, $url);
}

?>
