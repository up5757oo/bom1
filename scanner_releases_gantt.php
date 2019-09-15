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
      data.addColumn('string', 'ID');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');
  data.addRows([
    
   <?php 
        $sql = "SELECT distinct id, name, DATE_FORMAT(dependency_date, '%Y, %m, %e') as dependency_date, DATE_FORMAT(open_date, '%Y, %m, %e') as open_date, DATE_FORMAT(rtm_date, '%Y, %m, %e') as rtm_date, (rtm_date - open_date) as duration, 0 as percent_complete, 'null' as dependencies,  type, status, manager, author FROM releases /* where rtm_date > open_date  and rtm_date > sysdate()*/ order by open_date, dependency_date, rtm_date;";
        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                              $start_date = $row["open_date"];
                              $type = $row["type"];
                              $status = $row["status"];
                              $manager = $row["manager"];
                              $author = $row["author"];

                                echo '["'.$row["id"].'", "'.$row["name"].'", "Type: '.$type.
                                ' | Status: '.$status.' | Manager: '.$manager.' | Author: '.$author.'", new Date('.$start_date.'), new Date('.$row["rtm_date"].') , '.$row["duration"].', '
                                .$row["percent_complete"].', '.$row["dependencies"].'],';
                          
                                
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
        height: 600,
        gantt: {
          trackHeight: 30,
          criticalPathEnabled: false
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
    <div id="chart_div"></div>

<div>
   <style>
   tfoot {
     display: table-header-group;
   }
 </style>
</div>
  <?php include("./footer.php"); ?>
