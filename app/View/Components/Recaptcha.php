<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Recaptcha extends Component
{
    public $sitr_key;
    public $type;

    /**
     * Create a new component instance.
     *
     * @param $type
     */
    public function __construct($type)
    {
        $this->sitr_key = env('RECAPTCHA_SITE_KEY');
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.recaptcha');
    }
}
