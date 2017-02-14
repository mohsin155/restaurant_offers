<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Utility\Utility;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use SoftDeletes;

    protected $softDelete = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $primaryKey = 'user_id';
    
    public function gallery() {
        return $this->hasMany('App\Models\Gallery','user_id','user_id');
    }
    
    public function processUser($inputs,$id=0){
            $user = User::firstOrNew(array('user_id' => $id));
            $user->first_name = $inputs['first_name'];
            $user->last_name = $inputs['last_name'];
            $user->email = $inputs['email'];
            $user->user_type = $inputs['user_type'];
            $user->address = $inputs['address'];
            $user->status = $inputs['status'];
            $user->mobile_number = $inputs['mobile_number'];
            if(!empty($inputs['password'])){
                $user->password = Utility::generatePassword($inputs['password']);
            }
            $user->save();
            return;
    }
    
    public function updatePassword($userId, $newPassword) {

        $user = User::find($userId);
        $user->password = bcrypt($newPassword);
        $user->force_password_change = 0;
        $user->save();

        return $user;
    }
    
    public function getAllUser($role,$dep){
        $query = User::with(array('department'));
        if($role==1){
        }elseif($role == 2){
            $query->where(array('department_id'=>$dep));
        }elseif($role==3){
            $query->where(array('user_id'=>Auth::user()->user_id));
        }
        return $query->get();
    }
    
    public function getUserDetail($user_id){
        $user = User::find(array('user_id'=>$user_id))->first();
        return $user;
    }
    
    public function getBusinessDetail($user_id){
        $user = User::with('gallery')->join('restaurant_details as p','p.user_id','=','users.user_id')
                ->select('users.*','p.restaurant_name','p.image','p.description')
                ->where('users.user_id',$user_id)->first();
        return $user;
    }
    
    public function getBranches($user_id){
        $user = User::whereRaw('parent = '.$user_id.' or user_id = '.$user_id)->get();
        return $user;
    }
    
}
