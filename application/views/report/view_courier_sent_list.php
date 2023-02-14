<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <th> Application No.</th>
        <th> CN#</th>
        <th> Received By</th>
        <th> Document(s)</th>
        <th> Applicant</th>
        <th> CNIC</th>
        <th> Contact No.</th>
        <th> Occupation</th>
        <th> Courier Receive Date </th>
        <th> Submit Date </th>
    </tr>
    </thead>
    <tbody>
        <?php
        $class = 'even';
        $i = 1;
        //pre($result);
        if (is_array($result) && count($result) > 0):
            foreach ($result as $r):
//            pre($r,1);
                ?>
                <tr role="row" class="<?php echo ($class == 'even' ? 'odd' : 'even') ?>">
                    <td> <b><?php echo $i; ?></b> </td>
                    <td> <b class="text-success"><?php echo $r['app_number']; ?></b> </td>
                    <td> <b class="text-info"><?php echo $r['cn_number']; ?></b> </td>
                    <td> <?php echo $r['courier_receive_user_name']; ?> </td>
                    <td> <?php echo $r['qualification_1']; ?> </td>
                    <td> <?php echo $r['user_name']; ?> </td>
                    <td> <?php echo $r['cnic']; ?> </td>
                    <td> <?php echo $r['contact_number']; ?> </td>
                    <td> <?php echo $r['occupation']; ?> </td>
                    <td> <?php echo $r['courier_receive_date']; ?> </td>
                    <td> <?php echo date('m-d-Y', $r['created']); ?> </td>
                </tr>
                <?php
            $i++;
            endforeach;
        else:
            ?>
            <tr>
                <th scope="row" colspan="11">
                    <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;" class="alert alert-danger " role="alert">
                        <strong>NO DATA FOUND</strong></div>
                </th>
            </tr>
        <?php
        endif;
        ?>

    </tbody>
</table>
