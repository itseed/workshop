<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->channelAccessToken = env('LINE_TOKEN');
        $this->CustomerController = new CustomerController();
    }

    public function customerStat(){
      $header = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $this->channelAccessToken,
      );

      $content = array();

      $context = stream_context_create([
          'http' => [
              'ignore_errors' => true,
              'method' => 'GET',
              'header' => implode("\r\n", $header),
              'content' => json_encode($content),
          ],
      ]);

      $lastday = date("Ymd", strtotime("-1 day",strtotime(date('Y-m-d'))));

      $response = file_get_contents('https://api.line.me/v2/bot/insight/followers?date='.$lastday, false, $context);
      if (strpos($http_response_header[0], '200') === false) {
          error_log('Request failed: ' . $response);
      }

      $customerlist = Customers::get();
      $customerCount = $customerlist->count();

      // echo $response;

      $customerRes = json_decode($response, true);
      $customerRes['totalCustomers'] = $customerCount;
      $customerRes['lastUpdate'] = $lastday;
      // array_push($customerRes, array('totalCustomer' => $customerCount));

      // print_r($customerRes);

      return $this->CustomerController->responseRequestSuccess($customerRes);
    }

}