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
    </head>
    <body>
        <?php
        // put
        include_once 'steve_functions.php';
        ini_set('display_errors',1);
        error_reporting(E_ALL ^ E_DEPRECATED);
        $myGetArgs = filter_input_array(INPUT_GET);
        $make="";  
        $model="";
        $status="IN STOCK";
        $value="";
        if (isset($myGetArgs['value'])){        
            $value=$myGetArgs['value'];
            $query="SELECT * FROM [TGA LIST] where [Stock Number]='$value' ";
            $recordset = opendata($query);
            $make=$recordset[0]["Make"];
            $model=$recordset[0]["Model"];
            $status=$recordset[0]["STATUS"];
            
            //var_dump($recordset);
            
        } else{   
            
            $query="SELECT top 1 * FROM [TGA LIST] where [Stock Number]='49181'";
            $recordset = opendata($query);
            $row=$recordset[0];
            foreach ($row as $column => $value) {
                $value="";
            }
        }
        
        
        
        ?>
        
        <table>
            
        
            <?php
            if (isset($myGetArgs['value'])){
                $row=$recordset[0];
                foreach ($row as $column => $value) {
                    echo "<tr><td>$column:</td><td><input id='$column' value='$value'></td></tr>";
                }
            }else{
                $row=$recordset[0];
                foreach ($row as $column => $value) {
                    echo "<tr><td>$column:</td><td><input id='$column' value=''></td></tr>";
                }
            }
                
            ?>
            
            
    </body>
</html>
