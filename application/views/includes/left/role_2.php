<?php
$CI = &get_instance();
// $usersrole = $this->session->userdata['logged_in']['role_id'];
$user_id = $this->session->userdata['logged_in']['id'];
$uri = $CI->uri->segment(1);
$uri2 = $CI->uri->segment(2);
//pre($user_menu,1);
?>
<a href="<?php echo site_url('dashboard') ?>" class="list-group-item-action-main"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <!-- <i class="fa fa-angle-down" aria-hidden="true"></i> --></a>
<?php /* ?>
<a href="<?php echo site_url('user/edit/'.$user_id) ?>" class="list-group-item-action-main"><i class="fa fa-indent" aria-hidden="true"></i> User</a>
<a href="<?php echo site_url('qualification') ?>" class="list-group-item-action-main"><i class="fa fa-book" aria-hidden="true"></i> Academics</a>
<a href="javascript:;" data-toggle="collapse" data-target="#experience-menu" class="list-group-item-action-main"><i class="fa fa-indent" aria-hidden="true"></i> Experience <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="experience-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('experience') ?>"><i class="fa fa-book" aria-hidden="true"></i> Local</a>
    <a class="left-bar-submenu" href="<?php echo site_url('experience/overseas') ?>"><i class="fa fa-book" aria-hidden="true"></i> Overseas</a>
</div>
<?php */ ?>
<a href="javascript:;" data-toggle="collapse" data-target="#attestation-menu" class="list-group-item-action-main"><i class="fa fa-indent" aria-hidden="true"></i> Attestation <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="attestation-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('user/edit/'.$user_id)/*site_url('attestation/request')*/ ?>"><i class="fa fa-book" aria-hidden="true"></i> Request</a>
    <!--<a class="left-bar-submenu" href="<?php /*echo site_url('attestation') */?>"><i class="fa fa-book" aria-hidden="true"></i> Listing</a>-->
</div>
<a href="javascript:;" data-toggle="collapse" data-target="#courier-centers-menu" class="list-group-item-action-main"><i class="fa fa-building" aria-hidden="true"></i> Courier Center <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="courier-centers-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo base_url('assets/docs/mnp_centers.pdf') ?>"><i class="fa fa-b`uilding-o" aria-hidden="true"></i> M&P<br/>(ICT & Balochistan)</a>
    <a class="left-bar-submenu" href="<?php echo base_url('assets/docs/tcs_centers.pdf') ?>"><i class="fa fa-building-o" aria-hidden="true"></i> TCS<br/>(Rest of Pakistan)<br/>Ph. +923169992971</a>
</div>
