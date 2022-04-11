<!--************************************
        Footer Start
        *************************************-->
        <footer id="tg-footer" class="tg-footer tg-haslayout">
          <div class="tg-footerbar">
            <div class="container">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-push-1 col-lg-10">
                  <div class="tg-newsletter">
                    <h2>Signup For Newsletter:</h2>
                    <form class="tg-formtheme tg-formnewsletter" id="form_newsletter" method="post" action="javascript:addSubscribers();">
                      <fieldset>
                        <i class="icon-envelope"></i>
                        <input type="email" name="subscribe_email" id="subscribe_email" class="form-control email required" placeholder="Enter your email here">
                        <button type="button" id="btn-subscribe">Signup Now</button>
                        <div id="div_err" style="color:red;"></div>
                      </fieldset>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="container">
            <div class="row">
              <div class="tg-footerinfo">

                <div class="col-xs-12" style="min-height: auto;">
                  <div class="tg-widget tg-widgettext" ">
                    <div class="tg-widgetcontent">
                     <?php
                     $config = $this->commonmodel->get_config(33);
                     $config = $this->commonmodel->get_config(35);
                     $config = $this->commonmodel->get_config(36);
                     ?>
                     <div class="tg-followus" >
                      <strong>Follow Us:</strong>
                      <ul class="tg-socialicons">
                        <li class="tg-facebook"><a href="<?php echo $this->commonmodel->get_config(33)->config_value;?>"><i class="fa fa-facebook"></i></a></li>
                        <li class="tg-twitter"><a href="<?php echo $this->commonmodel->get_config(35)->config_value;?>"><i class="fa fa-twitter"></i></a></li>
                        <li class="tg-linkedin"><a href="<?php echo $this->commonmodel->get_config(36)->config_value;?>"><i class="fa fa-linkedin"></i></a></li>
                        <li class="tg-googleplus"><a href="<?php echo $this->commonmodel->get_config(34)->config_value;?>"><i class="fa fa-youtube-play"></i></a></li>
                            <li class="tg-rss"><a href="<?php echo $this->commonmodel->get_config(76)->config_value;?>"><i class="fa fa-instagram"></i></a></li>
                         </ul>
                        <!--
                        <ul class="tg-appsnav">
                          <li><a href="javascript:void(0);"><img src="<?php echo base_url("assets/");?>/images/apps-01.png" alt="image description"></a></li>
                          <li><a href="javascript:void(0);"><img src="<?php echo base_url("assets/");?>/images/apps-02.png" alt="image description"></a></li>
                        </ul>
                      -->
                    </div>

                    <span class="tg-copyright"><?php echo date("Y")?> All Rights Reserved &copy; Classi Bazaar</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
    <!--************************************
        Footer End
        *************************************-->
      </div>
  <!--************************************
      Wrapper End
      *************************************-->
  <!--************************************
      Theme Modal Box Start
      *************************************-->


  <!--************************************
      Theme Modal Box End
      *************************************-->
      <script type="text/javascript">
        $(document).ready(function(){
          $("#form_newsletter").validate();
          $("#btn-subscribe").click(function(){ 
           var email = $("#subscribe_email").val();
           if(email.trim() == ""){
            $("#div_err").html("Please enter the valid email address.");
            return false;
          }else{
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if( regex.test(email))
              $("#div_err").html("");
            else{
              $("#div_err").html("Please enter the valid email address.");
              return false;
            }

          } 
          $.ajax({
            url: '<?php echo base_url("home/newsletter");?>',
            type: "POST",
            data: "news_email=" + email,
            success: function(data) { 
              $("#div_err").html(data);
              $("#subscribe_email").val("");

            }        
          });
          return false;
        });
        });
      </script>

      <style type="text/css">
      .error{
        color:red;
      }
      .tg-widgetcontent{width:auto; float: none;}
      .tg-footerinfo{padding:20px 0;}
      .tg-footerinfo .tg-widgettext{padding:0;}
      .tg-followus{width:auto;padding:0;}
      .tg-copyright{display: block;
        padding: 0;
        width: auto;
        float: right;}
        @media (max-width: 768px) {
          .tg-footerinfo,.tg-widget,.tg-copyright, .tg-followus{float:none; text-align:center;}
          .tg-footerinfo .tg-widgetcontent{padding:20px 0;}
          .tg-footerinfo{padding:0;}
          .tg-followus strong, .tg-followus .tg-socialicons{float: none; display: inline-block;}
        }
      </style>
    </body>
    </html>