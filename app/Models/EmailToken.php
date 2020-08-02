<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailToken extends Model
{
    protected $table = 'email_tokens';

    public $timestamps = false;

    protected $dates = ['expires'];

    protected $fillable = [
        'email',
        'code',
        'expires',
    ];

    public function isExpired()
    {

    }

}
