<?php

  $nav_selected = "SCANNER"; 
  $left_buttons = "YES"; 
  $left_selected = "RELEASESGANTT"; 

  include("./nav.php");
  global $db;

  ?>


<div class="right-content">
    <div class="container">

      <h3 style = "color: #01B0F1;">Scanner -> System Releases Gantt</h3>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'ID');
      data.addColumn('string', 'Name');
      data.addColumn('string', 'App ID');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependantcies');
  data.addRows([
    
   <?php 
        $sql = "SELECT id, name, app_id, DATE_FORMAT(open_date, '%Y, %m, %m') as open_date, DATE_FORMAT(rtm_date, '%Y, %m, %m') as rtm_date, (rtm_date - open_date) as duration, 0 as percent_complete, 'null' as dependantcies FROM releases where rtm_date > open_date  and rtm_date > sysdate() order by app_id, rtm_date;";
        $result = $db->query($sql);
        
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo '["'.$row["id"].'", "'.$row["name"].'", "'.$row["app_id"].
                                '", new Date('.$row["open_date"].'), new Date('.$row["rtm_date"].') , '.$row["duration"].', '
                                .$row["percent_complete"].', '.$row["dependantcies"].'],';
                          
                                
                            }
                            
                            //end while
                        }//end if
                        else {
                            echo "['No Date', 'No Data Found', null, null, null, 1 , null, null]";
                        }//end else
        
                         $result->close();
                        ?>

  ]);
      var options = {
        height: 400,
        gantt: {
          trackHeight: 30
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
    <div id="chart_div"></div>

XXXXXXX

<div>
   <style>
   tfoot {
     display: table-header-group;
   }
 </style>
</div>
  <?php include("./footer.php"); ?>
