<?php

namespace App\View\Components;

use App\Models\Module;
use App\Models\Setting;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $data = [
            'setting' => new Setting(),
            'module' => new Module(),
        ];
        return view('layouts.app', $data);
    }
}
