<?php

use Toddish\Verify\Models\User as VerifyUser;

class User extends VerifyUser {

    public function computer() {
        return $this->belongsToMany('ComputerItem');
    }

}
