<?php

$deviceToken = 'cd709e03d85823af923a21d63863bbc123a1456b1f31633873d46d68450a6d86';
$message = 'iPad!';

    
$body['aps'] = array(
                     'alert' => $message,
                     'badge' => 18
                     );
    
//$body['category'] = 'message';
$body['category'] = 'profile';
//$body['category'] = 'dates';
//$body['category'] = 'daily_dates';

//$body['sender'] = 'jamesHAW';
$body['sender'] = 'jerrytest35';
    

//Server stuff
$passphrase = '';

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ipad_sandbox.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;

fclose($fp);
    
?>
