<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <th> Date </th>
        <th> Time Slot</th>
        <th> Applicant</th>
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
                    <td> <b><?php echo $r['visit_date']; ?></b> </td>
                    <td> <b class="text-success"><?php echo $r['slot']; ?></b> </td>
                    <td> <?php echo $r['applicant']; ?> </td>
                </tr>
                <?php
            $i++;
            endforeach;
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
