<?php

class Department extends \Eloquent {

    protected $table = 'department';
    protected $fillable = [];

    public function hierarchy() {
        return $this->hasMany('Departmenthierarchy');
    }

}
