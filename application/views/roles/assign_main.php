<script type="text/javascript">
    $(window).on('load', function () {
        $('#myModal').modal('show');
    });
</script>
<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Please Select Landing Page</h4>
                </div>
                <div class="modal-body">

                    <div class="controls">
                        <label class="control-label " for="is_landing_page">Landing Page<span class="red-star">*</span></label>
                        <select name="is_landing_page" id="is_landing_page" class="form-control" required>
                            <option value="">Please Select</option>
                            <option value="65">Welcome</option>
                            <?php
                            $end = '';
                            foreach ($menu as $key => $m) {
                                if ($end != $key) {
                                    if ($end != '') {
                                        echo '</optgroup>';
                                    }
                                    echo '<optgroup label="' . ucfirst($key) . '" >';
                                }

                                foreach ($m['assigned'] as $link) {
                                    $selected = '';
                                    if ($landingPage == $link['module_id']) {
                                        $selected = 'selected';
                                    }
                                    echo '<option value="' . $link['module_id'] . '" ' . $selected . '>' . htmlspecialchars(ucfirst($link['module'])) . '</option>';
                                }
                                $end = $key;
                            }
                            if ($end != '') {
                                echo '</optgroup>';
                            }
                            ?>
                        </select>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    $(".modal").on("hidden.bs.modal", function () {
        window.location = '<?php echo site_url('roles/assign')?>';
    });
</script>