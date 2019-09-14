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
      data.addColumn('string', 'Type');
  data.addRows([
    ['ICS-201689', 'SAFe Project V.5.6.7', 'BOM-102', new Date(2019, 10, 01), new Date(2019, 12, 06) , 205, 0, 'Async '], 
    ['ICS-789089', 'Registration System V.2019', 'BOM-103', new Date(2019, 10, 01), new Date(2019, 12, 06) , 205, 0, 'Async '], 
    ['ICS-898989', 'Word Explorer 2020', 'BOM-104', new Date(2019, 10, 01), new Date(2019, 12, 06) , 205, 0, 'Patch'], 
    ['ICS-201684', 'SAFe Project V.5.6.8', 'BOM-107', new Date(2020, 10, 01), new Date(2020, 12, 06) , 205, 0, 'Async '], 
    ['ICS-789084', 'Registration System V.2020', 'BOM-108', new Date(2020, 10, 01), new Date(2020, 12, 06) , 205, 0, 'Async '], 
    ['ICS-898984', 'Word Explorer 2021', 'BOM-109', new Date(2020, 10, 01), new Date(2020, 12, 06) , 205, 0, 'Patch'], 
    ['ICS-201685', 'SAFe Project V.5.6.9', 'BOM-112', new Date(2021, 10, 01), new Date(2021, 12, 06) , 205, 0, 'Async '], 
    ['ICS-789085', 'Registration System V.2020.1', 'BOM-113', new Date(2021, 10, 01), new Date(2021, 12, 06) , 205, 0, 'Async '], 
    ['ICS-898985', 'Word Explorer 2022', 'BOM-114', new Date(2021, 10, 01), new Date(2021, 12, 06) , 205, 0, 'Patch']
 <?php /*
   
        $sql = "SELECT id, name, app_id, DATE_FORMAT(open_date, '%Y, %m, %e') as open_date, DATE_FORMAT(rtm_date, '%Y, %m, %e') as rtm_date, (rtm_date - open_date) as duration, 0 as percent_complete, type FROM releases where rtm_date > open_date  and rtm_date > sysdate() order by app_id, rtm_date;";
        $result = $db->query($sql);
        
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "['".$row['id']."', '".$row['name']."', '".$row['app_id'].
                                "', new Date(".$row['open_date']."), new Date(".$row['rtm_date'].") , ".$row['duration'].", "
                                .$row['percent_complete'].", '".$row['type']."'], ";
                          
                                
                            }
                            
                            //end while
                        }//end if
                        else {
                            echo "['No Date', 'No Data Found', null, null, null, 1 , null, null]";
                        }//end else
        
                         $result->close();*/
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
