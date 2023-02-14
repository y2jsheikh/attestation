<?php
$CI = &get_instance();
$usersrole = $this->session->userdata['logged_in']['role_id'];
//pre($user_menu,1);
?>
<!-- BEGIN SIDEBAR -->
<div id="sidebar-wrapper">
    <div class="sidebar-heading clearfix">
        <a href="<?php echo site_url()?>"><img src="<?php echo base_url('assets/images/logo.png')?>" width="75"></a>
    </div>
    <div class="list-group-flush">
        <?php if ($usersrole == 1) { ?>
            <?php $this->load->view('includes/left/admin'); ?>
        <?php } elseif ($usersrole == 2) { ?>
            <?php $this->load->view('includes/left/role_2'); ?>
        <?php } elseif ($usersrole == 3) { ?>
            <?php $this->load->view('includes/left/courier'); ?>
        <?php } elseif ($usersrole == 4) { ?>
            <?php $this->load->view('includes/left/ministry'); ?>
        <?php } elseif ($usersrole == 5) { ?>
            <?php $this->load->view('includes/left/courier_2'); ?>
        <?php } elseif ($usersrole == 6) { ?>
            <?php $this->load->view('includes/left/dashboard'); ?>
        <?php } ?>
    </div>
</div>
<!-- END SIDEBAR -->