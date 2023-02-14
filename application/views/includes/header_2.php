<?php $CI =& get_instance();
$user_id = $CI->session->userdata['logged_in']['id'];
$usersrole = $CI->session->userdata['logged_in']['role_id'];
$fullname = $CI->session->userdata['logged_in']['fullname'];
$user_picture = $usersrole == 2 ? getsinglefield('tbl_users','picture','WHERE id = "'.$user_id.'"'): '';
?>
<div class="sticky-top">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav ml-auto mr-5">
            <li class="nav-item dropdown ">
                <a style="color: white;" class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    Welcome <?php echo isset($fullname) && $fullname != '' ? $fullname : 'User'; ?>
                    <img style="margin-left: 10px;display: inline-block;" src="<?php echo base_url('assets/images/7.png'); ?>" alt="logo">
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url('logout') ?>">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
</div>
<!-- /Navbar -->

<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->