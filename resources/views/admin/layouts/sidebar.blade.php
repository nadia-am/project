<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="/admin" class="nav-link {{ isActive( "admin.","active")}}">
                            <i class="nav-icon fa fa-tachometer"></i>
                            <p>
                                پنل مدیریت
                            </p>
                        </a>
                    </li>
                    @can('show-users')
                        <li class="nav-item has-treeview {{ isActive( [ "admin.users.index" , "admin.users.create", "admin.users.edit"],"menu-open")}}">
                            <a href="#" class="nav-link {{ isActive([ "admin.users.index" , "admin.users.create", "admin.users.edit"],"active")}}">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ isActive( "admin.users.index","active")}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کاربران</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('show-categories')
                        <li class="nav-item has-treeview {{ isActive( [ "admin.categories.index" , "admin.categories.create","admin.categories.edit"],"menu-open")}}">
                            <a href="#" class="nav-link {{ isActive([ "admin.categories.index" , "admin.categories.create","admin.categories.edit"],"active")}}">
                                <i class="nav-icon fa fa-comment"></i>
                                <p>
                                    دسته بندی ها
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ isActive( "admin.categories.index","active")}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست دسته بندی ها</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('show-products')
                        <li class="nav-item has-treeview {{ isActive( [ "admin.products.index" , "admin.products.create" , "admin.products.edit"],"menu-open")}}">
                            <a href="#" class="nav-link {{ isActive([ "admin.products.index" , "admin.products.create", "admin.products.edit"],"active")}}">
                                <i class="nav-icon fa fa-product-hunt"></i>
                                <p>
                                    محصولات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ isActive( "admin.products.index","active")}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست محصولات</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('show-discounts')
                        <li class="nav-item has-treeview {{ isActive( [ "admin.discount.index" , "admin.discount.create" , "admin.discount.edit"],"menu-open")}}">
                            <a href="#" class="nav-link {{ isActive([ "admin.discount.index" , "admin.discount.create","admin.discount.edit"],"active")}}">
                                <i class="nav-icon fa fa-money"></i>
                                <p>
                                    کد تخفیف
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.discount.index') }}" class="nav-link {{ isActive( "admin.discount.index","active")}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کد تخفیف</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('show-orders')
                        <li class="nav-item has-treeview {{ isActive( [ "admin.orders.index" ,"admin.order.show.payments","admin.orders.show"],"menu-open")}}">
                            <a href="#" class="nav-link {{ isActive([ "admin.orders.index","admin.order.show.payments","admin.orders.show" ],"active")}}">
                                <i class="nav-icon fa fa-first-order"></i>
                                <p>
                                    بخش سفارشات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index',['type'=>\App\Models\Order::$STATUS_UNPAID]) }}" class="nav-link {{ isUrl( route("admin.orders.index",['type'=>\App\Models\Order::$STATUS_UNPAID]))}}">
                                        <i class="fa fa-circle-o nav-icon" style="color: yellow"></i>
                                        <p> پرداخت نشده </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index',['type'=>\App\Models\Order::$STATUS_PAID]) }}" class="nav-link {{ isUrl( route("admin.orders.index",['type'=>\App\Models\Order::$STATUS_PAID]))}}">
                                        <i class="fa fa-circle-o nav-icon" style="color: lightseagreen"></i>
                                        <p> پرداخت شده </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index',['type'=>\App\Models\Order::$STATUS_PREPARATION]) }}" class="nav-link {{ isUrl( route("admin.orders.index",['type'=>\App\Models\Order::$STATUS_PREPARATION]))}}">
                                        <i class="fa fa-circle-o nav-icon" style="color: darkolivegreen"></i>
                                        <p> در حال پردازش  </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index' ,['type'=>\App\Models\Order::$STATUS_POSTED]) }}" class="nav-link {{ isUrl( route("admin.orders.index",['type'=>\App\Models\Order::$STATUS_POSTED]))}}">
                                        <i class="fa fa-circle-o nav-icon" style="color: wheat"></i>
                                        <p> ارسال شده </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index' ,['type'=>\App\Models\Order::$STATUS_RECEIVED]) }}" class="nav-link {{ isUrl( route("admin.orders.index",['type'=>\App\Models\Order::$STATUS_RECEIVED]))}}">
                                        <i class="fa fa-circle-o nav-icon" style="color: green"></i>
                                        <p> دریافت شده </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index' ,['type'=>\App\Models\Order::$STATUS_CANCELED]) }}" class="nav-link {{ isUrl( route("admin.orders.index",['type'=>\App\Models\Order::$STATUS_CANCELED]))}}">
                                        <i class="fa fa-circle-o nav-icon" style="color: red"></i>
                                        <p> لغو شده </p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan
                    @can('show-comments')
                        <li class="nav-item has-treeview {{ isActive( [ "admin.comments.index" , "admin.comments.create" , "admin.comments.edit"],"menu-open")}}">
                            <a href="#" class="nav-link {{ isActive([ "admin.comments.index" , "admin.comments.create","admin.comments.edit"],"active")}}">
                                <i class="nav-icon fa fa-comment"></i>
                                <p>
                                    نظرات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.comments.index') }}" class="nav-link {{ isActive( "admin.comments.index","active")}}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست نظرات</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan
                    @canany(['show-permissions','show-roles'])
                        <li class="nav-item has-treeview {{ isActive( [ "admin.permissions.index" , "admin.permissions.create", "admin.permissions.edit","admin.roles.index","admin.roles.edit","admin.roles.create"],"menu-open")}}">
                            <a href="#" class="nav-link {{ isActive([ "admin.permissions.index" , "admin.permissions.create", "admin.permissions.edit","admin.roles.index","admin.roles.edit","admin.roles.create"],"active")}}">
                                <i class="nav-icon fa fa-universal-access"></i>
                                <p>
                                    بخش اجازه دسترسی
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            @can('show-permissions')
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ isActive( ["admin.permissions.index", "admin.permissions.create"],"active")}}">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>لیست دسترسی ها</p>
                                        </a>
                                    </li>
                                </ul>
                            @endcan

                            @can('show-roles')
                                <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ isActive( ["admin.roles.index" ,  "admin.roles.create"],"active")}}">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>لیست نقش ها</p>
                                            </a>
                                        </li>
                                </ul>
                            @endcan
                        </li>
                    @endcanany
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
