<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    public $fillable = ['model','ram_size','ram_unit','ram_type','storage_size','storage_unit','storage_number','storage_type_id','location_id','price','currency'];
}
