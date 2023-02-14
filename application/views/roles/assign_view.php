<div class="row margin-top-15">
    <div class="heading-top">
        <h3 class="page-title text-uppercase"> Assigned Roles</h3>
    </div>
    <div class="col-md-12 margin-top-10">
        <table class="table table-responsive table-bordered table-striped">
            <?php if (count($menu > 0)):
                foreach ($menu as $key => $m) {?>

                    <tr class="alert alert-warning">
                        <td col><?php echo $key; ?></td>
                    <tr>
                        <td style="margin: 10px 25px">
                            <table>
                                <tr>

                                    <?php $i = 0;

                                    foreach ($m['sub_menu'] as $link) {
                                        $checked    =   '';
                                            if (in_array($link['module_id'],$merged))
                                                $checked    =   'checked';
                                        ?>

                                        <td style="margin: 5px; padding: 5px;">
                                            <input name="modules[]" type="checkbox"
                                                   value="<?php echo $link['module_id']; ?>" <?php echo $checked;?>>
                                            <label>  <?php echo ucfirst($link['module']); ?></label>

                                        </td>
                                        <?php if ($i % 3 == 0 && $i !== 0) {
                                            echo '</tr><tr>';
                                        }
                                        ?>


                                        <?php $i++;
                                    } ?>
                                </tr>
                            </table>
                        </td>
                    </tr>

                <?php }
            else:?>
                <tr>
                    <td class="alert alert-danger">No Data found</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>