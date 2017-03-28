<?php

namespace App;

use App\LayoutItem;

class LayoutItemLink extends LayoutItem{
    public function __construct(array $attributes = array()){
        parent::__construct($attributes);
        $this->type = "service_group";
    }
}
