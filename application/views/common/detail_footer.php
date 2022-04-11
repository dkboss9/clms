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
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-right">
                  <div class="tg-widget tg-widgetsearchbylocations">
                    <div class="tg-widgettitle">
                      <h3>Search By Locations:</h3>
                    </div>
                    <div class="tg-widgetcontent">
                      <ul>
                        <li><a href="<?php echo base_url("location/1/western-australia"); ?>">-  Western Australia</a></li>
                        <li><a href="<?php echo base_url("location/2/victoria"); ?>">-  Victoria</a></li>
                        <li><a href="<?php echo base_url("location/3/tasmania"); ?>">-  Tasmania</a></li>
                        <li><a href="<?php echo base_url("location/4/south-australia"); ?>">-  South Australia</a></li>
                        <li><a href="<?php echo base_url("location/5/queensland"); ?>">-  Queensland</a></li>
                        <li><a href="<?php echo base_url("location/6/northern-territory"); ?>">-  Northern-Territory</a></li>
                        <li><a href="<?php echo base_url("location/7/new-south-wales"); ?>">-  New South Sales</a></li>
                        <li><a href="<?php echo base_url("location/8/australian-capital-territory"); ?>">-  Australian Capital Territory</a></li>
                      </ul>



                    </div>
                  </div>
                </div>
                <?php
                $config = $this->commonmodel->get_config(25);
                ?>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                  <div class="tg-widget tg-widgettext">
                    <div class="tg-widgetcontent">
                      <strong class="tg-logo"><a href="<?php echo base_url(""); ?>"> <img src="<?php echo base_url()."assets/uploads/logo_footer/".$config->config_value;?>" alt="Classibazzar" style="max-height:100px;width: auto;"/></a></strong>
                      <div class="tg-description">
                        <?php 
                        $footer = $this->home_model->get_page_detailId(12);
                        ?>
                        <p><?php echo $footer->article_details; ?></p>
                      </div>
                      <div class="tg-followus">
                        <strong>Follow Us:</strong>
                        <ul class="tg-socialicons">
                         <ul class="tg-socialicons">
                          <li class="tg-facebook"><a href="<?php echo $this->commonmodel->get_config(33)->config_value;?>"><i class="fa fa-facebook"></i></a></li>
                          <li class="tg-twitter"><a href="<?php echo $this->commonmodel->get_config(35)->config_value;?>"><i class="fa fa-twitter"></i></a></li>
                          <li class="tg-linkedin"><a href="<?php echo $this->commonmodel->get_config(36)->config_value;?>"><i class="fa fa-linkedin"></i></a></li>
                          <li class="tg-googleplus"><a href="<?php echo $this->commonmodel->get_config(34)->config_value;?>"><i class="fa fa-youtube-play"></i></a></li>
                          <li class="tg-rss"><a href="<?php echo $this->commonmodel->get_config(76)->config_value;?>"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                      </ul>
                        <!--
                        <ul class="tg-appsnav">
                          <li><a href="javascript:void(0);"><img src="<?php echo base_url("assets/");?>/images/apps-01.png" alt="image description"></a></li>
                          <li><a href="javascript:void(0);"><img src="<?php echo base_url("assets/");?>/images/apps-02.png" alt="image description"></a></li>
                        </ul>
                      -->
                    </div>
                    <nav class="tg-footernav">
                      <ul>
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
                    </nav>
                    <span class="tg-copyright"><?php echo date("Y")?> All Rights Reserved &copy; ClassiBazar</span>
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
      <div id="tg-modalselectcurrency" class="modal fade tg-thememodal tg-modalselectcurrency" tabindex="-1" role="dialog">
        <div class="modal-dialog tg-thememodaldialog" role="document">
          <button type="button" class="tg-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <div class="modal-content tg-thememodalcontent">
            <div class="tg-title">
              <strong>Change Currency</strong>
            </div>
            <form class="tg-formtheme tg-formselectcurency">
              <fieldset>
                <div class="form-group">
                  <div id="tg-flagstrapone" class="tg-flagstrap" data-input-name="country"></div>
                </div>
                <div class="form-group">
                  <button class="tg-btn" type="button">Change Now</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
      <div id="tg-modalpriceconverter" class="modal fade tg-thememodal tg-modalpriceconverter" tabindex="-1" role="dialog">
        <div class="modal-dialog tg-thememodaldialog" role="document">
          <button type="button" class="tg-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <div class="modal-content tg-thememodalcontent">
            <div class="tg-title">
              <strong>Currency Converter</strong>
            </div>
            <form class="tg-formtheme tg-formcurencyconverter">
              <fieldset>
                <div class="form-group">
                  <div id="tg-flagstraptwo" class="tg-flagstrap" data-input-name="country"></div>
                  <div class="tg-curencyrateetc">
                    <span>120<sup>$</sup></span>
                    <p>1 USD = 0.784769 GBP</p>
                  </div>
                </div>
                <div class="form-group">
                  <span class="tg-iconseprator"><i><img src="<?php echo base_url("assets/");?>/images/icons/img-36.png" alt="image description"></i></span>
                </div>
                <div class="form-group">
                  <div id="tg-flagstrapthree" class="tg-flagstrap" data-input-name="country"></div>
                  <div class="tg-curencyrateetc">
                    <span>94.1723<sup>£</sup></span>
                    <p>1 GBP = 1.27426 USD</p>
                  </div>
                </div>
                <div class="form-group">
                  <span class="tg-lastupdate">Last update on <time datetime="2017-08-08">2017-06-12 12:35 local time</time></span>
                </div>
                <div class="form-group">
                  <button class="tg-btn" type="button">Convert Now</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
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
    </style>
  </body>
  </html>