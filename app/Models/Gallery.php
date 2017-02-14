<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gallery extends Model {
    
    protected $primaryKey = 'image_id';
    protected $table = 'gallery';
}