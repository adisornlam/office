<?php

class HswareModel extends \Eloquent {

    protected $table = 'hsware_model';
    protected $fillable = [];

    protected function getName($param) {
        $item = \HswareModel::find($param);
        if ($item) {
            $rs = $item->title;
        } else {
            $rs = '';
        }
        return $rs;
    }

}
