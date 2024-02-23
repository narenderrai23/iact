<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/students.php');

if (isset($_POST['action'])) {
    $Student = new Student();

    if ($_POST['action'] === 'addStudent') {
        $data = $Student->insertStudent();
        echo json_encode($data);
    }

    if ($_POST['action'] === 'updateStudent') {
        $data = $Student->updateStudent();
        echo json_encode($data);
    }

    if ($_POST['action'] === 'updateStudent_old') {
        $data = $Student->oldUpdateStudent();
        echo json_encode($data);
    }

    if ($_POST['action'] === 'statusUpdate') {
        $id = $_POST['itemId'];
        $data = $Student->statusUpdate($id, 'students');
        echo json_encode($data);
    }

    if ($_POST['action'] === 'updateStudentStatus_new') {
        $id = $_POST['id'];
        $status =  $_POST['status'];
        $data = $Student->updateStudentStatus($id, $status, 'students');
        echo json_encode($data);
    }

    if ($_POST['action'] === 'updateStudentStatus_old') {
        $id = $_POST['id'];
        $status =  $_POST['status'];
        $data = $Student->updateStudentStatus($id, $status, 'student_mst');
        echo json_encode($data);
    }

    if ($_POST['action'] === 'approveStatusUpdate') {
        $id = $_POST['itemId'];
        $data = $Student->approveStatusUpdate($id, 'students', true);
        echo json_encode($data);
    }

    if ($_POST['action'] === 'approveStatusUpdate_old') {
        $id = $_POST['itemId'];
        $data = $Student->approveStatusUpdate($id, 'student_mst', false);
        echo json_encode($data);
    }

    





   
}
