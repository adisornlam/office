<?php

class ContactItem extends \Eloquent {

    protected $table = 'contact_item';
    protected $fillable = [];

    public function listall() {
        return $this->belongTo('ContactList');
    }

}
