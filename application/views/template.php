<?php
$CI = &get_instance();
$role_id = 0;
if (isset($this->session->userdata['logged_in'])) {
$role_id = $this->session->userdata['logged_in']['role_id'];
//pre($user_menu,1);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico'); ?>"/>
    <title>Attestation | <?php echo $title; ?> </title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Custom styles for this template -->
   <!-- <link href="<?php /*echo base_url('assets/css/style.css'); */?>" rel="stylesheet">-->
    <link href="<?php echo base_url('assets/css/style_new.css?v='.uniqid()); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/components.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/dashboard.css?v='.uniqid()); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/select2.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <!--
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/select2.full.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.mask.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.table2excel.js'); ?>"></script>

    <script src="<?php echo base_url('assets/js/highcharts.js'); ?>"></script>
    <!--
    <script src="https://code.highcharts.com/highcharts.js"></script>
    -->
    <!-- Datepicker Links -->
    <link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet"  type="text/css"/>
    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
    <!-- / Datepicker Links -->
    <script src="<?php echo base_url('assets/js/attestation.js'); ?>" type="text/javascript" ></script>
    <script src="<?php echo base_url('assets/js/jquery.table2excel.js'); ?>" type="text/javascript" ></script>
    <script src="<?php echo base_url('assets/js/anime.min.js'); ?>" type="text/javascript" ></script>
    <style>
        .nowrap{white-space: nowrap;}
        .desktop-minus-5-top-margin { margin-top: -5%; }
        .font-hg {
            font-size: 23px;
        }
        .font-lg {
            font-size: 18px;
        }
        .font-md {
            font-size: 14px;
        }
        .font-sm {
            font-size: 13px;
        }
        .font-xs {
            font-size: 11px;
        }
        .bg-red {
            background: #e7505a !important;
        }
        .bg-font-green-soft {
            color: #FFFFFF !important;
        }
        .bg-green {
            background: #32c5d2 !important;
            color: white;
        }
        .bg-font-red-soft {
            color: #FFFFFF !important;
        }
        .requriedstar {
            color: #ff2825 !important;
        }
        .makeRed {
            box-shadow: 1px 1px 2px #ffd2dc, 0 0 25px #ff2825, 0 0 5px white;
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .link-to-list{
            text-decoration: none !important;
        }
        .text-light-danger {
            color: #ff5862 !important;
        }
        .text-lighter-danger {
            color: #ba693d !important;
        }
    </style>
</head>
<body>
<script>

    /*
    if (document.addEventListener) {
        document.addEventListener('contextmenu', function(e) {
       //    alert("You've tried to open context menu"); //here you draw your own menu
            e.preventDefault();
        }, false);
    } else {
        document.attachEvent('oncontextmenu', function() {
        //   alert("No Peeking...!");
            window.event.returnValue = false;
        });
    }

    document.onkeydown = function(e) {
        if(event.keyCode == 123) {
            alert("You've tried to open context menu");
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
            alert("You've tried to open context menu");
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
            alert("You've tried to open context menu");
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
            alert("You've tried to open context menu");
            return false;
        }
        if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
            alert("You've tried to open context menu");
            return false;
        }
    }
    */

$(document).ready(function(){
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
    $('[data-toggle="popover"]').popover();
//    $('.toast').toast({animation: false, delay: 2000});
    $('.toast').toast({delay: 2000});
    $('.toast').toast('show');
});
</script>
<div id="wrapper">
    <?php $this->load->view('includes/left'); ?>
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <?php $this->load->view('includes/header'); ?>
        <div class="desktop-minus-5-top-margin hidden-xs"></div>
        <div class="dashboard-middle-content">
            <?php echo $content; ?>
        </div>
        <!-- Content Wrapper. Contains page content -->
        <!-- /.content-wrapper -->
        <?php $this->load->view('includes/footer'); ?>
    </div>

</div>
</body>
</html>