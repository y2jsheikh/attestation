<table class="table table-data-new">
    <thead>
    <tr>
        <th> Sr. #</th>
        <?php if ($role_id == 1){ ?>
        <th> User</th>
        <?php } ?>
        <th> Area</th>
        <th> Qualification</th>
        <th> Institute</th>
        <th> Completion Year</th>
        <!--<th> Status </th>-->
        <th> Action</th>
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
                    <?php if ($role_id == 1){ ?>
                        <td> <?php echo $r['user_name']; ?></td>
                    <?php } ?>
                    <td> <?php echo $r['qualification_area']; ?> </td>
                    <td> <?php echo $r['qualification']; ?> </td>
                    <td> <?php echo $r['institute']; ?> </td>
                    <td> <?php echo $r['completion_year']; ?> </td>
                    <!--<td>-->
                    <?php /*
                        if ($r['status'] == 'pending'){
                            echo "Pending";
                        }elseif ($r['status'] == 'in_process'){
                            echo "In Process";
                        }elseif ($r['status'] == 'completed'){
                            echo "Completed";
                        }elseif ($r['status'] == 'rejected'){
                            echo "Rejected";
                        }
                    */ ?>
                    <!--</td>-->
                    <td>
                        <a onClick="return confirm('Are you sure you want to update?');" href="<?php echo base_url('qualification/edit/' . $r['id']) ?>" class="btn btn-info btn-sm"
                           id="btn-view"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                </tr>
                <?php
            $i++;
            endforeach;
        else:
            ?>
            <tr>
                <th scope="row" colspan="7">
                    <div style="color:#FFFFFF;text-align: center; background-color: #ff0000;" class="alert alert-danger " role="alert">
                        <strong>NO DATA FOUND</strong></div>
                </th>
            </tr>
        <?php
        endif;
        ?>

    </tbody>
</table>
