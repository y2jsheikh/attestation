<?php
$CI = &get_instance();
$usersrole = $this->session->userdata['logged_in']['role_id'];
$user_id = $this->session->userdata['logged_in']['id'];
$uri = $CI->uri->segment(1);
$uri2 = $CI->uri->segment(2);

?>
<a href="<?php echo site_url('dashboard') ?>" class="list-group-item-action-main"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <!-- <i class="fa fa-angle-down" aria-hidden="true"></i> --></a>
<a href="<?php echo site_url('user') ?>" class="list-group-item-action-main"><i class="fa fa-users" aria-hidden="true"></i> Candidates</a>

<a href="javascript:;" data-toggle="collapse" data-target="#signatory-menu" class="list-group-item-action-main"><i class="fa fa-user" aria-hidden="true"></i> Signatory <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="signatory-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('signatory') ?>"><i class="fa fa-book" aria-hidden="true"></i> List</a>
    <a class="left-bar-submenu" href="<?php echo site_url('signatory/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add</a>
</div>

<a href="javascript:;" data-toggle="collapse" data-target="#attestation-menu" class="list-group-item-action-main"><i class="fa fa-file" aria-hidden="true"></i> Attestation <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="attestation-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('attestation/scheduled') ?>"><i class="fa fa-book" aria-hidden="true"></i> Scheduled</a>
    <!--<a class="left-bar-submenu" href="<?php /*echo site_url('user') */?>"><i class="fa fa-book" aria-hidden="true"></i> Add Document</a>-->
    <a class="left-bar-submenu" href="<?php echo site_url('attestation/receive') ?>"><i class="fa fa-book" aria-hidden="true"></i> Receive</a>
    <a class="left-bar-submenu" href="<?php echo site_url('attestation/ministry_received') ?>"><i class="fa fa-book" aria-hidden="true"></i> Requests</a>
    <a class="left-bar-submenu" href="<?php echo site_url('attestation/dispatch') ?>"><i class="fa fa-book" aria-hidden="true"></i> Dispatch</a>
</div>
<a href="javascript:;" data-toggle="collapse" data-target="#report-menu" class="list-group-item-action-main"><i class="fa fa-indent" aria-hidden="true"></i> Report <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="report-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('report') ?>"><i class="fa fa-book" aria-hidden="true"></i> Applications</a>
    <a class="left-bar-submenu" href="<?php echo site_url('report/processed') ?>"><i class="fa fa-book" aria-hidden="true"></i> Processed</a>
</div>
<a href="javascript:;" data-toggle="collapse" data-target="#courier-centers-menu" class="list-group-item-action-main"><i class="fa fa-building" aria-hidden="true"></i> Courier Center <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="courier-centers-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo base_url('assets/docs/mnp_centers.pdf') ?>"><i class="fa fa-b`uilding-o" aria-hidden="true"></i> M&P<br/>(ICT & Balochistan)</a>
    <a class="left-bar-submenu" href="<?php echo base_url('assets/docs/tcs_centers.pdf') ?>"><i class="fa fa-building-o" aria-hidden="true"></i> TCS<br/>(Rest of Pakistan)<br/>Ph. +923169992971</a>
</div>
<a href="javascript:;" data-toggle="collapse" data-target="#statement-of-need-menu" class="list-group-item-action-main"><i class="fa fa-user-circle-o" aria-hidden="true"></i> SoN <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="statement-of-need-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('statement/receive') ?>"><i class="fa fa-book" aria-hidden="true"></i> Receive</a>
    <a class="left-bar-submenu" href="<?php echo site_url('statement') ?>"><i class="fa fa-book" aria-hidden="true"></i> Requests</a>
</div>
