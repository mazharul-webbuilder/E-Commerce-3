<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeGame extends Model
{
    use HasFactory;


    // protected $connection = 'lara_ludo_livedata'; // Specify the connection name
    protected $connection = 'mysql2';

    protected $table = 'gamedata'; // Specify the table name

}
