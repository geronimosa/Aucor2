<?php
/**
* Template Name: Aucor-DB-Editor
*
* @package WordPress
* @subpackage Vlocity
* @since Vlocity 1.0
*/
?>
<script>
    function changeover(thevalue){
        //window.location.href = url.pathname;
        const currentUrl = window.location.pathname;
        //alert(currentUrl+"?value="+thevalue);
        window.location.href=currentUrl+"?value="+thevalue;
    }
    function openPopup(thevalue) {
        const popupName = "PopupWindow";
        const features = "width=600,height=400,scrollbars=yes,resizable=yes";
        var currentPath = window.location.pathname;
        var newPath = currentPath.replace("wp/aucor-database-manager/", "MW/detail.php?value="+thevalue);
        window.open(newPath, popupName, features);
    }

    
</script>
<?php
get_header();


$wp_root_path = str_replace('/wp-content/themes', '', get_theme_root());
$wp_root_path = str_replace('\wp', '\MW', $wp_root_path)."\steve_functions.php";

include_once $wp_root_path; 
?>

<?php
// User DSN (Data Source Name)
$myGetArgs = filter_input_array(INPUT_GET);
$default="IN STOCK";

if (isset($myGetArgs['value'])){
    $default=$myGetArgs['value']; 
}
$userDSN = 'aucor';

// ODBC connection
$conn = odbc_connect($userDSN, '', '');

if (!$conn) {
    // Handle connection failure
    die("Connection failed: " . odbc_errormsg());
}


// Example query
$query = "SELECT top 40  * FROM [TGA LIST] where STATUS='$default' ";

// Execute query
$result = odbc_exec($conn, $query);

if (!$result) {
    // Handle query execution failure
    die("Query execution failed: " . odbc_errormsg($conn));
}

// Fetch results

echo categorylist($conn,$default);
Echo "<table class='spacing-table'> <caption>Current stock items - Demo Mode = top 40 only</caption>";

Echo "<tr>";
    echo "<th>Stock Number</td>";
    echo "<th>Make</td>";
    echo "<th>Model</td>";    
    echo "<th>Registration Number</td>";
    echo "<th>Engine Number</td>";
    echo "<th>VIN Number</td>";
    echo "<th>TRUSTEE BANK</td>";
    echo "<th>Status</td>";
    Echo "</tr>";
while ($row = odbc_fetch_array($result)) {
    Echo "<tr>";
    echo "<td  class='linked' onclick='openPopup(`".$row["Stock Number"]."`)' nowrap>".$row["Stock Number"]."</td>";
    echo "<td nowrap>".$row["Make"]."</td>";
    echo "<td nowrap>".$row["Model"]."</td>";
    echo "<td nowrap>".$row["Registration Number"]."</td>";
    echo "<td nowrap>".$row["Engine Number"]."</td>";
    echo "<td nowrap>".$row["VIN Number"]."</td>";
    echo "<td nowrap>".$row["TRUSTEE BANK"]."</td>";
    echo "<td nowrap>".$row["STATUS"]."</td>";
        
    Echo "</tr>";
}
Echo "</table>";

// Close connection
odbc_close($conn);
?>

<?php
get_footer();
?>