<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class content extends Component
{
    /**
     * Create a new component instance.
     *
     * @param $title
     * @param $main
     * @param $breadcrumbs
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content');
    }
}
