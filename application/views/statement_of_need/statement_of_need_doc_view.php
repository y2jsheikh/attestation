<html>
<head>
    <title></title>
    <style>
        .text-center{
            text-align: center;
        }
        .container{
            padding-right: 4%;
            padding-bottom: 4%;
            padding-left: 4%;
        }
    </style>
</head>
<body>
<div>
    <img src="<?php echo base_url('assets/images/logo_text.png') ?>">
</div>
<div class="container">
    <!--
    <div style="float: left;">
        <img src="<?php echo base_url('assets/images/govlogo_mini.png') ?>">
    </div>
    <div style="float: right;">
        <h3 class="text-center">
            <img src="<?php echo base_url('assets/images/govlogo_mini.png') ?>">
            <strong>Government of Pakistan<br/>
                Ministry of National Health Services, Regulations & Coordination<br/>Attestation Section
            </strong>
        </h3>
    </div>
    -->
    <div style="clear: both;"></div>
    <div>
        <h4><strong>No. F11-1/2013-NHS R&C/NOC</strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong>Serial Number: 20/2022</h4>
        <h4> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Islamabad, <?php echo date('F d, Y', time()); ?></strong></h4>
        <!--<h5 style="text-align: right;"><strong>Serial Number: 20/2022<br/>Islamabad, <?php /*echo date('F d, Y', time()); */?></strong></h5>-->
    </div>
    <div style="clear: both;"></div>
    <?php
    $heading = "Statement of Need";
    $need = "a need";
    if ($result->is_special_need == 'Y'){
        $heading = "Statement of Exceptional Need";
        $need = "an exceptional need";
    }else{
        $heading = "Statement of Need";
        $need = "a need";
    }
    ?>
    <h2 class="text-center"><strong><u><?php echo $heading ?></u></strong></h2><br/><br/>
    <div>
        <p><b>USMLE/ECFMG ID Number: <?php echo $result->ecfmg_no ?></b></p>
        <p><b>Name of Applicant for Visa: <?php echo $result->fullname ?></b></p>
        <p>
            There currently exists in Pakistan <?php echo $need ?> for qualified medical practitioners in the
            speciality of <?php echo $result->speciality ?>. <?php echo ucfirst($result->fullname) ?> has filed a written
            assurance with the government of this country that <?php echo $result->gender == 'Female' ? 'she' : 'he'; ?> will return to this country
            upon completion of training in the United States and intends to enter the practice of
            medicine in the speciality for which training is being sought.
        </p>
        <p>
            This letter is valid for above said medical education program.
        </p>
        <br/>
    </div>
    <div style="clear: both;"></div>
    <div>
        <p style="text-align: right;">(<?php echo $result->signatory != '' ? $result->signatory : 'Dr. Nusrat Haider'; ?>)<br/><?php echo $result->signatory_designation != '' ? $result->signatory_designation : 'Assistant Director'; ?><br/><?php echo $result->signatory_department != '' ? $result->signatory_department : ''; ?></p>
    </div>

</div>

</body>
</html>

