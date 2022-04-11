<script type="text/javascript">
  var image_path = '<?php echo base_url();?>'
</script>
<script type="text/javascript" src="<?php echo base_url("webcam");?>/webcam.js"></script>
<script>
  webcam.set_api_url("picture/upload");
        webcam.set_quality( 90 ); // JPEG quality (1 - 100)
        webcam.set_shutter_sound( true ); // play shutter click sound
        
        webcam.set_hook( 'onComplete', 'my_completion_handler' );
        
        function take_snapshot() {
            // take snapshot and upload to server
            document.getElementById('upload_results').innerHTML = 'Snapshot<br>'+
            '<img src="logo.jpg">';
            webcam.snap();
          }

          function my_completion_handler(msg) {
            // extract URL out of PHP output
            if (msg.match(/(http\:\/\/\S+)/)) {
              var image_url = RegExp.$1;
                // show JPEG image in page
                document.getElementById('upload_results').innerHTML = 
                'Snapshot<br>' + 
                '<a href="'+image_url+'" target"_blank"><img src="' + image_url + '"></a>';
                
                // reset camera for another shot
                webcam.reset();
               // alert(image_url);
             }
             else alert("PHP Error: " + msg);
           }
         </script>
         <style>
          .main
          {
            margin-left: auto;
            margin-right: auto;
            width: 690px;
          }
          .snap
          {
            color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
            background: rgb(28, 184, 65);
            font-family: inherit;
            font-size: 100%;
            padding: .5em 1em;
            border: 0 hsla(0, 0%, 0%, 0);
            text-decoration: none;
          }
            /*.border
            {
              border: 3px rgb(28, 184, 65) solid;
              padding: 5px;
              width: 320px;
              height: 258px;
            } */
          </style>
          <section role="main" class="content-body">
           <header class="page-header">
            <h2>Effective Lead Management System</h2>
            <div class="right-wrapper pull-right">
              <a class="sidebar-right-toggle" href="<?php echo base_url("logout");?>"><i class="fa fa-power-off"></i></a>
            </div>
          </header>
          <?php 
          if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
            ?>
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <strong>We must tell you! </strong> Please select company to add this data.
            </div>
            <?php
          }
          ?>
          <!-- start: page -->
          <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  <div class="panel-actions">
                    <a href="#" class="" data-panel-toggle></a>
                    <a href="#" class="" data-panel-dismiss></a>
                  </div>

                  <h2 class="panel-title">Picture : [New]</h2>
                </header>
                <div class="panel-body">
                  <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("start/add");?>" method="post" enctype='multipart/form-data'>


                    <div class="form-group">
                      <label class="col-md-3 control-label" for="inputDefault">Pictures</label>
                      <div class="col-md-6">
                       <table class="main">
                        <tr>
                          <td valign="top">
                            <div class="border">
                              Live Webcam<br>
                              <script>
                                document.write( webcam.get_html(320, 240) );
                              </script>
                            </div>
                            <br/><input type="button" class="snap" value="SNAP IT" onClick="take_snapshot()"> &nbsp;&nbsp;<a href="<?php echo base_url("picture");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
                          </td>
                          <td width="50">&nbsp;</td>
                          <td valign="top">
                            <div id="upload_results" class="border">
                              Snapshot<br>
                              <img src="<?php echo base_url("webcam")?>/logo.jpg" />
                            </div>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>
        </div>
        <!-- end: page -->
      </section>
    </div>
  </section>
