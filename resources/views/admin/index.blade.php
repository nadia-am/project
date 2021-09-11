@component('admin.layouts.content',['title'=>'پنل ادمین'])
    @slot('breadcrums')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item active">داشبورد دوم</li>
    @endslot
@endcomponent
