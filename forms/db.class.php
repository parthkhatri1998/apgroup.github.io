<?php

class Database
{//

    var $_DB;
    var $_dbName;
    var $_dbHost;
    var $_dbUser;
    var $_dbPass;
    var $_lastHandle = false;
    var $_link = false;

    ///////// Constructor /////////
    function __construct($DB = 'mysql', $dbHost = "localhost", $dbName = "apgroup", $dbUser = "root", $dbPass = "P@rth22586")
    {
        $this->_DB = $DB ? $DB : 'mysql';
        $this->_dbName = $dbName ? $dbName : $GLOBALS['dbName'];
        $this->_dbHost = $dbHost ? $dbHost : $GLOBALS['dbHost'];
        $this->_dbUser = $dbUser ? $dbUser : $GLOBALS['dbUser'];
        $this->_dbPass = "P@rth22586";

        switch ($this->_DB) {
            case 'mysql':
                $this->_link = mysqli_connect($this->_dbHost, $this->_dbUser, $this->_dbPass, $this->_dbName) or die("Database connection error!");
                break;
            default:
                die("Database system unknown!");
        }
    }

    public function __destruct()
    {
        mysqli_close($this->_link);
    }

    ///////////// Performs a generic SQL query./////////
    function Query($query)
    {
        switch ($this->_DB) {
            case 'mysql':

                //print "<hr size=1 noshade>".$query."<hr size=1 noshade>";
                $handle = mysqli_query($this->_link, $query);
                if (!$handle) {
                    die(mysqli_error($this->_link));
                }
                break;
        }
        if ($this->ErrorNo() > 0) {
            echo $query;
            print("<hr />Database Error: " . $this->Error() . "><br><pre >");
            print_r(debug_backtrace());
            die("</pre><hr />");

        };
        $this->_lastHandle = $handle;
        return $handle;
    }


    ///////////// Gets next row of a query. Returns false when finished.////////////////////////
    function GetRow($handle = false)
    {
        if ($handle) $handle = $this->_lastHandle;
        switch ($this->_DB) {
            case 'mysql':
                $row = mysqli_fetch_assoc($handle);
                break;
        }
        return $row;
    }


    ////////////// Returns the database error for a specific query.//////////////////
    function Error($handle = false)
    {
        switch ($this->_DB) {
            case 'mysql':
                $err = ($handle) ? mysqli_error($this->_link) : mysqli_error($this->_link);
                break;
        }
        return $err;
    }

    /////////////////// Returns the database error  for a specific query ////////
    function ErrorNo($handle = false)
    {
        switch ($this->_DB) {
            case 'mysql':
                $err_no = ($handle) ? mysqli_error($this->_link) : mysqli_error($this->_link);
                break;
        }
        return $err_no;
    }

    //////////////// Returns all the info from a query /////////////////////
    function GetAllRows($handle = false)
    {
        if ($handle) $handle = $this->_lastHandle;
        $ret = array();
        switch ($this->_DB) {
            case 'mysql':
                while ($row = mysqli_fetch_assoc($handle)) {
                    $ret[] = $row;
                }
                break;
        }
        return $ret;
    }


///////////////// Inserts a row into database //////////////

    function InsertUnique($data, $table, $col, $colVal, $dump = false)
    {

        $names = "";
        $values = "";
        $temps = "";
        foreach ($data as $name => $value) {
            $temp_col = $name;
            $names .= "`$name`, ";
            $temps .= "'$value' as $name, ";
            if (strtoupper($value) != "NULL")
                $values .= "'" . addslashes($value) . "', ";
            else
                $values .= addslashes($value) . ", ";
        }
        $names = substr($names, 0, strlen($names) - 2);
        $temps = substr($temps, 0, strlen($temps) - 2);
        $values = substr($values, 0, strlen($values) - 2);
        $query = "INSERT  `$table` ($names)
		SELECT * FROM (SELECT  $temps) AS tmp
		WHERE NOT EXISTS (
		SELECT $col FROM $table WHERE $col = '" . $colVal . "'
		)";
        if ($dump) {
            echo $query;
        }


        //return $this->Query($query);
        mysqli_query($this->_link, $query);
        if (mysqli_affected_rows($this->_link) > 0) {
            return mysqli_insert_id($this->_link);
        }
        // if(mysqli_query($this->_link,$query)){
        // 	echo "ok";
        // }else{
        // 	exit;
        // }

    }


    function Insert($data, $table)
    {
        $names = "";
        $values = "";
        foreach ($data as $name => $value) {
            $names .= "`$name`, ";
            if (strtoupper($value) != "NULL")
                $values .= "'" . addslashes($value) . "', ";
            else
                $values .= addslashes($value) . ", ";
        }
        $names = substr($names, 0, strlen($names) - 2);
        $values = substr($values, 0, strlen($values) - 2);
        $query = "INSERT INTO `$table` ($names) VALUES ($values)";
        //print $query."<br>";
        //die($query);
        return $this->Query($query);

    }


    function Insert2($data, $table)
    {
        $names = "";
        $values = "";
        foreach ($data as $name => $value) {

            if (strtoupper($value) != "NULL" && substr($name, 0, 1) != "*")
                $values .= "'" . addslashes($value) . "', ";
            else {
                $values .= addslashes($value) . ", ";
                if (substr($name, 0, 1) == "*")
                    $name = substr($name, 1);
            }

            $names .= "`$name`, ";
        }
        $names = substr($names, 0, strlen($names) - 2);
        $values = substr($values, 0, strlen($values) - 2);
        $query = "INSERT INTO `$table` ($names) VALUES ($values)";
        //print $query."<br>";

        return $this->Query($query);
    }


    /////////////////////// Updates the database ////////////
    function Update($data, $table, $conditions = false)
    {

        $query = "UPDATE `$table` SET ";
        foreach ($data as $name => $value) {
            if (strtoupper($value) != "NULL")
                $query .= "`$name` = '" . addslashes($value) . "', ";
            else
                $query .= "`$name` = " . addslashes($value) . ", ";

        }
        $query = substr($query, 0, strlen($query) - 2);
        if ($conditions) $query .= " WHERE $conditions";
        //print $query."<br>";die;
        return $this->Query($query);
    }


    // Delete from the database
    function Delete($table, $conditions = false)
    {
        $query = "DELETE FROM `$table`";
        if ($conditions) $query .= " WHERE $conditions";
        return $this->Query($query);
    }

    function Free($res)
    {
        mysqli_free_result($res);
    }

    function LastInsert($table)
    {
        $query = 'SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES  WHERE  TABLE_NAME = "' . $table . '"';
        $res = $this->Query($query);
        list($lastid) = mysqli_fetch_row($res);
        $this->Free($res);
        return ($lastid++);
    }


    function MAX($fld, $table)
    {
        $query = "SELECT MAX(`$fld`) maxVal FROM `$table`";
        $res = $this->Query($query);
        $rslt = mysqli_fetch_assoc($res);
        $max = $rslt["maxVal"];
        $this->Free($res);
        return $max;
    }

    function getFieldColl($tableName, $excludlist = NULL)
    {
        if (!is_array($excludlist)) $excludlist = array();
        //print_r($excludlist);
        $sql = "SHOW COLUMNS FROM {$tableName}";
        $result = $this->Query($sql);
        if (!$result) {
            echo 'Could not run query: ' . mysqli_error($this->_link);
            exit;
        }
        if (mysqli_num_rows($result) > 0) {
            $Fields = "";
            while ($row = mysqli_fetch_assoc($result)) {
                $Field = $row['Field'];
                $Extra = $row['Extra'];

                if (!is_numeric(array_search($Field, $excludlist))) //filter out auto increment field
                    $Fields .= $Fields == "" ? $Field : "," . $Field;
            }
            return (split(",", $Fields));
        }
    }

    //get Database Name
    function getDBName()
    {
        return $this->_dbName;
    }
}

?>
