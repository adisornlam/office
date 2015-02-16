<?php

class ComputerItem extends \Eloquent {

    protected $table = 'computer_item';
    protected $fillable = [];

    public function hsware() {
        return $this->belongsToMany('HswareItem');
    }

}
