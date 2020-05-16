<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav" id="menu-control-button">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a id="logout" class="nav-link" href="#">
                <i class="fa fa-sign-out fa-lg"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url(); ?>dist/img/operator.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo base_url(); ?>" class="d-block">
                    <?php
                    if ($this->session->userdata(models\Operator::KEY_LAST_NAME) ||
                        $this->session->userdata(models\Operator::KEY_FIRST_NAME))
                    {
                        echo $this->session->userdata(models\Operator::KEY_LAST_NAME) .' '.
                            $this->session->userdata(models\Operator::KEY_FIRST_NAME);
                    } else {
                        echo $this->session->userdata(models\Operator::KEY_LOGIN);
                    }
                    ?>
                </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if ($this->session->userdata(models\Operator::KEY_ROLE_ID) == models\Role::ID_ADMIN): ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-gears"></i>
                        <p>
                            Управление
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>operator" class="nav-link">
                                <i class="fa fa-user nav-icon"></i>
                                <p>Операторы</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <li class="nav-header">Меню</li>
                <?php foreach ($categories as $category): ?>
                <?php if ($category->getRole()->getId() <= $this->session->userdata(models\Operator::KEY_ROLE_ID)): ?>
                <li class="nav-item">
                    <a href="<?php echo $category->getUrl(); ?>" class="nav-link">
                        <i class="<?php echo $category->getIcons(); ?>"></i>
                        <p><?php echo $category->getTitle(); ?></p>
                    </a>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>