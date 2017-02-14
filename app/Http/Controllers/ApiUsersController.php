<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Utility\Utility;
use Illuminate\Support\Facades\Request;

class ApiUsersController extends Controller {
    
    public $jsonData;
    public function __construct() {
        $request = Request::instance();
        $this->jsonData = json_decode($request->getContent(), true);
    }
    
    /*
     *  http://localhost/restaurant_offers/public/api/users/signup
     *  method post 
     */
    public function postSignup(){
        try{
            $util = new Utility();
            //Form input name = first_name
            $inputs = $this->jsonData;
            //dd($inputs);
            $rules = array(
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:12',
            );
            $validator = Validator::make($inputs, $rules);
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return $util->sendResponse('0', $message, 'Error', 200);
            }else{
                $user = array('first_name'=>$inputs['firstName'],'last_name'=>$inputs['lastName'],'email'=>$inputs['email'],'password'=>Utility::generatePassword($inputs['password']));
                $id = User::insertGetId($user);
                $user_data = User::find($id);
                return $util->sendResponse('1', $user_data, 'Successfull', 200);
            }
        } catch (Exception $e) {
            echo $e;
            exit;
        }
    }
}