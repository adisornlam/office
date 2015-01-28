<?php

class DomainItem extends \Eloquent {

    protected $table = 'domain_item';
    protected $fillable = [];

    public function server() {
        return $this->belongsToMany('ServerItem', 'domain_server', 'domain_id', 'server_id')->withTimestamps();
    }

}
