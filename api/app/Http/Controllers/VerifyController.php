<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerifyController extends Controller
{
    /**
     * Create a new controller.
     *
     * @return void
     */
    public function __construct()
    {
      
    }

    public function getID($uid)
    {
        $customer = Customers::where('uid', $uid)
        ->first();

        if (!empty($customer)) {
            return $this->responseRequestSuccess(array('status' => true, 'msg' => '"UID is not available"'));
        } else {
            return $this->responseRequestSuccess(array('status' => false, 'msg' => '"UID is available"'));
        }        
    }

    public function addData(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:customers',
            'uid' => 'required',
            'displayName' => 'required',
            'pictureUrl' => 'required',
            'statusMessage' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();

            return $this->responseRequestError($errors);
        } else {
            $customer = new Customers();
            $customer->fullname = $request->fullname;
            $customer->phone_number = $request->phone_number;
            $customer->email = $request->email;
            $customer->uid = $request->uid;
            $customer->displayName = $request->displayName;
            $customer->pictureUrl = $request->pictureUrl;
            $customer->statusMessage = $request->statusMessage;

            if ($customer->save()) {
                $LineBotController = new LineBotController();
                $LineBotController->linkRichmenu($request->uid,'richmenu-cd2458b729eb21c25566140ba2cc0c71');
                return $this->responseRequestSuccess($customer);
            } else {
                return $this->responseRequestError('Cannot Register');
            }
        }
    }

    protected function responseRequestSuccess($ret)
    {
        return response()->json(['status' => 'success', 'data' => $ret], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        return response()->json(['status' => 'error', 'error' => $message], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}