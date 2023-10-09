<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $guarded = [];

    CONST LARGE_IMAGE_WIDTH = 1080;
    CONST LARGE_IMAGE_HEIGHT = 675;

    CONST MEDIUM_IMAGE_WIDTH = 512;
    CONST MEDIUM_IMAGE_HEIGHT = 320;

    CONST SMALL_IMAGE_WIDTH = 256;
    CONST SMALL_IMAGE_HEIGHT = 200;
    CONST RESIZE_BANNER_WIDTH = 512;
    CONST RESIZE_BANNER_HEIGHT = 150;

}
