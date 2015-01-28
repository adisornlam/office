<?php

class ContactType extends \Eloquent {

    protected $table = 'contact_type';
    protected $fillable = [];

    public function listsall() {
        return $this->hasMany('ContactList', 'contact_type');
    }

}
