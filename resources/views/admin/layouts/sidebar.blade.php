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
                <div class="image">
                    <img src="https://www.gravatar.com/avatar/52f0fbcbedee04a121cba8dad1174462?s=200&d=mm&r=g" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">حسام موسوی</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('admin.') }}" class="nav-link {{ isActive( "admin.","active")}}">
                            <i class="nav-icon fa fa-tachometer"></i>
                            <p>
                                پنل مدیریت
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{ isActive( [ "admin.users.index" , "admin.users.create"],"menu-open")}}">
                        <a href="#" class="nav-link {{ isActive([ "admin.users.index" , "admin.users.create"],"active")}}">
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
                    <li class="nav-item has-treeview {{ isActive( [ "admin.permissions.index" , "admin.permissions.create", "admin.permissions.edit","admin.roles.index","admin.roles.edit"],"menu-open")}}">
                        <a href="#" class="nav-link {{ isActive([ "admin.permissions.index" , "admin.permissions.create", "admin.permissions.edit","admin.roles.index","admin.roles.edit"],"active")}}">
                            <i class="nav-icon fa fa-universal-access"></i>
                            <p>
                                بخش اجازه دسترسی
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ isActive( "admin.permissions.index","active")}}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست دسترسی ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link {{ isActive( ["admin.roles.index" ,  "admin.roles.create"],"active")}}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست نقش ها</p>
                                </a>
                            </li>

                        </ul>
                    </li>


                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
