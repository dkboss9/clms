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
    <table border="0" id="headingtable" cellspacing="0" cellpadding="0">
        <thead>

        </thead>
        <thead>
            <tr>
                <th style="text-align:center;">SN</th>
                <th style="text-align:left">Title</th>
                <th style="text-align:left">Price</th>
                <th>Added Date</th>
                <th>Featured</th>
                <th>Status</th>
                <th>Option</th>
            </tr>
        </thead>
        <?php
        if (isset($posts)) {

            //print_r($posts);exit;
            $i = 1;
            foreach ($posts as $post):

                //$postdata = unserialize($post->post);
                $class = ($i % 2 == 0) ? 'class="row1"' : 'class="row0"';
                echo '<tr style="text-align:center;" ' . $class . '>';
                echo '<td style="text-align:center">' . $i . '</td>';
                echo '<td>';
                if (isset($post->title))
                    echo $post->title; echo '</td>';
                echo '<td>' . $post->price . ' AUD</td>';
                echo '<td style="text-align:center;">' . $post->posted_date . '</td>';
                echo '<td style="text-align:center;">';
                echo $post->featured == 1 ? anchor("forms/update_post/" . $post->featured . '/' . $post->post_id, "Yes", array('class' => 'edit', 'onclick' => 'return confirmation_featured()')) : anchor("forms/update_post/" . $post->featured . '/' . $post->post_id, "Make it featured", array('class' => 'edit', 'onclick' => 'return confirmation_featured()'));
                echo '</td>';
                echo '<td style="text-align:center;">';
                echo $post->status == 1 ? "Active" : "NotActive";
                echo '</td>';
                echo '<td style="text-align:center;">' . anchor('forms/editposts/' . $post->post_id . '/' . $post->form_id, 'Edit', array('class' => 'edit')) . ' | ' . anchor('forms/deletepost/' . $post->post_id, 'Delete', array('class' => 'edit', 'onclick' => 'return confirmation()')) . ' | ' . anchor('forms/posts_images/' . $post->post_id, 'Images') . '</td>';
                $i++;
            endforeach;
        }
        ?>
    </table>
    <!-- End listing --> 
</div>
<!-- Start pagination -->
<div class="pagination">
    <ul>
<?php echo $pagination; ?>
    </ul>
</div>
<!-- End pagination --> 
