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
                
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:12',
                'mobile_number' => 'required',
            );
            $validator = Validator::make($inputs, $rules);
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return $util->sendResponse('0', $message, 'Error', 200);
            }else{
                $user = array('email'=>$inputs['email'],'password'=>Utility::generatePassword($inputs['password']),'mobile_number'=>$inputs['mobile_number']);
                $id = User::insertGetId($user);
                $user_data = User::find($id);
                return $util->sendResponse('1', $user_data, 'Successfull', 200);
            }
        } catch (Exception $e) {
            echo $e;
            exit;
        }
    }
    
    public function postLogin(){
        try{
             $util = new Utility();
             $inputs = $this->jsonData;
            $rules = array(
                'email' => 'required|exists:users,email', 
                'password' => 'required'
                );
            $validator = Validator::make($inputs, $rules);
            if ($validator->fails()) {
                 $message = $validator->errors()->all();
                return $util->sendResponse('0', $message, 'Error', 200);
            } else {
                $user = User::where("email", $inputs['email'])->first();
                if (!Hash::check($inputs['password'], $user->password)) {
                    $data = "";
                    $status = config('constants.status.error');
                    $status_code = config('constants.status_code.ok');
                    $message = "Incorrect password";
                } else {
                    $data = $user;
                    $status = config('constants.status.success');
                    $status_code = config('constants.status_code.ok');
                   return $util->sendResponse('1', $data, 'login Successfull', 200);
                }
            }
        } catch (Exception $e) {
            echo $e;
            exit;
        }
        
    }
    
    
     public function postProfileupdate() {
        try {
            $inputs = $this->jsonData;
            $user = User::find($inputs['user_id']);
            if (!empty($user)) {
                $user_data = array(
                    'first_name' => $inputs['first_name'],
                    'last_name' => $inputs['last_name'],
                    'address' => $inputs['address'],
                    'email'=>$inputs['email'],
                    'mobile_number' => $inputs['mobile_number']
                );
                if (!empty($inputs['password'])) {
                    $user_data['password'] = Utility::generatePassword($inputs['password']);
                }
                User::where('user_id', '=', $user->user_id)->update($user_data);
                $user = User::find($user->user_id);
                $data = $user;
                $status = config('constants.status.success');
                $status_code = config('constants.status_code.ok');
                $message = trans('messages.user_signup');
            } else {
                $data = "";
                $status = config('constants.status.error');
                $status_code = config('constants.status_code.ok');
                $message = "User does not exist";
            }
        } catch (Exception $ex) {
            echo $e;
            exit;
        }
        return $this->renderJson($status, $status_code, $data, $message);
    }
    
    
}