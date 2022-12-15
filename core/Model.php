<?php

namespace app\core;

/**
* class Model
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core
*/

abstract class Model {


    public function loadData($data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}