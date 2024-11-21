
        <?php
        // put your code here
        
      
        
        function copyTableFromAccessToMySQL($tableName, $odbcDsn, $odbcUsername, $odbcPassword, $mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase)
{
    try {
        // Connect to ODBC data source
        $odbcConn = odbc_connect($odbcDsn, $odbcUsername, $odbcPassword);
        if (!$odbcConn) {
            throw new Exception("Failed to connect to ODBC data source");
        }

        // Connect to MySQL database
        $mysqlConn = new mysqli($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase);
        if ($mysqlConn->connect_error) {
            throw new Exception("Failed to connect to MySQL database: " . $mysqlConn->connect_error);
        }

        
        // Check if the specified table already exists in MySQL database
        $mysqlTableExistsQuery = "SHOW TABLES LIKE '" . $mysqlConn->real_escape_string($tableName) . "'";
        $mysqlTableExistsResult = $mysqlConn->query($mysqlTableExistsQuery);
        if (!$mysqlTableExistsResult) {
            throw new Exception("Failed to check if table exists in MySQL database: " . $mysqlConn->error);
        }

        // If the table doesn't exist in MySQL, create it
        if ($mysqlTableExistsResult->num_rows == 0) {
            $createTableQuery = "CREATE TABLE `" . $mysqlConn->real_escape_string($tableName) . "` (id INT AUTO_INCREMENT PRIMARY KEY)";
            if (!$mysqlConn->query($createTableQuery)) {
                throw new Exception("Failed to create table in MySQL database: " . $mysqlConn->error);
            }
            echo "Table created: $tableName\n";
        }

        // Copy data from MS Access to MySQL table
        $copyDataQuery = "INSERT INTO `" . $mysqlConn->real_escape_string($tableName) . "` SELECT * FROM [$tableName]";
        if (!$mysqlConn->query($copyDataQuery)) {
            throw new Exception("Failed to copy data to MySQL table: " . $mysqlConn->error);
        }
        echo "Data copied: $tableName\n";

        // Close connections
        odbc_close($odbcConn);
        $mysqlConn->close();

        echo "Table copied successfully from MS Access to MySQL";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
// Function to copy tables from MS Access to MySQL
function copyTablesFromAccessToMySQL($odbcDsn, $odbcUsername, $odbcPassword, $mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase)
{
    try {
        // Connect to ODBC data source
        $odbcConn = odbc_connect($odbcDsn, $odbcUsername, $odbcPassword);
        if (!$odbcConn) {
            throw new Exception("Failed to connect to ODBC data source");
        }
 
        // Connect to MySQL database
        $mysqlConn = new mysqli($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase);
        if ($mysqlConn->connect_error) {
            throw new Exception("Failed to connect to MySQL database: " . $mysqlConn->connect_error);
        }

        // Get list of tables from MS Access database
        $tablesQuery = "SELECT [Name] FROM MSysObjects WHERE Type=1 AND Flags=0";
        $tablesResult = odbc_exec($odbcConn, $tablesQuery);
        if (!$tablesResult) {
            throw new Exception("Failed to execute query to get tables from MS Access database");
        }

        // Loop through tables
        while ($tableRow = odbc_fetch_array($tablesResult)) {
            $tableName = $tableRow['Name'];

            // Check if table already exists in MySQL database
            $mysqlTableExistsQuery = "SHOW TABLES LIKE '" . $mysqlConn->real_escape_string($tableName) . "'";
            $mysqlTableExistsResult = $mysqlConn->query($mysqlTableExistsQuery);
            if (!$mysqlTableExistsResult) {
                throw new Exception("Failed to check if table exists in MySQL database: " . $mysqlConn->error);
            }

            // If table doesn't exist in MySQL, create it
            if ($mysqlTableExistsResult->num_rows == 0) {
                $createTableQuery = "CREATE TABLE `" . $mysqlConn->real_escape_string($tableName) . "` (id INT AUTO_INCREMENT PRIMARY KEY)";
                if (!$mysqlConn->query($createTableQuery)) {
                    throw new Exception("Failed to create table in MySQL database: " . $mysqlConn->error);
                }
                echo "Table created: $tableName\n";
            }

            // Copy data from MS Access to MySQL table
            $copyDataQuery = "INSERT INTO `" . $mysqlConn->real_escape_string($tableName) . "` SELECT * FROM [$tableName]";
            if (!$mysqlConn->query($copyDataQuery)) {
                throw new Exception("Failed to copy data to MySQL table: " . $mysqlConn->error);
            }
            echo "Data copied: $tableName\n";
        }

        // Close connections
        odbc_close($odbcConn);
        $mysqlConn->close();

        echo "All tables copied successfully from MS Access to MySQL";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


        
        
        function categorylist($conn,$default)
        {
            $query = "SELECT STATUS FROM [TGA LIST]";

            $result = odbc_exec($conn, $query);
            if (!$result) {
                // Handle query execution failure
                die("Query execution failed: " . odbc_errormsg($conn));
            }
            $categories="Select Status: <select onchange='changeover(this.value);' name='categories' id='categories' value='$default'>";
            $tester="";
            while ($row = odbc_fetch_array($result)) {
                $status=$row["STATUS"];
                if (str_contains($tester,$status)){
                    
                }else{
                    $tester.="||".$status."||";
                    if ($status===$default){$selected="selected";}else{$selected="";}
                    $categories.="<option $selected value='$status'>$status</option>";
                    
                }
            }
            $categories.="</select>";
            Return $categories;
        }
        
        function opendata($query){
            $userDSN = 'aucor';
            // ODBC connection
            $result = fetchODBCRecordset($userDSN, $query);
            if (!$result) {
                // Handle query execution failure
                die("Query execution failed: " . odbc_errormsg($conn));
            }
            return $result;

        }
        
        function fetchODBCRecordset($dsn, $query) {
            // Connect to ODBC
            $conn = odbc_connect($dsn, '', '');

            if (!$conn) {
                // Handle connection failure
                return false;
            }

            // Execute query
            $result = odbc_exec($conn, $query);

            if (!$result) {
                // Handle query execution failure
                odbc_close($conn);
                return false;
            }

            // Fetch results
            $recordset = [];
            while ($row = odbc_fetch_array($result)) {
                $recordset[] = $row;
            }

            // Close connection
            odbc_close($conn);

            // Return the recordset
            return $recordset;
        }

        ?>
   