<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'username';
    public $incrementing = false; 
    protected $fillable = ['nama', 'username', 'password'];
    public $timestamps = false;
}
