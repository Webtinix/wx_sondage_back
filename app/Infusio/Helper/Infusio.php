<?php

namespace App\Infusio\Helper;

class Infusio {

    public function renderComponent($component) {
        return app('App\\Infusio\\Component\\' . $component);
    }
}
