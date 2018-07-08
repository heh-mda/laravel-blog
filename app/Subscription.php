<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public static function add($email)
    {
        $sub = new self;
        $sub->email = $email;
        $sub->save();

        return $sub;
    }

    public function remove()
    {
        $this->delete();
    }

    public function generateToken()
    {
        $this->token = str_random(100);
        $this->save();
    }

    public function removeToken()
    {
        $this->token = null;
        $this->save();
    }
}
