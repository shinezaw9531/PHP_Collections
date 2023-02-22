<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Excel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <?php
                if(isset($_SESSION['message'])){
                    echo "<h4>".$_SESSION['message']."</h4>";
                    unset($_SESSION['message']);
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h4>How to Import Excel Dato into database in PHP</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="import_file" class="form-control">
                            <button type="submit" name="save_excel_data" class="btn btn-primary mt-3">Import</button>
                        </form>
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-header">
                        <h4>How to Export Data from database in excel sheet using PHP</h4>
                    </div>
                    <div class="card-body">

                        <form action="code.php" method="POST">

                            <select name="export_file_type" class="form-control">
                                <option value="xlsx">XLSX</option>
                                <option value="xls">XLS</option>
                                <option value="csv">CSV</option>
                            </select>

                            <button type="submit" name="export_excel_btn" class="btn btn-primary mt-3">Export</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>