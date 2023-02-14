<form name="" method="post" action="">
<input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
<table class="table table-data-new">
    <thead>
<?php
    if ($current_status == 'courier_received'){
        $function = "Receive";
    }elseif ($current_status == 'ministry_received'){
        $function = "Dispatch";
    }else{
        $function = "Receive";
    }
?>
    <tr>
        <th> <?php echo $function ?></th>
        <th> Application No.</th>
        <th> Full Name</th>
        <th> Father Name</th>
        <th> CNIC</th>
        <th> Contact No.</th>
        <th> Occupation</th>
        <th> Submit Date </th>
    </tr>
    </thead>
    <tbody>
        <?php
        $class = 'even';
        $i = 1;
        $counter = 0;
        //pre($result);
        if (is_array($result) && count($result) > 0):
            foreach ($result as $r):
//            pre($r,1);
        ?>
            <tr title="Click here to View Documents" role="row" class="<?php echo ($class == 'even' ? 'odd' : 'even') ?>">
                <td>
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                               class="custom-control-input"
                               name="is_checked_<?php echo $counter ?>"
                               id="is_checked_<?php echo $counter ?>"
                               data-toggle="collapse"
                               data-target="#docs_<?php echo $i ?>"
                               class="accordion-toggle">
                        <label class="custom-control-label" for="is_checked_<?php echo $counter ?>"></label>
                    </div>
                    <div>
                        <!-- Attestation Information / -->
                        <input type="hidden" value="<?php echo $r['id'] ?>" name="attest_id[]" id="attest_id_<?php echo $counter ?>">
                        <input type="hidden" value="<?php echo $r['app_number'] ?>" name="app_number[]" id="app_number_<?php echo $counter ?>">
                        <input type="hidden" value="<?php echo $r['status'] ?>" name="status[]" id="status_<?php echo $counter ?>">
                        <input type="hidden" value="<?php echo $r['source'] ?>" name="source[]" id="source_<?php echo $counter ?>">
                        <!-- / Attestation Information -->
                        <!-- Personal Information / -->
                        <input type="hidden" value="<?php echo $r['fullname'] ?>" name="fullname[]" id="fullname_<?php echo $counter ?>">
                        <input type="hidden" value="<?php echo $r['cnic'] ?>" name="cnic[]" id="cnic_<?php echo $counter ?>">
                        <input type="hidden" value="<?php echo $r['email'] ?>" name="email[]" id="email_<?php echo $counter ?>">
                        <!-- / Personal Information -->
                    </div>
                </td>
                <td> <b class="text-success"><?php echo $r['app_number']; ?></b> </td>
                <td> <?php echo $r['fullname']; ?> </td>
                <td> <?php echo $r['father_name']; ?> </td>
                <td> <?php echo $r['cnic']; ?> </td>
                <td> <?php echo $r['contact_number']; ?> </td>
                <td> <?php echo $r['occupation']; ?> </td>
                <td> <?php echo date('m/d/Y', $r['attest_request_date']); ?> </td>
            </tr>
            <tr>
                <td colspan="8" class="hiddenRow">
                    <?php $documents = get_application_documents($r['id']) ?>
                    <div id="docs_<?php echo $i ?>" class="accordian-body collapse p-3">
                    <?php if (!empty($documents)){ ?>
                        <?php foreach ($documents as $document){ ?>
                            <p><b><?php echo $document->qualification ?></b> <span>(<?php echo $document->doc_type ?>)</span></p>
                        <?php } ?>
                    <?php } ?>
                    </div>

                </td>
            </tr>
        <?php
            $i++;
            $counter++;
            endforeach;
        ?>
        <?php
        else:
        ?>
            <tr>
                <th scope="row" colspan="10">
                    <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;" class="alert alert-danger " role="alert">
                        <strong>NO DATA FOUND</strong></div>
                </th>
            </tr>
        <?php
        endif;
        ?>
    </tbody>
</table>

<?php if (is_array($result) && count($result) > 0): ?>
    <div class="row-fluid">
        <div class="col-md-12 col-sm-3 col-xs-3">
            <br/>
            <button type="submit" class="btn btn-info pull-right">
                <i class="fa fa-check"></i> Submit
            </button>
            <br/><br/>
        </div>
    </div>
</form>
<?php endif; ?>

<script>
    anime({
        targets: '.custom-switch',
        scale: [
            {value: .1, easing: 'easeOutSine', duration: 600},
            {value: 1, easing: 'easeInOutQuad', duration: 1200}
        ],
        delay: anime.stagger(200, {grid: [14, 5], from: 'center'})
    });
</script>