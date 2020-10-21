<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
      // richmenu-fd48b04201a9b5547ab331915d96860c Default
      // richmenu-cd2458b729eb21c25566140ba2cc0c71 Member
      $this->channelAccessToken = env('LINE_TOKEN');
      $this->channelSecret = env('LINE_CHANNAL');
    }

    public function linkRichmenu($uid, $richmenu_id){

      $header = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $this->channelAccessToken,
      );

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL =>   "https://api.line.me/v2/bot/user/".$uid."/richmenu/".$richmenu_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => $header,
      ));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
    }

    public function bot(Request $request){
      $content = file_get_contents('php://input');
 
      $events = json_decode($content, true);
      if(!is_null($events)){
          $replyToken = $events['events'][0]['replyToken'];
          $uid = $events['events'][0]['source']['userId'];
          $typeMessage = $events['events'][0]['message']['type'];
          $userMessage = $events['events'][0]['message']['text'];
      }
      error_log($content);

      $messages[] = array(
        "type" => "text",
        "text" => $userMessage
      );

      $results = $this->replyMessage($replyToken, $messages);
      // $results = $this->pushMessage($uid, $messages);

      return response()->json(['status' => 'success', 'data' => '{}'], 200);
    }

    private function replyMessage($token, $messages){

      $header = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $this->channelAccessToken,
      );

      $content = array(
        'replyToken' => $token, 
        'messages' => $messages
      );

      $context = stream_context_create([
          'http' => [
              'ignore_errors' => true,
              'method' => 'POST',
              'header' => implode("\r\n", $header),
              'content' => json_encode($content),
          ],
      ]);

      $response = file_get_contents('https://api.line.me/v2/bot/message/reply', false, $context);
      if (strpos($http_response_header[0], '200') === false) {
          error_log('Request failed: ' . $response);
      }
    }

    private function pushMessage($uid, $messages){
      $header = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $this->channelAccessToken,
      );

      $content = array(
        'to' => $uid, 
        'messages' => $messages
      );

      $context = stream_context_create([
          'http' => [
              'ignore_errors' => true,
              'method' => 'POST',
              'header' => implode("\r\n", $header),
              'content' => json_encode($content),
          ],
      ]);

      $response = file_get_contents('https://api.line.me/v2/bot/message/push', false, $context);
      if (strpos($http_response_header[0], '200') === false) {
          error_log('Request failed: ' . $response);
      }
    }
}
