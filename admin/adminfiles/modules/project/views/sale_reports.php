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

        <h2 class="panel-title">Commission Report</h2>
      </header>
      <div class="panel-body">

        <div class="row">

          <div class="col-md-12">
            <section class="panel">
              <header class="panel-heading">
                <div class="panel-actions">
                  <a href="#" class="" data-panel-toggle></a>
                  <a href="#" class="" data-panel-dismiss></a>
                </div>

                <h2 class="panel-title">Sales Rep: Stacked Chart</h2>
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
<?php

$months = array(
  7   =>  'July',
  8   =>  'August',
  9   =>  'September',
  10  =>  'October',
  11  =>  'November',
  12  =>  'December',
  1   =>  'January',
  2   =>  'February',
  3   =>  'March',
  4   =>  'April',
  5   =>  'May',
  6   =>  'June',
  );


  ?>
  <script type="text/javascript">
    (function() {
      var chart = new Chartist.Bar('#ChartistStackedChart', {

        labels: [
        <?php
        foreach ($months as $key=>$val) {
          echo "'".$val."',";
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
            foreach ($months as $key=>$val) {
              echo intval($this->projectmodel->count_MonthSales($user->userid,$key)).',';
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
          return ':'+value+ '$';
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
      $tooltip.html(seriesName + '<br/>' + value + '$');
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
