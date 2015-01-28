<?php

class Departmenthierarchy extends \Eloquent {

    protected $table = 'department_hierarchy';
    public $timestamps = false;

    public function department() {
        return $this->belongsTo('Department', 'department_id');
    }

}
