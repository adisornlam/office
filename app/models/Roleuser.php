<?php

class Roleuser extends \Eloquent {

    protected $table = 'role_user';

    public function user() {
        return $this->belongsTo('User');
    }

}
