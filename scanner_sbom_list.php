<?php
  $nav_selected = "SCANNER";
  $left_buttons = "YES";
  $left_selected = "SOFTWAREBOM";

  include("./nav.php");
  
 //creates sql query to pull in release information from the sbom table of the bom database
$query = "SELECT * FROM sbom;";
//runs the query and assigns the results to the sbomResults variable
$sbomResults = mysqli_query($db, $query);
?>

 <div class="right-content">
    <div class="container">

      <h3 style = "color: #01B0F1;">Scanner --> Software BOM </h3>
      <div id="sbom_View">

<!--Creates the table and sorts the RTM date in ascending order-->
    <table class="table table-striped" id="info" data-order='[[ 1, "asc" ]]' >
        <div class="table responsive">
            <thead>
            <tr id="table-first-row">
                    <th>Row ID</th>
                    <th>App ID</th>
                    <th>App Name</th>
                    <th>App Version</th>
                    <th>CMP ID</th>
                    <th>CMP Name</th>
                    <th>CMP Version</th>
                    <th>CMP Type</th>
                    <th>App Status</th>
                    <th>CMP Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //checks the results of the releaseResults variable. If the data is found the table is built with the results
            if ($sbomResults->num_rows > 0) {
                // output data of each row
                while($row = $sbomResults->fetch_assoc()) {

                    echo '<tr>
                        <td> '.$row["row_id"].'</td>
                        <td> '.$row["app_id"].'</td>
                        <td> '.$row["app_name"]. '</td>
                        <td> '.$row["app_version"].'</td>
                        <td> '.$row["cmp_id"]. '</td>
                        <td> '.$row["cmp_name"].'</td>
                        <td> '.$row["cmp_version"].'</td>
                        <td> '.$row["cmp_type"]. '</td>
                        <td> '.$row["app_status"].'</td>
                        <td> '.$row["cmp_status"].'</td>
                        <td> '.$row["notes"]. '</td>
                        
                        </tr>';
                }//end while
            }//end if
            else {
                //displays ) results if there are no rows found from the query
                echo "0 results";
            }//end else
            ?>
                        <tfoot>
            <tr id="table-first-row">
                    <th>Row ID</th>
                    <th>App ID</th>
                    <th>App Name</th>
                    <th>App Version</th>
                    <th>CMP ID</th>
                    <th>CMP Name</th>
                    <th>CMP Version</th>
                    <th>CMP Type</th>
                    <th>App Status</th>
                    <th>CMP Status</th>
                    <th>Notes</th>
                </tr>
            </tfoot>
            </tbody>
        </div>
    </table>
</div>
</div>


<!--Release table scripts-->


<script type="text/javascript" language="javascript">
    $(document).ready( function () {
        
        $('#info').DataTable( {
            dom: 'lfrtBip',
            buttons: [
                'copy', 'excel', 'csv', 'pdf'
            ] }
        );

        $('#info thead tr').clone(true).appendTo( '#info thead' );
        $('#info thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    
        var table = $('#info').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            retrieve: true
        } );
        
    } );

</script>
    </div>
</div>

<?php include("./footer.php"); ?>
