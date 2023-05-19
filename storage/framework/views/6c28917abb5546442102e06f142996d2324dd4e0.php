<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">
            <div class="menu-profile">
                <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu">
                    <div class="menu-profile-cover with-shadow"></div>
                    <div class="menu-profile-image">
                        <img src="<?php echo e(asset('img/user/user-13.jpg')); ?>" alt=""/>
                    </div>
                    <div class="menu-profile-info">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                Sean Ngu
                            </div>
                            <div class="menu-caret ms-auto"></div>
                        </div>
                        <small>Front end developer</small>
                    </div>
                </a>
            </div>
            <div id="appSidebarProfileMenu" class="collapse">
                <div class="menu-item pt-5px">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-cog"></i></div>
                        <div class="menu-text">Settings</div>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-pencil-alt"></i></div>
                        <div class="menu-text"> Send Feedback</div>
                    </a>
                </div>
                <div class="menu-item pb-5px">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-question-circle"></i></div>
                        <div class="menu-text"> Helps</div>
                    </a>
                </div>
                <div class="menu-divider m-0"></div>
            </div>
            <div class="menu-header">Navigation</div>
            <div class="menu-item has-sub <?php echo e((Route::currentRouteName() == 'manage.user.index'?'active':'')); ?>">
                <a href="javascript:;" class="menu-link">
                    <div class="menu-icon">
                        <i class="ion-ios-pulse"></i>
                    </div>
                    <div class="menu-text">Dashboard</div>
                    <div class="menu-caret"></div>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="index.html" class="menu-link"><div class="menu-text">Dashboard v1</div></a>
                    </div>
                    <div class="menu-item">
                        <a href="index_v2.html" class="menu-link"><div class="menu-text">Dashboard v2</div></a>
                    </div>
                </div>
            </div>
            <div class="menu-item <?php echo e((Route::currentRouteName() == 'manage.level.index'?'active':'')); ?>">
                <a href="javascript:;" class="menu-link">
                    <div class="menu-icon"><i class="fa-solid fa-user-gear"></i></div>
                    <div class="menu-text"> Manage Levels</div>
                </a>
            </div>
            
            <!-- BEGIN minify-button -->
            <div class="menu-item d-flex">
                <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="ion-ios-arrow-back"></i> <div class="menu-text">Collapse</div></a>
            </div>
            <!-- END minify-button -->
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>
<!-- END #sidebar --><?php /**PATH C:\laragon\www\standardization\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>