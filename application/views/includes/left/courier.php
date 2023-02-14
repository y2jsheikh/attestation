<?php
$CI = &get_instance();
$usersrole = $this->session->userdata['logged_in']['role_id'];
$user_id = $this->session->userdata['logged_in']['id'];
$uri = $CI->uri->segment(1);
$uri2 = $CI->uri->segment(2);
?>
<a href="javascript:;" data-toggle="collapse" data-target="#attestation-menu" class="list-group-item-action-main"><i class="fa fa-indent" aria-hidden="true"></i> Attestation <i style="float: right;margin-right: 0;" class="fa fa-angle-down" aria-hidden="true"></i></a>
<div id="attestation-menu" class="collapse left-bar-main-collapse">
    <a class="left-bar-submenu" href="<?php echo site_url('attestation/user_submitted') ?>"><i class="fa fa-book" aria-hidden="true"></i> Receive</a>
    <a class="left-bar-submenu" href="<?php echo site_url('attestation/ministry_dispatched') ?>"><i class="fa fa-book" aria-hidden="true"></i> Return</a>
</div>
<a href="<?php echo site_url('courier/centers/tcs') ?>" class="list-group-item-action-main"><i class="fa fa-building" aria-hidden="true"></i> Courier Centers</a>
<a href="<?php echo site_url('report/courier_sent/3') ?>" class="list-group-item-action-main"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Report</a>
