<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-success elevation-4">
                <!-- Brand Logo -->
                <a href="/" class="brand-link">
                <img src="{{asset('stikes')}}/logo.png" alt="AdminLTE Logo" class="brand-image" style="opacity: 0.8;" />
                    <span class="brand-text font-weight-light">Super Admin</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                            <li class="nav-item">
                            <a href="{{ route('superadmin.dataBarang') }}" class="nav-link ">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                     
                            </li>
                            
                            
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
                
            </aside>