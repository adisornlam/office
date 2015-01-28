<?php

class ContactList extends \Eloquent {

    protected $table = 'contact_list';
    protected $fillable = [];

    public function itemall() {
        return $this->hasMany('ContactItem', 'contact_id');
    }

}
