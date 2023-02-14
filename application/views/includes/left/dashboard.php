<?php
$CI = &get_instance();
$usersrole = $this->session->userdata['logged_in']['role_id'];
$user_id = $this->session->userdata['logged_in']['id'];
$uri = $CI->uri->segment(1);
$uri2 = $CI->uri->segment(2);
?>

<a href="<?php echo site_url('dashboard') ?>" class="list-group-item-action-main"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <!-- <i class="fa fa-angle-down" aria-hidden="true"></i> --></a>
<!--<a href="javascript:void(0)" id="print_btn" class="list-group-item-action-main"><i class="fa fa-file" aria-hidden="true"></i> Print</a>-->
