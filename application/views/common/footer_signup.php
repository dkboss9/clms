<!--************************************
        Footer Start
        *************************************-->
        <footer id="tg-footer" class="tg-footer tg-haslayout">
          <div class="clearfix"></div>
          <div class="container">
            <div class="row">
              <div class="tg-footerinfo">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-right">
                 <div class="tg-widget tg-widgetsearchbylocations">
                  <div class="tg-widgettitle">
                    <h3>Follow Us:</h3>
                    <p>Connect with us on Facebook, YouTube and Twitter.</p>
                  </div>
                  <div class="tg-widgetcontent footer_social_icon">
                   <ul class="tg-socialicons">
                    <li class="tg-facebook"><a href="<?php echo $this->commonmodel->get_config(33)->config_value;?>"><i class="fa fa-facebook"></i></a></li>
                    <li class="tg-twitter"><a href="<?php echo $this->commonmodel->get_config(35)->config_value;?>"><i class="fa fa-twitter"></i></a></li>
                    <li class="tg-linkedin"><a href="<?php echo $this->commonmodel->get_config(36)->config_value;?>"><i class="fa fa-linkedin"></i></a></li>
                    <li class="tg-googleplus"><a href="<?php echo $this->commonmodel->get_config(34)->config_value;?>"><i class="fa fa-youtube-play"></i></a></li>
                    <li class="tg-rss"><a href="<?php echo $this->commonmodel->get_config(76)->config_value;?>"><i class="fa fa-instagram"></i></a></li>
                  </ul>

                </div>
              </div>
            </div>
 <?php
            $states = $this->home_model->getStateList();
            ?>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                  <div class="tg-widget tg-widgetsearchbylocations footer_menu">
                    <div class="tg-widgettitle">
                      <h3>Car for Sale:</h3>
                    </div>
                    <div class="tg-widgetcontent">
                      <ul>
                       <?php
                        foreach($states as $state){
                          ?>
                          <li><a href="<?php echo base_url("xx-cars?location=".$state->state_id);?>">-  <?php echo ucwords(strtolower($state->state_name));?></a></li>
                          <?php } ?>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                  <div class="tg-widget tg-widgetsearchbylocations footer_menu">
                    <div class="tg-widgettitle">
                      <h3>Bike for sale:</h3>
                    </div>
                    <div class="tg-widgetcontent">
                      <ul>
                      <?php
                          foreach($states as $state){
                            ?>
                            <li><a href="<?php echo base_url("xx-business-services?location=".$state->state_id);?>">-  <?php echo ucwords(strtolower($state->state_name));?></a></li>
                            <?php } ?>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                  <div class="tg-widget tg-widgetsearchbylocations footer_menu">
                    <div class="tg-widgettitle">
                      <h3>Real Estate for sale:</h3>
                    </div>
                    <div class="tg-widgetcontent">
                      <ul>
                         <?php
                           foreach($states as $state){
                            ?>
                            <li><a href="<?php echo base_url("xx-real-estate?location=".$state->state_id);?>">-  <?php echo ucwords(strtolower($state->state_name));?></a></li>
                            <?php } ?>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                  <div class="tg-widget tg-widgetsearchbylocations footer_menu">
                    <div class="tg-widgettitle">
                      <h3>Jobs:</h3>
                    </div>
                    <div class="tg-widgetcontent">
                      <ul>
                       <?php
                           foreach($states as $state){
                            ?>
                            <li><a href="<?php echo base_url("xx-jobs?location=".$state->state_id);?>">-  <?php echo ucwords(strtolower($state->state_name));?></a></li>
                            <?php } ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
        $config = $this->commonmodel->get_config(25);
        ?>
        <div class="clearfix"></div>
        

    </div>
<div class="row footer_secound_menu">
          <div class="tg-footerinfo">
            <div class="col-xs-12 col-sm-12" >
             <div class="tg-widget tg-widgettext">
               <div class="tg-widgetcontent">


                 <nav class="tg-footernav">
                   <div class="footer_logo">
                     <a href="<?php echo base_url(""); ?>"> <img src="<?php echo $config->config_value;?>" alt="Classibazzar" style="max-height:100px;width: auto;"/></a>
                   </div>
                   <ul>
                   <li><a href="<?php echo base_url("pd-api-request.html"); ?>">API Request</a></li>
                    <?php 
                    $menus =  $this->home_model->get_site_pages(4);
                    foreach($menus as $menu):
                      echo '<li><a href="'.base_url().'pd-'.$menu->slug.'">'.$menu->article_title.'</a></li>';
                    endforeach;
                    ?>
                    <?php 
                    $menus =  $this->home_model->get_site_pages(8);
                    foreach($menus as $menu):
                      echo '<li><a href="'.base_url().'pd-'.$menu->slug.'">'.$menu->article_title.'</a></li>';
                    endforeach;
                    ?>
                      <li><a href="<?php echo base_url("pd-posting-policy.html"); ?>">Listing Policy</a></li>
                      <li><a href="<?php echo base_url("pd-terms-of-use.html");?>">Terms of Use</a></li>
                      <li><a href="<?php echo base_url("pd-posting-policy.html");?>">Privacy Policy</a></li>
                      <li><a href="<?php echo base_url("pd-cookie-policy.html");?>">Cookie Policy</a></li>
                  </ul>
                  <span class="tg-copyright"><?php echo date("Y")?> All Rights Reserved &copy; ClassiBazaar</span>
                </nav>

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
    </style>
  </body>
  </html>