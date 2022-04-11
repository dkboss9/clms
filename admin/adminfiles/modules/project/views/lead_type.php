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

        <h2 class="panel-title">Project Report</h2>
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

                <h2 class="panel-title">Lead Type - Bars Chart</h2>
                
              </header>
              <div class="panel-body">

                <!-- Flot: Bars -->
                <div class="chart chart-md" id="flotBars"></div>
                <script type="text/javascript">

                  var flotBarsData = [
                  <?php 
                  foreach ($lead_type as $row) {
                    $num = $row->num;
                    $label = $row->type_name;
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

                    <h2 class="panel-title">Lead Type - Pie Chart</h2>

                  </header>
                  <div class="panel-body">

                    <!-- Flot: Pie -->
                    <div class="chart chart-md" id="flotPie"></div>
                    <script type="text/javascript">

                      var flotPieData = [
                      <?php 
                      foreach ($lead_type as $row) {
                        $num = $row->num;
                        $label = $row->type_name;
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
            <div class="row">

              <div class="col-md-12">
                <section class="panel">
                  <header class="panel-heading">
                    <div class="panel-actions">
                      <a href="#" class="" data-panel-toggle></a>
                      <a href="#" class="" data-panel-dismiss></a>
                    </div>

                    <h2 class="panel-title">Lead Type: Stacked Chart</h2>
                  </header>
                  <div class="panel-body">
                    <div id="ChartistStackedChart" class="ct-chart ct-perfect-fourth ct-golden-section"></div>

                    <!-- See: assets/javascripts/ui-elements/examples.charts.js for the example code. -->
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
    var chart = new Chartist.Bar('#ChartistStackedChart', {

      labels: [
      <?php
      foreach ($lead_type as $row) {
        echo "'".$row->type_name."',";
      } ?>
      ],
      series: [
      <?php
      $users = $this->lmsmodel->get_users();
      foreach ($users as $user) {
        ?>
        {
          name: '<?php echo $user->first_name;?>',
          data: [<?php        
          foreach ($lead_type as $row) {
            echo $this->projectmodel->count_project($user->userid,$row->type_id).',';
          }
          ?>]
        },
        <?php

      } ?>

      ]
    }, {
      stackBars: true,
      tooltip: true,
      axisY: {
        labelInterpolationFnc: function(value) {
          //return (value / 1000) + 'k';
          return ':'+value;
        }
      }
    }).on('draw', function(data) {
      if (data.type === 'bar') {
        data.element.attr({
          style: 'stroke-width: 30px'
        });
      }
    });
    var $tooltip = $('<div class="tooltip tooltip-hidden"></div>').appendTo($('.ct-chart'));

    $(document).on('mouseenter', '.ct-bar', function() {
      var seriesName = $(this).closest('.ct-series').attr('ct:series-name'),
      value = $(this).attr('ct:value');
      $tooltip.html(seriesName + '<br/>' + value);
      $tooltip.removeClass('tooltip-hidden');
    });

    $(document).on('mouseleave', '.ct-bar', function() {
      $tooltip.addClass('tooltip-hidden');
    });

    $(document).on('mousemove', '.ct-bar', function(event) {
      $tooltip.css({
        left: (event.offsetX || event.originalEvent.layerX) - $tooltip.width() / 2,
        top: (event.offsetY || event.originalEvent.layerY) - $tooltip.height() - 20
      });
    });
  })();

  

</script>
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