<?php

class HswareItem extends \Eloquent {

    protected $table = 'hsware_item';
    protected $fillable = [];

    public function computer() {
        return $this->belongsToMany('ComputerItem');
    }

    protected function get_hsware($param) {
        $option = \DB::table('hsware_item')
                ->join('hsware_spec_label', 'hsware_item.group_id', '=', 'hsware_spec_label.group_id')
                ->where('hsware_item.id', $param)
                ->where('hsware_item.group_id', '!=', 2)
                ->select('hsware_item.*', 'hsware_spec_label.title as title', 'hsware_spec_label.option_id as option_id', 'hsware_spec_label.name as name')
                ->get();
        $str = '';
        foreach ($option as $item_option) {
            if ($item_option->option_id != 0) {
                $val = $item_option->{$item_option->name};
                $q = \HswareSpecOptionItem::find($val);
                if ($q) {
                    $v = $q->title;
                } else {
                    $v = '';
                }
            } else {
                $v = $item_option->{$item_option->name};
            }
            $str .= $v . ' ';
        }
        return $str . ' ';
    }

    protected function get_submodel($param) {
        $model = \HswareModel::find($param);
        if ($model) {
            $rs = $model->title;
        } else {
            $rs = '';
        }
        return $rs;
    }

}
