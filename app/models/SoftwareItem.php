<?php

class SoftwareItem extends \Eloquent {

    protected $table = 'software_item';
    protected $fillable = [];

    public function computer() {
        return $this->belongsToMany('ComputerItem');
    }

}
