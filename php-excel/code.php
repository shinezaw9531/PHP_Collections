<?php
session_start();
$con = mysqli_connect('localhost','root','','php_collections');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

if(isset($_POST['export_excel_btn']))
{
    $file_ext_name = $_POST['export_file_type'];
    $fileName = "student-sheet";

    $student = "SELECT * FROM students";
    $query_run = mysqli_query($con, $student);
    
    print_r($query_run);
    die();

    if(mysqli_num_rows($query_run) > 0)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Full Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Phone');
        $sheet->setCellValue('E1', 'Course');

        $rowCount = 2;
        foreach($query_run as $data)
        {
            $sheet->setCellValue('A'.$rowCount, $data['id']);
            $sheet->setCellValue('B'.$rowCount, $data['fullname']);
            $sheet->setCellValue('C'.$rowCount, $data['email']);
            $sheet->setCellValue('D'.$rowCount, $data['phone']);
            $sheet->setCellValue('E'.$rowCount, $data['course']);
            $rowCount++;
        }

        if($file_ext_name == 'xlsx')
        {
            $writer = new Xlsx($spreadsheet);
            $final_filename = $fileName.'.xlsx';
        }
        elseif($file_ext_name == 'xls')
        {
            $writer = new Xls($spreadsheet);
            $final_filename = $fileName.'.xls';
        }
        elseif($file_ext_name == 'csv')
        {
            $writer = new Csv($spreadsheet);
            $final_filename = $fileName.'.csv';
        }

        // $writer->save($final_filename);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8; encoding=utf-8');
        header('Content-Disposition: attactment; filename="'.urlencode($final_filename).'"');
        $writer->save('php://output');

    }
    else
    {
        $_SESSION['message'] = "No Record Found";
        header('Location: index.php');
        exit(0);
    }
}



if(isset($_POST['save_excel_data'])){
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext)){
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach($data as $row){
            if($count > 0){
                $fullname = $row['0'];
                $email = $row['1'];
                $phone = $row['2'];
                $course = $row['3'];

                $studentQuery = "INSERT INTO students (fullname,email,phone,course) VALUES ('$fullname','$email','$phone','$course')";
                $result = mysqli_query($con, $studentQuery);
                $msg = true;
            }else{
                $count = "1";
            }

        }
        if(isset($msg)){
            $_SESSION['message']="Successfully Imported";
            header("Location: index.php");
            exit(0);
        }else{
            $_SESSION['message']="Not Imported";
            header("Location: index.php");
            exit(0);
        }
    }else{
        $_SESSION['message'] = "Invalid File";
        header("Location: index.php");
        exit(0);
    }
    
}

?>