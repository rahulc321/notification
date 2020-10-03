<?php


	if($device_type == "android"){
       	$device_token = YOUR_DEVICE_TOKEN;
        $msg =  [
					'message'     => "Any Message",
					'title'        => 'Title Notification',                    
					'YOURDEFINEKEY'     => YOUR_DATA,
					'YOURDEFINEKEY'     => YOUR_DATA,
					'vibrate'    => 1,
					'sound'        => 1,
					'callback_id'=>'2',
					'largeIcon'    => 'large_icon',
					'smallIcon'    => 'small_icon',
         		];
        $fields = 	[
                       'to'     => $device_token,
                       'data'   => $msg,                        
           			];
        $headers = 	[
               			'Authorization: key= YOUR_FCM_SERVER_KEY',
               			'Content-Type: application/json'
           			];

    		$ch = curl_init();
    		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    		curl_setopt( $ch,CURLOPT_POST, true );
    		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    		$result = curl_exec($ch );
    		// print_r($result);
    		curl_close( $ch );
  	}



  	if($device_type == "ios"){

  		   $data = array(

                        'mdesc'     => $message,
                        'mtitle'        => 'Notification',
                        'mtotalrequestcount'     => $requestcount,
                        'mtotalfollowcount'     => $followcount,
                        'mtotalLike'     => $likecount,
                        'm  totalComment'     => $commentcount,
                        'vibrate'    => 1,
                        'sound'        => 1,
                        'badge' => 'Increment',
                        'largeIcon'    => 'large_icon',
                        'smallIcon'    => 'small_icon',
                        'pushdata'  => $pushdetail
                        'notification_type' =>$pushdetail['type'],
                        'userid' =>$pushdetail['userid'],
                        'useremail' =>$pushdetail['useremail'],
                        'usertype' =>$pushdetail['usertype'],
                        'postid' =>$pushdetail['postid'],
                      );

                  $devicetoken = YOUR_DEVICE_TOKEN;
                  



                    // Push Notification code for IPHONE in PHP 

                    $deviceToken = $devicetoken;
                    $pem = base_url().'pushcert.pem';
                    $deviceToken = $devicetoken;
                    $ctx = stream_context_create();

                        //$streamContext = stream_context_create();

                        // ck.pem is your certificate file
                        stream_context_set_option($ctx, 'ssl', 'local_cert', 'pushcert.pem');
                        stream_context_set_option($ctx, 'ssl', 'passphrase', '1234');
                        $fp = stream_socket_client(
                            'ssl://gateway.push.apple.com:2195', $err,
                              $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
                        if (!$fp){
                            exit("Failed to connect: $err $errstr" . PHP_EOL);
                        }
                        $body['aps'] = array(
                            'alert' => array(
                            'title' => $data['mtitle'],
                                'body' => $data['mdesc'],
                             ),
                            'sound' => 'default',
                            'notification_type' =>$pushdetail['type'],
                            'userid' =>$pushdetail['userid'],
                            'useremail' =>$pushdetail['useremail'],
                            'usertype' =>$pushdetail['usertype'],
                            'postid' =>$pushdetail['postid'],
                        );
                        $payload = json_encode($body);
                        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                        $result = fwrite($fp, $msg, strlen($msg));
                        fclose($fp);
                        if (!$result){
                            return 'Message not delivered' . PHP_EOL;
                        }
                        else{
                            return 'Message successfully delivered' . PHP_EOL;
                        }
  	}