<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel='stylesheet' href='style.css'>
        <script>
        
        function openPopup(thevalue) {
            const popupName = "PopupWindow";
            const features = "width=600,height=400,scrollbars=yes,resizable=yes";
            var currentPath = window.location.pathname;
            var newPath = "detail.php?value="+thevalue;
            window.location.href=newPath;
        }

    
</script>

    </head>
    <body>
        

<?php
include_once 'steve_functions.php';
?>

<?php
// User DSN (Data Source Name)
$myGetArgs = filter_input_array(INPUT_GET);
$make="";
$model="";
$status="IN STOCK";
if (isset($myGetArgs["Make"])){
    $make=$myGetArgs["Make"];
}
if (isset($myGetArgs["Model"])){
    $model=$myGetArgs["Model"];
}
if (isset($myGetArgs["Status"])){
    $status=$myGetArgs["Status"];
}
$query="";
if ($status<>""){
    if ($query==""){
        $query.=" where STATUS='$status'";        
    }
    else
    {
        $query.=" and STATUS='$status'";
    }
}
if ($make<>""){
    if ($query==""){
        $query.=" where MAKE = '$make'";        
    }
    else
    {
        $query.=" and MAKE = '$make'";
    }
}
if ($model<>""){
    if ($query==""){
        $query.=" where MODEL = '$model'";        
    }
    else
    {
        $query.=" and MODEL = '$model'";
    }
}

// Example query
$query = "SELECT top 50  * FROM [TGA LIST] $query order by Model";

// Execute query
$recordset = opendata($query);

// Fetch results

Echo "<table class='spacing-table'> ";

Echo "<tr>";
    echo "<th>Stock Number</td>";
    echo "<th>Model</td>";    
    echo "<th>Registration Number</td>";
    echo "<th>Engine Number</td>";
    echo "<th>VIN Number</td>";
    echo "<th>TRUSTEE BANK</td>";
    echo "<th>Status</td>";
    Echo "</tr>";
    
    
    foreach ($recordset as $row) {
        Echo "<tr>";
        echo "<td  class='linked' onclick='openPopup(`".$row["Stock Number"]."`)' nowrap>".$row["Stock Number"]."</td>";
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
// odbc_close($conn);
?>


    </body>
</html>
