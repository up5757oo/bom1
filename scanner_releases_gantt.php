<?php

  $nav_selected = "SCANNER"; 
  $left_buttons = "YES"; 
  $left_selected = "RELEASESGANTT"; 

  include("./nav.php");
  global $db;

  ?>
<div class="right-content">
    <div class="container">
        <h3 style="color: #01B0F1;">Scanner -> System Releases Gantt</h3>
        <!--Enabling the script options necessary for builing the Google Gantt chart-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', { 'packages': ['gantt'] });
            google.charts.setOnLoadCallback(drawChart);

            //Builing the function that will create the Gantt chart
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
                //sql to pull data form database including dates formated to match the formate to add them into the Gantt chart
                $sql = "SELECT distinct id, name, DATE_FORMAT(dependency_date, '%Y, %m, %e') as dependency_date, 
                        DATE_FORMAT(open_date, '%Y, %m, %e') as open_date, DATE_FORMAT(rtm_date, '%Y, %m, %e') as rtm_date,
                            (rtm_date - open_date) as duration, 'null' as dependencies, type, status, manager, author 
                        FROM releases /*where rtm_date > open_date  and rtm_date > sysdate()*/
                        order by open_date, dependency_date, rtm_date; ";
    
                        //using the $sql query to pull database data necessary for Gantt chart
                        $result = $db -> query($sql);
    
                        if ($result -> num_rows > 0) {
                            // output data of each row
                            while ($row = $result -> fetch_assoc()) {
                                //applying start date to a variable where either open date or dependancy date could be used once references are established
                                //this will be updated to apply the preference instead of open date
                                $start_pref = "Open";
                                //$start_pref = "Dependency";
                                $start_date = ($start_pref ==="Dependency" ? $row["dependency_date"]: $row["open_date"]);
    
                                //hard coding percent value to 0 until the criteria for the percent is defined
                                $percent = 0;
    
                                //applying the database values into the 8 columns necessary for generating a Gantt chart  
                                echo '["'.$row["id"].'", "'.$row["name"].'", "Type: '.$row["type"].
                                ' | Status: '.$row["status"].' | Manager: '.$row["manager"].' | Author: '.$row["author"].'", 
                                new Date('.$start_date.'), new Date('.$row["rtm_date"].'), '
                                    .$row["duration"].', '.$percent.', '.$row["dependencies"].'],';
                                  }//end while
                                }//end if
                                else {
                                  //hard coding a response if data is not found from the sql response
                                  echo "['No Date', 'No Data Found', null, new Date(2019, 01, 01), new Date(2019, 01, 02), 1 , 0, null]";
                                }//end else
                                //Closing the database results
                                $result -> close();
                  ?>
                ]);
                //setting the variable options for the Gantt chart
                var options = {
                    //limiting the height to 600 pixels
                    height: 600,
                    gantt: {
                        //limiting the track height to 30 pixels
                        trackHeight: 30,
                        //disabling the Critical path from appearing in the tool tips
                        criticalPathEnabled: false
                    }
                };
                //creating the Gantt chart object
                var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>
        <!--Displaying the Gantt chart within the Div-->

        <div id="chart_div" style="overflow-x: scroll; overflow-y: hidden;"></div>
        <div>
            <style>
                tfoot {
                    display: table-header-group;
                }
            </style>
        </div>
    </div>
</div>
<?php include("./footer.php"); ?>
