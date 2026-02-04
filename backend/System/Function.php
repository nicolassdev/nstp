<?php
use System\Messages;

class myDataBase
{
    private $hostname;         // localhost
    private $username;         // root
    private $password;         // null
    private $database;         // lms_db
    private $con;




    // CONSTRUCTOR FOR MY DATABASE OBJECT
    public function __construct($hostname, $username, $password, $database)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    // DATABASE CONNECTION FUNCTION
    public function connection()
    {
        try {
            if (!$this->con) {
                $this->con = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
                if ($this->con) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e;
        }
    }

    //  DATABASE DISCONNECTION FUNCTION
    public function disconnect()
    {
        if ($this->con) {
            if (mysqli_close($this->con)) {
                $this->con = false;
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    // ENCRPYT PASSWORD
    public function encrypt($password)
    {
        $hash = sha1($password);
        return $hash;
    }


    //CHECK USER LOGIN 
    function checkLogin($username, $password)
    {
        // Escape the inputs to prevent SQL injection
        $username = mysqli_real_escape_string($this->con, $username);
        $password = mysqli_real_escape_string($this->con, $password);

        // Run a case-sensitive query by using the BINARY keyword
        $query = "SELECT * FROM `users` WHERE BINARY `username` = '$username' AND BINARY `password` = '$password'";
        $result = $this->con->query($query);

        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Function to set session data
    function setSessionData($data)
    {
        session_start();
        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    //GENERIC RANDOM PRIMARY ID FOR TABLES
    public function generateID($prefix)
    {
        $num = "1325476980";
        $rand = $prefix;

        for ($i = 0; $i < 4; $i++) {
            $rand .= $num[rand(0, strlen($num) - 1)];
        }

        return $rand;
    }

    // GENERATE TEACHER ID 
    // FORMAT : LAST 2 DIGIT OF THE YEAR / DOB/ RANDOM 4 DIGIT
    public function generateTeacherID($dob)
    {
        $year = date('y'); // Get the last 2 digits of the current year
        // Ensure the input is a valid date
        if (!$dob) {
            throw new Exception("Invalid date of birth provided.");
        }

        // Extract the year, month, and day from the teacher's date of birth
        $dob = new DateTime($dob);
        $dobyear = $dob->format('y'); // Last 2 digits of the birth year
        $month = $dob->format('m'); // Month in MM format
        $day = $dob->format('d'); // Day in DD format

        // Generate a 4-digit random number
        $randomFourNumbers = rand(1000, 9999); // Ensures a 4-digit number

        // Construct the ID: <last-digit-of-year>-<MMDD>-<4-random-digits>
        $teacherID = "{$year}-{$day}{$dobyear}{$month}-{$randomFourNumbers}";

        return $teacherID;
    }

    /*GEENERATE FACULTY USERNAME  */
    public function generateFacultyUsername($dob)
    {
        // Ensure the input is a valid date
        if (!$dob) {
            throw new Exception("Invalid date of birth provided.");
        }

        // Extract the year, month, and day from the teacher's date of birth
        $dob = new DateTime($dob);
        $dobyear = $dob->format('y'); // Last 2 digits of the birth year
        $month = $dob->format('m'); // Month in MM format
        $day = $dob->format('d'); // Day in DD format

        // Generate a 4-digit random number
        $randomFourNum = rand(1000, 9999); // Ensures a 4-digit number
        // Construct the ID: csi <last-digit-of-year>-<MMDD>-
        $facultyUsername = "LMS-{$day}{$dobyear}{$month}-{$randomFourNum}";    //LMS-051002-2152

        return $facultyUsername;
    }

    /*GEENERATE PASSWORD  */
    public function generatePassword($dob)
    {
        $year = date('Y'); // Get the last 2 digits of the current year
        // Ensure the input is a valid date
        if (!$dob) {
            throw new Exception("Invalid date of birth provided.");
        }

        // Extract the year, month, and day from the teacher's date of birth
        $dob = new DateTime($dob);
        $dobyear = $dob->format('y'); // Last 2 digits of the birth year
        $month = $dob->format('m'); // Month in MM format
        $day = $dob->format('d'); // Day in DD format

        // Construct the ID: csi <last-digit-of-year>-<MMDD>-
        $studPassword = "CSI-{$year}-{$day}{$dobyear}{$month}";    //csi-2024-051002

        return $studPassword;
    }

    //GET SCHOOL INFORMATIONM
    public function getSchool()
    {
        $sql = "SELECT * FROM `school`";
        $stored = ($this->con->query($sql))->fetch_assoc();
        return $stored;
    }

    // Get information from a specified table PRINCIPAL | REGISTRAR
    public function getInfo($tableName)
    {
        // Sanitize table name to prevent SQL injection
        $allowedTables = ['registrar', 'principal'];
        if (!in_array($tableName, $allowedTables)) {
            throw new Exception("Invalid table name");
        }

        // Modified SQL to include an inner join with the 'users' table to get role information
        $sql = "
        SELECT 
            t.*, 
            u.role
        FROM `$tableName` t
        INNER JOIN `users` u ON u.id = t.id";

        // Execute the query and fetch the result
        $stored = ($this->con->query($sql))->fetch_assoc();

        return $stored;
    }

    //GET STUDENT INFORMATION BY INDIVIDUAL
    public function getStudentInfo($studentID)
    {
        $sql = "SELECT * FROM `student` WHERE stu_lrn = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    // Account getters
    public function getAccountUser($id)
    {
        $sql = "SELECT * FROM `users` WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }


    public function getTeacherInfo($teacher_id)
    {
        $sql = "SELECT * FROM `teacher` WHERE teacher_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }






    // GET ALL Adviser and classmate of student


    //UPDATE REGISTRAR AND PRINCIPAL INFORMATION
    public function updateUserInfo($table, $data)
    {
        // Ensure the table name is safe (e.g., against SQL injection)
        $table = mysqli_real_escape_string($this->con, $table);

        // Prepare the SET clause
        $setClause = [];
        foreach ($data as $column => $value) {
            $escapedValue = mysqli_real_escape_string($this->con, $value);
            $setClause[] = "`$column` = '$escapedValue'";
        }

        // Join the SET clauses
        $setString = implode(", ", $setClause);

        // Construct the SQL query
        $sql = "UPDATE `$table` SET $setString"; // You might want to add a WHERE clause for specific records

        // Execute the query
        $result = $this->con->query($sql);

        // Return the result of the query
        return $result;
    }


    function getStudentEnrolled($row, $value)
    {
        $sql = "SELECT * FROM `enroll` WHERE `$row` = '$value'";
        $stored = ($this->con->query($sql))->fetch_assoc();
        return $stored;
    }

    // GET STUDENT ACCOUNTS
    public function getStudentAccounts($role = 'STUDENT')
    {
        // Prepare the query to get only users with the specified role and their corresponding student info
        $stmt = $this->con->prepare("
         SELECT u.id, u.username, u.password, u.role, u.date_added, s.stu_dob, s.stu_fname, s.stu_mname, s.stu_lname
        FROM `users` u
        JOIN `student` s ON u.username = s.stu_lrn
        WHERE u.role = ? 
        ORDER BY s.stu_id DESC");
        $stmt->bind_param('s', $role); // 's' denotes the type (string)
        $stmt->execute();
        $stored = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $stored;
    }


    // GET TEACHER ACCOUNTS
    public function getTeacherAccounts($role = 'TEACHER')
    {
        // Prepare the query to get only users with the specified role and their corresponding student info
        $stmt = $this->con->prepare("
        SELECT u.id, u.username, u.password, u.role, u.date_added, 
        t.teacher_dob, t.teacher_fname, t.teacher_mname, t.teacher_lname
        FROM `users` u
        JOIN `teacher` t ON u.id = t.id
        WHERE u.role = ?
        ORDER BY t.teacher_id DESC
        ");
        $stmt->bind_param('s', $role); // 's' denotes the type (string)
        $stmt->execute();
        $stored = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $stored;
    }


    // General function for getting credentials
    function getCredential($table, $row, $value)
    {
        $sql = "SELECT * FROM `$table` WHERE `$row` = '$value'";
        $stored = ($this->con->query($sql))->fetch_assoc();
        return $stored;
    }


    // COUNT THE NUMBER OF ROWS IN TABLE
    public function checkRowCount($table, $row = null, $value = null)
    {
        if ($row != null &&  $value != null) {
            $sql = "SELECT * FROM `$table` WHERE `$row` = '$value'";
        } else {
            $sql = "SELECT * FROM `$table`";
        }

        $result = mysqli_num_rows($this->con->query($sql));

        return $result;
    }


    public function checkExistByMultipleIDs($table, $conditions)
    {
        $sql = "SELECT 1 FROM `$table` WHERE ";
        $whereClauses = [];

        foreach ($conditions as $column => $value) {
            $value = mysqli_real_escape_string($this->con, $value);
            $whereClauses[] = "`$column` = '$value'";
        }

        $sql .= implode(" AND ", $whereClauses);
        $sql .= " LIMIT 1";

        $query = $this->con->query($sql);

        if ($query) {
            return $query->num_rows > 0;
        } else {
            // Handle query error (e.g., log it)
            return false;
        }
    }


    public function checkExistByID($table, $column, $value)
    {
        if (!empty($value)) {
            $value = mysqli_real_escape_string($this->con, $value);
            $sql = "SELECT 1 FROM `$table` WHERE `$column` = '$value' LIMIT 1";
        } else {
            return 0; // Or throw an exception
        }

        $query = $this->con->query($sql);

        if ($query) {
            return $query->num_rows > 0;
        } else {
            // Handle query error (e.g., log it)
            return false;
        }
    }


    // COUNT THE NUMBER OF ROWS IN TABLE TO VALIDATION SELECTED IN UPDATE
    public function checkRowCountSubject($table, $row = null, $value = null, $id = null)
    {
        if ($row != null && $value != null) {
            // Adjust the query to exclude the current subject ID
            $sql = "SELECT * FROM `$table` WHERE `$row` = '$value'";
            if ($id != null) {
                $sql .= " AND `sub_code` != '$id'"; // Assuming `sub_id` is the primary key
            }
        } else {
            $sql = "SELECT * FROM `$table`";
        }

        $result = mysqli_num_rows($this->con->query($sql));

        return $result;
    }

    // Check if section name already exist 
    public function checkSectionName($table, $row = null, $value = null, $id = null)
    {
        if ($row != null && $value != null) {
            // Adjust the query to exclude the current subject ID
            $sql = "SELECT * FROM `$table` WHERE `$row` = '$value'";
            if ($id != null) {
                $sql .= " AND `section_code` != '$id'"; // Assuming `sub_id` is the primary key
            }
        } else {
            $sql = "SELECT * FROM `$table`";
        }

        $result = mysqli_num_rows($this->con->query($sql));

        return $result;
    }

    // Check if the strand , grade level and strand are already exist 
    public function checkRowCountSection($table, $section_name, $grade_lvl, $section_id = null)
    {
        // Prepare the SQL query to check for the section name and grade level
        $sql = "SELECT * FROM `$table` WHERE `section_name` = ? AND `grade_lvl` = ?";

        // If we are updating an existing record, exclude that record from the check
        if ($section_id != null) {
            $sql .= " AND `section_code` != ?";
        }

        // Prepare the SQL statement
        $stmt = $this->con->prepare($sql);

        // Bind the parameters dynamically based on whether section_id is provided
        if ($section_id != null) {
            $stmt->bind_param("sss", $section_name, $grade_lvl, $section_id);
        } else {
            $stmt->bind_param("ss", $section_name, $grade_lvl);
        }

        $stmt->execute();
        $stmt->store_result();
        // Return the number of rows found (if > 0, it means the combination exists)
        return $stmt->num_rows;
    }


    function checkEnrollmentInSemester($stu_lrn, $semester)
    {
        // Connect to the database
        $this->connection();

        // Query to check if the student is already enrolled in the specified semester and section
        $sql = "SELECT COUNT(*) as enrolled_count FROM enroll WHERE stu_lrn = ? AND semester = ?";

        // Prepare the SQL statement
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ss", $stu_lrn, $semester);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc() ?? ['enrolled_count' => 0];

        // Close the statement and connection
        $stmt->close();
        $this->disconnect();

        // Return the count; if it's 0, the student is not enrolled
        return $row['enrolled_count'];
    }


    //Check active STATUS in school year
    public function checkSyStatus($table)
    {
        $activeSchoolYear = [];
        // Prepare the SQL query to get the active status and the school_year from the sy table
        $sql = "SELECT `school_year` 
                FROM `$table`
                WHERE `status` = 'Active'";

        // Execute the query
        $result = $this->con->query($sql);

        // Check if the query was successful
        if ($result->num_rows > 0) {
            // Fetch the school year of the active row
            $activeSchoolYear = [];
            while ($row = $result->fetch_assoc()) {
                $activeSchoolYear[] = $row['school_year'];
            }

            // Return the active school year(s)
            return $activeSchoolYear;
        } else {
            return []; // Return an empty array if no active school year is found
        }
    }

    //Check active STATUS in semester
    public function checkSemStatus($table)
    {
        $semesters = [];

        // Prepare the SQL query to get the active semester name
        $sql = "SELECT `semester_name` 
                FROM `$table`
                WHERE `status` = 'Active'";

        // Execute the query
        $result = $this->con->query($sql);

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Fetch the active semester(s)
            while ($row = $result->fetch_assoc()) {
                $semesters[] = $row['semester_name'];
            }

            // Return the active semester(s)
            return $semesters;
        } else {
            return []; // Return an empty array if no active semester is found
        }
    }

    //Check active STATUS in semester
    public function checkQuarterStatus($table)
    {
        $quarter = [];

        // Prepare the SQL query to get the active semester name
        $sql = "SELECT `quarterly_name` 
                    FROM `$table`
                    WHERE `status` = 'Active'";

        // Execute the query
        $result = $this->con->query($sql);

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Fetch the active semester(s)
            while ($row = $result->fetch_assoc()) {
                $quarter[] = $row['quarterly_name'];
            }

            // Return the active semester(s)
            return $quarter;
        } else {
            return []; // Return an empty array if no active semester is found
        }
    }

    // Check if schedule id is exist in the exam table
    public function checkExistExam($sched_id)
    {
        $activeQuarter = $this->checkQuarterStatus('quarterly');

        if (empty($activeQuarter)) {
            return false; // No active quarter, no need to check
        }

        $activeQuarterCondition = "exam_quarter IN ('" . implode("','", $activeQuarter) . "')";

        $sql = "SELECT COUNT(*) as count FROM `exam` WHERE `sched_id` = '$sched_id' AND $activeQuarterCondition";

        $result = $this->con->query($sql);
        $row = $result->fetch_assoc();

        return ($row['count'] > 0); // Return true if exam exists, otherwise false
    }

    public function getActiveSemester()
    {
        // Query to get the active semester
        $sql = "SELECT semester_name FROM semester WHERE status = 'Active' LIMIT 1";
        $result = $this->con->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['semester_name'];  // Return the semester name if found
        }

        // Return null if no active semester is found
        return null;
    }

    public function checkUserExist($username)
    {
        $sql = "SELECT * FROM users WHERE  username = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s",  $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Return the first row if exists
    }

    // CHECK IF THE STUDENT AND FACULTY FIRST NAME AND LAST NAME IF ALREADY EXIST 
    public function checkEntityExist($table, $firstnameColumn, $lastnameColumn, $idColumn, $firstname, $lastname, $excludeID)
    {
        $sql = "SELECT * FROM $table WHERE $firstnameColumn = ? AND $lastnameColumn = ? AND $idColumn != ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sss", $firstname, $lastname, $excludeID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Return the first row if exists
    }

    // Check if the id's in row in table schedule was duplicate 
    public function checkDuplicateID($table, $firstColumn, $secondColumn, $idColumn, $section_code, $sub_code, $excludeID)
    {
        // Prepare the SQL query
        $sql = "SELECT * FROM $table WHERE $firstColumn = ? AND $secondColumn = ? AND $idColumn != ?";
        $stmt = $this->con->prepare($sql);

        // Bind the parameters
        $stmt->bind_param("sss", $section_code, $sub_code, $excludeID);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the result
        return $result->num_rows > 0; // Return true if a duplicate exists
    }


    public function checkSectionExist($strand, $section, $adviser)
    {
        $sql = "SELECT * FROM section WHERE strand_code =? AND section_name =? AND  teacher_id =?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ssi", $strand, $section, $adviser);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); // Return the first row if exists
    }

    public function checkSubjectExist($subject, $type, $excludeID)
    {
        $sql = "SELECT * FROM subject WHERE sub_title =? AND sub_type =? AND sub_code =?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ssi", $subject, $type, $excludeID);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); // Return the first row if exists
    }


    public function insertSy($table, $sy)
    {
        // First, check if the school year already exists in the table
        $checkSql = "SELECT * FROM `$table` WHERE `school_year` = ?";
        $stmt = $this->con->prepare($checkSql);
        $stmt->bind_param("s", $sy);
        $stmt->execute();
        $result = $stmt->get_result();

        // If a record exists, return false (school year already exists)
        if ($result->num_rows > 0) {
            return false; // School year already exists
        }

        // If no record exists, proceed with updating and inserting
        $sql = "UPDATE `sy` SET `status` = 'Inactive'";
        $result = $this->con->query($sql);

        if ($result) {
            // Prepare to insert the new school year with the status 'Active'
            $insertSql = "INSERT INTO `$table` (`school_year`, `status`) VALUES (?, 'Active')";
            $stmt = $this->con->prepare($insertSql);
            $stmt->bind_param("s", $sy);

            // Execute the insert and check if successful
            if ($stmt->execute()) {
                return true; // Successfully inserted
            } else {
                return false; // Error during insertion
            }
        } else {
            return false; // Error during update
        }
    }


    // INSERT INTO TABLE SEMESTER
    public function insertSem($table, $sem)
    {
        $sql = "UPDATE `semester` SET `status` = 'Inactive'";
        $result = $this->con->query($sql);

        if ($result) {
            // Check if the semester already exists
            $checkSql = "SELECT * FROM `$table` WHERE `semester_name` = '$sem'";
            $checkResult = $this->con->query($checkSql);

            if ($checkResult->num_rows == 0) {
                // Insert only if the record does not exist
                $sql = "INSERT INTO `$table` (`semester_name`, `status`) VALUES ('$sem', 'Active')";
                return $this->con->query($sql);
            } else {
                return false; // semester already exists
            }
        } else {
            return false;
        }
    }

    // INSERT INTO TABLE QUARTERLY
    public function insertQuarter($table, $quarter)
    {
        // Set all existing records to Inactive
        $sql = "UPDATE `quarterly` SET `status` = 'Inactive'";
        $result = $this->con->query($sql);

        if ($result) {
            // Check if the quarter already exists
            $checkSql = "SELECT * FROM `$table` WHERE `quarterly_name` = '$quarter'";
            $checkResult = $this->con->query($checkSql);

            if ($checkResult->num_rows == 0) {
                // Insert only if the record does not exist
                $sql = "INSERT INTO `$table` (`quarterly_name`, `status`) VALUES ('$quarter', 'Active')";
                return $this->con->query($sql);
            } else {
                return false; // Quarter already exists
            }
        } else {
            return false;
        }
    }


    public function checkExistingSem($table, $semester)
    {
        $sql = "SELECT * FROM $table WHERE semester_name = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $semester);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Returns true if a record exists, false otherwise
    }


    public function checkExistingQuarter($table, $quarter)
    {
        $sql = "SELECT * FROM $table WHERE quarterly_name = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $quarter);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Returns true if a record exists, false otherwise
    }


    public function checkExistingSY($table, $sy)
    {
        $sql = "SELECT * FROM $table WHERE school_year = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $sy);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Returns true if a record exists, false otherwise
    }


    //UPDATE INTO TABLE ACTIVE SY
    public function setSchoolYear($table, $sy, $id)
    {
        try {
            // Step 1: Set all rows to 'Inactive'
            $sql = "UPDATE `$table` SET `status` = 'Inactive'";
            $this->con->query($sql);

            // Step 2: Set the selected row to 'Active' based on the passed school year ID
            $sql = "UPDATE `$table` SET `status` = 'Active' WHERE `school_year` = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('s', $id);
            $stmt->execute();

            // Step 3: Return the success or failure of the operation
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Log the error for debugging purposes
            error_log("Error updating school year status: " . $e->getMessage());
            return false;
        }
    }

    //UPDATE INTO TABLE ACTIVE SEMESTER
    public function setSemester($table, $sy, $id)
    {
        try {
            // Step 1: Set all rows to 'Inactive'
            $sql = "UPDATE `$table` SET `status` = 'Inactive'";
            $this->con->query($sql);

            //Set the selected row to 'Active' based on the passed school year ID
            $sql = "UPDATE `$table` SET `status` = 'Active' WHERE `semester_name` = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('s', $id);
            $stmt->execute();

            // Return the success or failure of the operation
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Log the error for debugging purposes
            error_log("Error updating school year status: " . $e->getMessage());
            return false;
        }
    }





    /**
     * Build API response
     *
     * @param array $data Array of data to build
     * @param array $response_column Array of allowed columns in response
     * @param bool $status Flag for sending success or fail response
     * @return false|string JSON-encoded response or array of values
     */
    function buildApiResponse(array $data = array(), array $response_column = array(), bool $status = true)
    {
        // Check if data is a multi-dimensional array
        if (count($data) === count($data, COUNT_RECURSIVE)) {
            // Not multi-dimensional
            $filtered = array_intersect_key($data, array_flip($response_column));
        } else {
            // Check if array has a normal multi-dimensional indexing
            if (array_key_exists(0, $data)) {
                $filtered = array_map(function ($arr) use ($response_column) {
                    return array_intersect_key($arr, array_flip($response_column));
                }, $data);
            } else {
                // AKO BUDOY!
                $filtered = array_intersect_key($data, array_flip($response_column));
            }
        }

        return $status
            ? $this->Messages->jsonSuccessResponse($filtered)
            : $this->Messages->jsonFailResponse($data);
    }

    /**
     * Trim payload
     *
     * @param mixed $payload Payload to be trimmed
     * @return array|string Trimmed array or string
     */
    public function trimPayload($payload)
    {
        return is_array($payload) ? array_map(array($this, 'trimPayload'), $payload) : (!is_int($payload) && empty($payload) ? null : trim($payload));
    }
}
