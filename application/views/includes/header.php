<?php $CI =& get_instance();
$user_id = $CI->session->userdata['logged_in']['id'];
$usersrole = $CI->session->userdata['logged_in']['role_id'];
$fullname = $CI->session->userdata['logged_in']['fullname'];
$user_picture = $usersrole == 2 ? getsinglefield('tbl_users','picture','WHERE id = "'.$user_id.'"'): '';
?>
<nav class="navbar navbar-expand-lg navbar-light nav-bg fixed-top">
<!--    <a href="javascript:;" class="trapezoid" id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>-->
    <h3>Ministry of National Health Services, Regulations & Coordination Islamabad</h3>
    <div class="navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Welcome <?php echo isset($fullname) && $fullname != '' ? $fullname : 'User'; ?>
                <?php if ($usersrole == 2){ ?>
                    <?php if ($user_picture != '' && $user_picture != 0){ ?>
                        <img style="margin-left: 10px;display: inline-block; min-width: 30px; max-width: 30px; max-height: 30px; max-height: 30px;" src="<?php echo base_url('uploads/user_image/'.$user_picture); ?>" class="img-rounded" alt="logo">
                    <?php }else{ ?>
                        <img style="margin-left: 10px;display: inline-block;" src="<?php echo base_url('assets/images/7.png'); ?>" alt="logo">
                    <?php } ?>
                <?php }else{ ?>
                    <img style="margin-left: 10px;display: inline-block;" src="<?php echo base_url('assets/images/7.png'); ?>" alt="logo">
                <?php } ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="list-group-item-action-main" href="<?php echo site_url('change_password') ?>">Change Password</a>
                    <a class="list-group-item-action-main" href="<?php echo site_url('logout') ?>">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>


<nav class="navbar navbar-default navbar-inverse" id="navpad">
    <!-- Navbar -->
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">IC</a> <!-- Brand -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- Links -->
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home<span class="sr-only">(Current)</span></a></li>
                    <li><a href="#">Nosotros</a></li>
                    <li class="dropdown">
                        <!-- Dropdown -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">Ministerios<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Ministerio 1</a></li>
                            <li><a href="#">Ministerio 2</a></li>
                            <li><a href="#">Ministerio 3</a></li>
                            <li><a href="#">Ministerio 4</a></li>
                            <li><a href="#">Ministerio 5</a></li>
                        </ul>
                    </li>
                    <!-- /Dropdown -->
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Miembros</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
            <!-- /Navbar Collapse -->
        </div>
        <!-- /Navbar Header -->
    </div>
    <!-- /Container-fluid -->
</nav>
<!-- /Navbar -->

<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->