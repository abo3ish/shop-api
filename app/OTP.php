<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{

    protected $table = 'otp';

    protected $fillable = ['code', 'user_id'];

    public static function createCode()
    {
        self::where('user_id', auth()->id())->delete();

        $code = random_int(1000, 9999);

        self::create([
            'code' => $code,
            'user_id' => auth()->id()
        ]);

        return $code;
    }

}
