<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Utility\Utility;
use App\Models\Details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Gallery;
use App\Models\RestaurantTransaction;
use Braintree_ClientToken;
use Braintree_Transaction;
use Braintree_Customer;

class BusinessController extends Controller {

    public function __construct() {
        $this->middleware('business', ['except' => ['getSignup', 'postSignup', 'getLogin', 'postLogin']]);
    }

    public function getLogin() {
        return view('restaurants/login');
    }

    public function postLogin() {
        $inputs = Input::all();
        $rules = array(
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|max:12'
        );
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            //dd($validator->errors()->all());exit;
            return Redirect::to('businesses/login')->with('errors', $validator->errors()->all())->withInput();
        } else {
            if (Auth::attempt(['email' => $inputs['email'], 'password' => $inputs['password'], 'status' => '1', 'user_type' => 3], false)) {
                return Redirect::to('businesses/dashboard');
            } else {
                $message[] = trans('messages.login_fail');
                //dd($message);
                return Redirect::to('businesses/login')->with('errors', $message);
            }
        }
    }

    public function postCreateBusiness() {
        $user = new User();
        $inputs = Input::all();
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:12',
            'mobile_number' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        );
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            return Redirect::to('businesses/create-business')->with('errors', $validator->errors()->all())->withInput();
        } else {
            $user->processUser($inputs);
            return Redirect::to('businesses/business-list')->with('success', 'Restaurant created successfully!!!');
        }
    }

    public function getProfile() {
        $rest_obj = new User();
        $restaurant = $rest_obj->getBusinessDetail(Auth::user()->user_id);
        return view('restaurants/profile')->with('restaurant', $restaurant);
    }

    public function postProfile() {
        //dd(Input::file('gallery'));
        $inputs = Input::all();
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->user_id.',user_id',
            'mobile_number' => 'required',
            'address' => 'required',
            //'latitude' => 'required',
            //'longitude' => 'required',
            'restaurant_name' => 'required',
            'description' => 'required',
            'image' => 'mimes:jpeg,bmp,png,jpg'
        );
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            return Redirect::to('businesses/profile')->with('errors', $validator->errors()->all())->withInput();
        } else {
            $user_id = Auth::user()->user_id;
            $user = array(
                'first_name' => $inputs['first_name'],
                'last_name' => $inputs['last_name'],
                'email' => $inputs['email'],
                'mobile_number' => $inputs['mobile_number'],
                'address' => $inputs['address'],
                'latitude' => $inputs['latitude'],
                'longitude' => $inputs['longitude'],
                'user_type' => 3);
            User::where('user_id',$user_id)->update($user);
            if (!empty(Input::file('image'))) {
                $destination = 'uploads/restaurant/'; // your upload folder
                $image = Input::file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension(); // get the filename
                $image->move($destination, $filename);
                $details['image'] = $filename;
            }
            $details = array('restaurant_name' => $inputs['restaurant_name'],
                'description' => $inputs['description'], 'user_id' => $user_id);
            Details::where('user_id',$user_id)->update($details);
            if (!empty(Input::file('gallery'))) {
                foreach (Input::file('gallery') as $gallery) {
                    if (!empty($gallery)) {
                        $destination = 'uploads/restaurant/gallery/'; // your upload folder
                        $filename = time() . '.' . $gallery->getClientOriginalExtension(); // get the filename
                        $gallery->move($destination, $filename);
                        $gal = array('user_id' => $user_id, 'image_name' => $filename);
                        Gallery::insert($gal);
                    }
                }
            }
            return Redirect::to('businesses/profile')->with('success', 'Updated successfully!!!');
        }
    }

    public function postUpdateUser($id) {
        $user = User::find($id);
        $inputs = Input::all();
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        );
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            return Redirect::to('users/update-user/' . $id)->with('errors', $validator->errors()->all())->withInput();
        } else {
            $email_ver = User::select('user_id')->where('email', '=', $inputs['email'])->where('user_id', '<>', $id)->first();
            if (!empty($email_ver)) {
                $errors[] = 'Email already exist';
                return Redirect::to('users/update-user/' . $id)->with('errors', $errors)->withInput();
            } else {
                $user->processUser($inputs, $id);
                return Redirect::to('users/update-user/' . $id)->with('success', 'User updated successfully!!!');
            }
        }
    }

    public function getSignup() {
        return view('restaurants/signup');
    }

    public function postSignup() {
        $inputs = Input::all();
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:12',
            'mobile_number' => 'required',
            'address' => 'required',
            //'latitude' => 'required',
            //'longitude' => 'required',
            'restaurant_name' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,bmp,png,jpg',
            'city' => 'required',
            'province'=>'required',
            'postal_code'=>'required'
        );
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            return Redirect::to('businesses/signup')->with('errors', $validator->errors()->all())->withInput();
        } else {
            $user = array(
                'first_name' => $inputs['first_name'],
                'last_name' => $inputs['last_name'],
                'email' => $inputs['email'],
                'password' => Utility::generatePassword($inputs['password']),
                'mobile_number' => $inputs['mobile_number'],
                'address' => $inputs['address'],
                //'latitude' => $inputs['latitude'],
                //'longitude' => $inputs['longitude'],
                'city' => $inputs['city'],
                'province'=>$inputs['province'],
                'postal_code'=>$inputs['postal_code'],
                'user_type' => 3);
            $user_id = User::insertGetId($user);
            $destination = 'uploads/restaurant/'; // your upload folder
            $image = Input::file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension(); // get the filename
            $image->move($destination, $filename);
            $details = array('restaurant_name' => $inputs['restaurant_name'],
                'description' => $inputs['description'], 'user_id' => $user_id, 'image' => $filename);
            Details::insert($details);
            if (!empty(Input::file('gallery'))) {
                foreach (Input::file('gallery') as $gallery) {
                    if (!empty($gallery)) {
                        $destination = 'uploads/restaurant/gallery/'; // your upload folder
                        $filename = time() . '.' . $gallery->getClientOriginalExtension(); // get the filename
                        $gallery->move($destination, $filename);
                        $gal = array('user_id' => $user_id, 'image_name' => $filename);
                        Gallery::insert($gal);
                    }
                }
            }
            return Redirect::to('businesses/signup')->with('success', 'Registration successfull and sent for admin approval.');
        }
    }

    public function postUpdateStatus($id) {
        $inputs = Input::all();
        $data = array('status' => $inputs['status']);
        User::where('user_id', $id)->update($data);
        return Redirect::to('users/view-business/' . $id);
    }

    /**
     * Logout from admin
     * @return type redirect to admin login
     */
    public function getLogout() {
        Auth::logout();
        Session::flush();
        return Redirect::to('businesses/login');
    }

    public function getDashboard() {
        //dd(Auth::user());
        $rest_obj = new User();
        $restaurant = $rest_obj->getBusinessDetail(Auth::user()->user_id);
        //dd($restaurant);
        return view('restaurants/dashboard')->with('restaurant', $restaurant);
    }
    
    public function getImageDelete(){
        $inputs = Input::all();
        Gallery::where('image_id',$inputs['image_id'])->delete();
        return response()->json(array('status'=>1));
    }

    public function getBranches(){
        $user = new User();
        $branches = $user->getBranches(Auth::user()->user_id);
        return view('restaurants/branches')->with('branches',$branches);
    }
    
    public function getRegisterBranch(){
        return view('restaurants/register');
    }
    
    public function postRegisterBranch(){
        $inputs = Input::all();
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:12',
            'mobile_number' => 'required',
            'address' => 'required',
            //'latitude' => 'required',
            //'longitude' => 'required',
            'restaurant_name' => 'required',
            'description' => 'required',
            'city' => 'required',
            'province'=>'required',
            'postal_code'=>'required'
        );
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            return Redirect::to('businesses/register-branch')->with('errors', $validator->errors()->all())->withInput();
        } else {
            $user = array(
                'first_name' => $inputs['first_name'],
                'last_name' => $inputs['last_name'],
                'email' => $inputs['email'],
                'password' => Utility::generatePassword($inputs['password']),
                'mobile_number' => $inputs['mobile_number'],
                'address' => $inputs['address'],
                //'latitude' => $inputs['latitude'],
                //'longitude' => $inputs['longitude'],
                'city' => $inputs['city'],
                'province'=>$inputs['province'],
                'postal_code'=>$inputs['postal_code'],
                'user_type' => 3,
                'role'=>2,
                'parent'=>  Auth::user()->user_id);
            $user_id = User::insertGetId($user);
            $details = array('restaurant_name' => $inputs['restaurant_name'],
                'description' => $inputs['description'], 'user_id' => $user_id);
            Details::insert($details);
            if (!empty(Input::file('gallery'))) {
                foreach (Input::file('gallery') as $gallery) {
                    if (!empty($gallery)) {
                        $destination = 'uploads/restaurant/gallery/'; // your upload folder
                        $filename = time() . '.' . $gallery->getClientOriginalExtension(); // get the filename
                        $gallery->move($destination, $filename);
                        $gal = array('user_id' => $user_id, 'image_name' => $filename);
                        Gallery::insert($gal);
                    }
                }
            }
            return Redirect::to('businesses/update-branch/'.$user_id)->with('success', 'Registration successfull and sent for admin approval!!!');
        }
    } 
    
    public function getUpdateBranch($id){
        $rest_obj = new User();
        $restaurant = $rest_obj->getBusinessDetail($id);
        //dd($restaurant);
        return view('restaurants/register')->with('restaurant', $restaurant);
    }
    
    public function postUpdateBranch($user_id){
        $inputs = Input::all();
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user_id.',user_id',
            'password' => 'min:6|max:12',
            'mobile_number' => 'required',
            'address' => 'required',
            //'latitude' => 'required',
            //'longitude' => 'required',
            'restaurant_name' => 'required',
            'description' => 'required',
            'city' => 'required',
            'province'=>'required',
            'postal_code'=>'required'
        );
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            return Redirect::back()->with('errors', $validator->errors()->all())->withInput();
        } else {
            $user = array(
                'first_name' => $inputs['first_name'],
                'last_name' => $inputs['last_name'],
                'email' => $inputs['email'],
                'mobile_number' => $inputs['mobile_number'],
                'address' => $inputs['address'],
                'latitude' => $inputs['latitude'],
                'longitude' => $inputs['longitude'],
                'city' => $inputs['city'],
                'province'=>$inputs['province'],
                'postal_code'=>$inputs['postal_code'],);
            if(!empty($user['password'])){
                $user['password'] = Utility::generatePassword($inputs['password']);
            }
            User::where('user_id',$user_id)->update($user);
            $details = array('restaurant_name' => $inputs['restaurant_name'],
                'description' => $inputs['description'], 'user_id' => $user_id);
            Details::where('user_id',$user_id)->update($details);
            if (!empty(Input::file('gallery'))) {
                foreach (Input::file('gallery') as $gallery) {
                    if (!empty($gallery)) {
                        $destination = 'uploads/restaurant/gallery/'; // your upload folder
                        $filename = time() . '.' . $gallery->getClientOriginalExtension(); // get the filename
                        $gallery->move($destination, $filename);
                        $gal = array('user_id' => $user_id, 'image_name' => $filename);
                        Gallery::insert($gal);
                    }
                }
            }
            return Redirect::to('businesses/update-branch/'.$user_id)->with('success', 'Updated successfull!!!');
        }
    } 
    
    public function getPaymentDo($user_id){
        $client_token = Braintree_ClientToken::generate();
        return view('restaurants/payments')->with('client_token',$client_token)->with('user_id',$user_id);
    }
    
     public function postAddOrder() {
        //print_r ($_POST);exit;
        $input = Input::all();
        $amount = $input["amount"];
        $user_id = $input["user_id"];
        $nonce = $input["payment_method_nonce"];
        $message = '';
        $result = Braintree_Transaction::sale([
                    'amount' => $amount,
                    'paymentMethodNonce' => $nonce,
                    'options' => [
                        'submitForSettlement' => True
                    ]
        ]);

        if ($result->success || !is_null($result->transaction)) {
            $transaction = $result->transaction;
            //dd($transaction);
            RestaurantTransaction::insert(array('user_id'=>$user_id,'amount'=>$amount,'transaction_id'=>$transaction->id,'payment_status'=>$transaction->status));
            User::where('user_id',$user_id)->update(array('subscription'=>1));
            $message = sprintf(trans('Transaction_id %s'), $transaction->id);
            $status = true;
        } else {
            $message = "";
            foreach ($result->errors->deepAll() as $error) {
                $message .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }
            $status = false;
        }
        //$status = false;
        //$message = "kjhkwhckh lkhwelkhckwejhckwej khlewkchkwejhck ec";
        return view('restaurants/payment-result')->with('status', $status)->with('message', $message);
    }

}
