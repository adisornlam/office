<?php

class Roles extends \Eloquent {

    protected $table = 'roles';
    protected $fillable = [];

    public function menu() {
        return $this->belongsToMany('Menu', 'menu_role', 'role_id', 'menu_id')->withTimestamps();
    }

}
