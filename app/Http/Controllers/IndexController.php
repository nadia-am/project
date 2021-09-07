<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('صفحه اصلی');
        $this->seo()->setDescription('این یک فروشگه تست برای یادگیری بهتر لاراول می باشد');
        return view('index');

    }
}
