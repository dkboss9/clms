<script src="<?php echo base_url("");?>assets/vendor/chartist/chartist.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.categories.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.resize.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/raphael/raphael.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/morris/morris.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/gauge/gauge.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/snap-svg/snap.svg.js"></script>


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Lead Report</h2>
      </header>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <section class="panel">
              <header class="panel-heading">
                <div class="panel-actions">
                  <a href="#" class="" data-panel-toggle></a>
                  <a href="#" class="" data-panel-dismiss></a>
                </div>

                <h2 class="panel-title">Lead Category - Bars Chart</h2>
                
              </header>
              <div class="panel-body">

                <!-- Flot: Bars -->
                <div class="chart chart-md" id="flotBars"></div>
                <script type="text/javascript">

                  var flotBarsData = [
                  <?php 
                  foreach ($status as $row) {
                    $num = $row->num;
                    $label = $row->cat_name;
                    ?>
                    ["<?php echo $label;?>", <?php echo $num?>],

                    <?php
                  }
                  ?>
                  ];

                      // See: assets/javascripts/ui-elements/examples.charts.js for more settings.

                    </script>

                  </div>
                </section>
              </div>
              <div class="col-md-6">
                <section class="panel">
                  <header class="panel-heading">
                    <div class="panel-actions">
                      <a href="#" class="" data-panel-toggle></a>
                      <a href="#" class="" data-panel-dismiss></a>
                    </div>

                    <h2 class="panel-title">Lead Category - Pie Chart</h2>

                  </header>
                  <div class="panel-body">

                    <!-- Flot: Pie -->
                    <div class="chart chart-md" id="flotPie"></div>
                    <script type="text/javascript">

                      var flotPieData = [
                      <?php 
                      foreach ($status as $row) {
                        $num = $row->num;
                        $label = $row->cat_name;
                        ?>
                        {
                          label: "<?php echo $label;?>",
                          data: [
                          [1, <?php echo round(($num/$project_num)*100,2);?>]
                          ],
                          color: '<?php echo "#" . strtoupper(dechex(rand(0,10000000)));?>'
                        },
                        <?php
                      }
                      ?>
                      ];

                      // See: assets/javascripts/ui-elements/examples.charts.js for more settings.

                    </script>

                  </div>
                </section>
              </div>
            </div>
            
          </div>
        </section>
      </div>
    </div>
    <!-- end: page -->
  </section>
</div>
</section>


<script type="text/javascript">
  (function() {
    var plot = $.plot('#flotPie', flotPieData, {
      series: {
        pie: {
          show: true,
          combine: {
            color: '#999',
            threshold: 0.1
          }
        }
      },
      legend: {
        show: false
      },
      grid: {
        hoverable: true,
        clickable: true
      }
    });
  })();

  (function() {
    var plot = $.plot('#flotBars', [flotBarsData], {
      colors: ['#8CC9E8'],
      series: {
        bars: {
          show: true,
          barWidth: 0.8,
          align: 'center'
        }
      },
      xaxis: {
        mode: 'categories',
        tickLength: 0
      },
      grid: {
        hoverable: true,
        clickable: true,
        borderColor: 'rgba(0,0,0,0.1)',
        borderWidth: 1,
        labelMargin: 15,
        backgroundColor: 'transparent'
      },
      tooltip: true,
      tooltipOpts: {
        content: '%y',
        shifts: {
          x: -10,
          y: 20
        },
        defaultTheme: false
      }
    });
  })();
  

</script>