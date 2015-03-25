<?php

class ComputerItem extends \Eloquent {

    protected $table = 'computer_item';
    protected $fillable = [];

    public function hsware() {
        return $this->belongsToMany('HswareItem', 'computer_hsware', 'computer_id', 'hsware_id')->withTimestamps();
    }

    public function users() {
        return $this->belongsToMany('User', 'computer_user', 'computer_id', 'user_id')->withTimestamps();
    }
    
    public function software() {
        return $this->belongsToMany('SoftwareItem', 'computer_softeare', 'computer_id', 'software_id')->withTimestamps();
    }
   

}
