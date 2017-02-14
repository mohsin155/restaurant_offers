<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Winner extends Model {
    
    protected $primaryKey = 'winner_id';
    
    public function user() {
        return $this->belongsTo('App\Models\User','user_id','user_id');
    }
    
    public function restaurant() {
        return $this->belongsTo('App\Models\User','restaurant_id','user_id');
    }
    
    public function winnersList(){
        $query = Winner::select('*',
                DB::raw('(select concat(u.first_name," ",u.last_name) as name from users u where u.user_id=winners.user_id) as name'),
                DB::raw('(select r.restaurant_name from restaurant_details r where r.user_id=winners.restaurant_id) as restaurant'))->get();
        return $query;
    }
    
    public function winnersDetails($id){
        $query = Winner::with(array('user','restaurant' => function($query) {
                        $query->join('restaurant_details as r','r.user_id','=','users.user_id');
                    }))->where('winner_id',$id)->first();
        return $query;
    }
    
}