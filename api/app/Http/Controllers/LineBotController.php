<?php

namespace App\Http\Controllers;

class LineBotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $channelAccessToken;
    protected $channelSecret;

    public function __construct()
    {
      // $this->channelAccessToken = $channelAccessToken;
      // $this->channelSecret = $channelSecret;
      $this->channelAccessToken = env('LINE_TOKEN');
      $this->channelSecret = env('LINE_CHANNAL');
    }

    function pushMessage($uid, $messages){
      error_log("pushMessage");
      $header = array(
          "Content-Type: application/json",
          'Authorization: Bearer ' . $this->channelAccessToken,
      );
  
      // $post = array(
      //   'to' => $uid, 
      //   'messages' => $messages
      // );
      $post = array(
        'to' => $uid, 
        'messages' => array(
          array(
            "type" => "text",
            "text" => $messages
          )
        )
      );

      // echo json_encode($post);
      // exit();
      
      error_log(json_encode($post));
      $ch = curl_init('https://api.line.me/v2/bot/message/push');
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_HEADER, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      $response = curl_exec($ch);
      // print_r($response);
      error_log("Push: " . $response);
      $err = curl_error($ch);
      curl_close($ch);
      if ($err) {
          $datasReturn['result'] = 'E';
          $datasReturn['message'] = $err;
      } else {
          if($response == "{}"){
            $datasReturn['result'] = 'S';
            $datasReturn['message'] = 'Success';
          }else{
            $datasReturn['result'] = 'E';
            $datasReturn['message'] = $response;
          }
      }
      return $datasReturn;
    }

}
