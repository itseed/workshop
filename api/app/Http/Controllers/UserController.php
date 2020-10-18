<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class UserController extends Controller
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
        $results = app('db')->select("SELECT * FROM users");
        return $this->responseSuccess($results);
    }

    public function getID($id)
    {
        return $this->responseSuccess('Get ID Data' . $id);
    }

    public function addData()
    {
        return $this->responseSuccess('Add Data');
    }

    public function updateData($id)
    {
        return $this->responseSuccess('Update Data' . $id);
    }

    public function deleteData($id)
    {
        return $this->responseSuccess('Delete Data' . $id);
    }

    protected function responseSuccess($res)
    {
        return response()->json(["status" => "success", "data" => $res], 200)
            ->header("Access-Control-Allow-Origin", "*")
            ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
    }
}