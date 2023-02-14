<?php
$CI = &get_instance();
$usersrole = $this->session->userdata['logged_in']['role_id'];
$uri = $CI->uri->segment(1);
$uri2 = $CI->uri->segment(2);
$user_menu = user_menu();
//pre($user_menu,1);
?>
<a href="<?php echo site_url('dashboard') ?>" class="list-group-item-action-main"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <!-- <i class="fa fa-angle-down" aria-hidden="true"></i> --></a>
<a href="<?php echo site_url('user') ?>" class="list-group-item-action-main"><i class="fa fa-indent" aria-hidden="true"></i> User</a>
<?php /* ?>
<a href="<?php echo site_url('qualification') ?>" class="list-group-item-action-main"><i class="fa fa-book" aria-hidden="true"></i> Academics</a>
<a href="javascript:;" data-toggle="collapse" data-target="#experience-menu" class="list-group-item-action-main"><i class="fa fa-indent" aria-hidden="true"></i> Experience <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="experience-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('experience') ?>"><i class="fa fa-book" aria-hidden="true"></i> Local</a>
    <a class="left-bar-submenu" href="<?php echo site_url('experience/overseas') ?>"><i class="fa fa-book" aria-hidden="true"></i> Overseas</a>
</div>
<a href="javascript:;" data-toggle="collapse" data-target="#attestation-menu" class="list-group-item-action-main"><i class="fa fa-indent" aria-hidden="true"></i> Attestation <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="attestation-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('attestation') ?>"><i class="fa fa-book" aria-hidden="true"></i> Listing</a>
</div>
<?php */ ?>
<a href="javascript:;" data-toggle="collapse" data-target="#report-menu" class="list-group-item-action-main"><i class="fa fa-indent" aria-hidden="true"></i> Report <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="report-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('report') ?>"><i class="fa fa-book" aria-hidden="true"></i> Report</a>
    <a class="left-bar-submenu" href="<?php echo site_url('report/email_log') ?>"><i class="fa fa-book" aria-hidden="true"></i> Email Log</a>
</div>
