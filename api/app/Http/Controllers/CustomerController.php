<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller;

class CustomerController extends Controller
{
    /**
     * Create a new controller for User.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        $results = app('db')->select("SELECT * FROM customers");
        return $this->responseRequestSuccess($results);
    }

    public function getID($id)
    {
        // return $this->responseRequestSuccess('Get ID Data' . $id);
        $customer = Customers::where('uid', $id)
        ->first();

        if (!empty($customer)) {
            return $this->responseRequestSuccess($customer);
        } else {
            return $this->responseRequestError("UID is incorrect");
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
                return $this->responseRequestSuccess($customer);
            } else {
                return $this->responseRequestError('Cannot Register');
            }
        }
    }

    public function updateData($id)
    {
        return $this->responseRequestSuccess('Update Data' . $id);
    }

    public function deleteData($id)
    {
        return $this->responseRequestSuccess('Delete Data' . $id);
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