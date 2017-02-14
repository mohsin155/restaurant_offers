<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Utility\Utility;
use App\Models\Details;
use App\Models\Winner;
class BillingController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }
    
    public function getWinnersList(){
        $winner =  new Winner();
        $winners = $winner->winnersList();
        return view('billing/winners-list')->with('winners',$winners);
    }
    
    public function getWinnersDetail($id){
        $winner =  new Winner();
        $winner_detail = $winner->winnersDetails($id);
        return view('billing/winner-detail')->with('winner',$winner_detail);
    }
}