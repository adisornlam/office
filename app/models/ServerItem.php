<?php

class ServerItem extends \Eloquent {

    protected $table = 'server_item';
    protected $fillable = [];

    public function domain() {
        return $this->belongsToMany('DomainItem');
    }

}
