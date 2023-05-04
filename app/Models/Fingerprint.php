<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Fingerprint extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $casts = ["name" => 'string', "serial_number" => "string", "is_active" => "boolean"];

  
}
