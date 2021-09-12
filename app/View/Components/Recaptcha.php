<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Recaptcha extends Component
{
    public $site_key;
    public $type;

    /**
     * Create a new component instance.
     *
     * @param $type
     */
    public function __construct($type)
    {
        $this->site_key = env('RECAPTCHA_SITE_KEY') ?? '6LfqHdkaAAAAADbECthx2AXQw7w1_1FAtdbs_nu2';
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
