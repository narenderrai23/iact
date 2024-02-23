<?php

require '../../vendor/autoload.php';
include('../model/connection.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelExporter
{
    private $spreadsheet;
    private $dbConnection;

    function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->dbConnection = new Connection();
    }


    function modifyColumns($tableName, $columns)
    {
        return array_map(function ($column) use ($tableName) {
            return $tableName . '.' . $column;
        }, $columns);
    }

    function buildBaseQuery($tableName, $columns, $countable, $count, $join)
    {
        if ($count !== null) {
            $columns = array_merge($columns, $count);
        }
        $query = "SELECT " . implode(', ', $columns);

        $query .= $countable ? ", COUNT($count[0]) AS count" : '';

        $query .= " FROM $tableName";
        if (isset($join)) {
            foreach ($join as $table => $condition) {
                $query .= " LEFT JOIN $table ON $table.$condition[0] = $tableName.$condition[1]";
            }
        }
        return $query;
    }

    function fetchStudentData()
    {
        $conn = $this->dbConnection->getConnection();
        $table = "students";

        $columns = [
            'id', 'student_name', 'branch_id', 'student_district', 'qualification', 'course', 'student_state'
        ];
        $count = ['courses.course_code', 'tblbranch.name AS branch_name'];
        $join = [
            "tblbranch" => ["id", "branch_id"],
            "district" => ["id", "student_district"],
            "education_level" => ["id", "student_district"],
            "courses" => ["id", "course"],
            "states" => ["id", "student_state"],
        ];

        $columns = $this->modifyColumns($table, $columns);
        $query = $this->buildBaseQuery($table, $columns, false, $count, $join);
        return $query;

        // Initialize query and parameters
        // $query = "SELECT 
        //     $table.*,
        //     tblbranch.name AS branch_name, 
        //     tblbranch.code AS branch_code,
        //     district.district,
        //     education_level.level,
        //     courses.course_name,
        //     states.state_name
        //     FROM $table 
        //     LEFT JOIN tblbranch ON tblbranch.id = $table.branch_id
        //     LEFT JOIN district ON district.id = $table.student_district
        //     LEFT JOIN education_level ON education_level.id = $table.qualification
        //     LEFT JOIN courses ON courses.id = $table.course
        //     LEFT JOIN states ON states.id = $table.student_state";



        // $params = array();
        // $whereClause = [];

        // // Check user role and set conditions accordingly
        // $branchId = $_SESSION['role'] === 'branch' ? $_SESSION['loggedin'] : ($_POST['branch'] ?? null);
        // if ($branchId !== null) {
        //     $whereClause[] = "branch_id = :branchId";
        //     $params[':branchId'] = ['value' => $branchId, 'type' => PDO::PARAM_INT];
        // }

        // if (isset($_POST['join_date'])) {
        //     $value = $_POST['join_date'];
        //     if (strpos($value, 'to') !== false) {
        //         list($startDate, $endDate) = explode(" to ", $value);
        //         $whereClause[] = " $table.join_date BETWEEN '$startDate' AND '$endDate'";
        //     } else {
        //         $whereClause[] = " $table.join_date = '$value'";
        //     }
        // }

        // if (!empty($whereClause)) {
        //     $query .= " WHERE " . implode(" AND ", $whereClause);
        // }

        // if (!empty($_POST['limit'])) {
        //     $query .= " LIMIT :limit";
        //     $params[':limit'] = ['value' => $_POST['limit'], 'type' => PDO::PARAM_INT];
        // }
        // return $this->executeQuery($conn, $query, $params);
    }

    function executeQuery($conn, $query, $params = [])
    {
        $stmt = $conn->prepare($query);
        foreach ($params as $paramName => $paramData) {
            $stmt->bindParam($paramName, $paramData['value'], $paramData['type']);
        }
        $stmt->execute();
        return $stmt;
    }

    function export($headers, $stmt)
    {
        $worksheet = $this->spreadsheet->getActiveSheet();

        // Set column headers using a loop
        foreach ($headers as $key => $header) {
            $column = chr(65 + $key);
            $worksheet->setCellValue($column . '1', $header);
        }

        $columnMapping = [];
        $columnIndex = 0;

        foreach ($headers as $header) {
            $columnLetter = chr(65 + $columnIndex);
            $columnMapping[$header] = $columnLetter;
            $columnIndex++;
        }
        $columnMapping = array_flip(array_map(function ($key) {
            return strtolower(str_replace(' ', '_', $key));
        }, array_flip($columnMapping)));

        $rowNumber = 2;
        foreach ($stmt as $row) {
            foreach ($columnMapping as $column => $letter) {
                $worksheet->setCellValue($letter . $rowNumber, $row[$column]);
            }
            $rowNumber++;
        }


        $filename = 'students_export.xlsx';
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($filename);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        readfile($filename);

        unlink($filename);
    }
}
