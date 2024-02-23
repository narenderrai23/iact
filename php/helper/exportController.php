<?php
require_once('export.php');
require_once('../model/students.php');
// require_once('export1.php');


if (isset($_POST['action']) && $_POST['action'] === 'students') {
    $headers = [
        'Branch code',
        'Enrollment',
        'Student Name',
        'Father Name',
        'Student Phone',
        'Student Email',
        'Student Status',
        'Student Whatsapp Phone',
        'Course Name',
        'Branch Name',
        'Date admission',
        'Approve',
        'State Name',
        'Status',
        'Address1',
        'Address2',
        'PQualification',
        'District'
    ];
    $exporter = new ExcelExporter();
    $stmt = $exporter->fetchStudentData();
    // $exporter->export($headers, $stmt);
    // print_r($_POST);
    print_r($stmt);

}

// if (isset($_POST['action']) && $_POST['action'] === 'branch') {
//     $exporter = new ExcelBranch();
//     $exporter->exportBranch();
// }
