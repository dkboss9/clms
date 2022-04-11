<script type="text/javascript">
    $(document).ready(function() {
        $(".success-message").hide();
    });
</script>

<div id="contentwrapper" style="min-height:490px;">
    <?php if ($this->session->flashdata('success') != '') { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".success-message").show();
                $(".success-message").html(' <?php echo $this->session->flashdata('success'); ?>');
                $(".success-message").delay(3000).slideUp('slow', function() {
                    $(".success-message").html('');
                });
            });
        </script>
    <?php } ?>
    <div class="success-message"></div>
    <!-- Start listing -->
    <h3> Manage Post Images <?php if(isset($title)) echo ":".$title;?></h3>
    <table border="0" id="headingtable" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th style="text-align:center;">SN</th>
                <th style="text-align:left">Image</th>
                <th>Option</th>
            </tr>
        </thead>
        <?php
        if (isset($images)) {

            //print_r($posts);exit;
            $i = 1;
            foreach ($images as $post):
                $class = ($i % 2 == 0) ? "class='row1'" : 'class="row0"';
                echo '<tr style="text-align:center;" ' . $class . '>';
                echo '<td style="text-align:center">' . $i . '</td>';
                echo '<td><img src="../assets/uploads/thumb/'.$post->thumbnail.'" /></td>';
                echo '<td style="text-align:center;">' .anchor('forms/deleteimage/' . $post->image_id.'/'.$post->post_id, 'Delete', array('class' => 'edit', 'onclick' => 'return confirmation()')) . '</td>';
                $i++;
            endforeach;
        }
        ?>
    </table>
    <!-- End listing --> 
</div>

<!-- End pagination --> 
