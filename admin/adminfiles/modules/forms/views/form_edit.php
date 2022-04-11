
<link href="<?php echo base_url(); ?>themes/css/reset.css" rel="stylesheet" media="screen" />
<link href="<?php echo base_url(); ?>themes/css/styles.css" rel="stylesheet" media="screen" />
<link href="<?php echo base_url(); ?>themes/css/forms/style.css" rel="stylesheet" media="screen" />
<script src="<?php echo base_url(); ?>themes/js/jquery.min.js"></script>
<script type="text/javascript">
    jQuery.noConflict();
</script>
</head>
<body>

    <div id="form-output-holder">
        <?php
        //$postid=3;
        //$form_id=9;

        pds_form_render($form_id, $postid);
        ?>
    </div>