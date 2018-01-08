<?php

include 'pdoHelper.php';

require __DIR__ . '/vendor/autoload.php';

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

$csv = 'importCSV';
$xlsx = 'importXLSX';
$result = '';
$uploaddir = __DIR__ . '/uploads/';

$pdo = getMysqlPDO('databaseSettings.php');

if (isset($_FILES[$csv]) || isset($_FILES[$xlsx])) {
    if (isset($_FILES[$csv])) {
        $importFile = $_FILES[$csv];
        $fileType = Type::CSV;
    } else {
        $importFile = $_FILES[$xlsx];
        $fileType = Type::XLSX;
    }

    $uploadfile = $uploaddir . basename($importFile['name']);

    if (move_uploaded_file($importFile['tmp_name'], $uploadfile)) {
        $result = "Файл корректен и был успешно загружен.\n";
        $reader = ReaderFactory::create($fileType); // for CSV files

        $reader->open($uploadfile);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $values = array_values($row);
                // при вставке id будет вычислено автоматически
                $idValue = 0;
                $statement = $pdo->prepare(
                            "INSERT INTO InventoryNumbers(id, inventoryNumber, col2, col3) VALUES (
                            '0', :inventoryNumber, :col2, :col3
                        ) ON DUPLICATE KEY UPDATE
                            col2=:col2, col3=:col3"
                );
                if (count($values) < 3) {
                    $values = array_pad($values, 3, '');
                }
                $statement->execute(
                        array(
                            ':inventoryNumber' => $values[0],
                            ':col2' => $values[1],
                            ':col3' => $values[2]
                        )
                );
            }
        }

        $reader->close();
    } else {
        $result = "Возможная атака с помощью файловой загрузки!\n";
    }

}

$csv = 'exportCSV';
$xlsx = 'exportXLSX';

if (isset($_GET[$csv]) || isset($_GET[$xlsx])) {
    if (isset($_GET[$csv])) {
        $fileName = 'data.csv';
        $fileType = Type::CSV;
    } else {
        $fileName = 'data.xlsx';
        $fileType = Type::XLSX;
    }

    $writer = WriterFactory::create($fileType);
    $writer->openToBrowser($fileName); // stream data directly to the browser

    $statement = prepareAndExecuteSql($pdo, "SELECT * FROM InventoryNumbers");

    while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) {
        $values = array_values($row);
        $idExcluded = array_slice($values, 1);
        $writer->addRow($idExcluded); // add a row at a time
    }

    $writer->close();
    exit;
}

$statement = prepareAndExecuteSql($pdo, "SELECT * FROM InventoryNumbers");

$table = "<table>";
$table .= "<tr><td>id</td></tr>";
while (($row = $statement->fetchObject()) !== false) {
    $table .= "<tr>";

    foreach ($row as $cell) {
        $table .= "<td>$cell</td>";
    }

    $table .= "</tr>";
}
$table .= "</table>";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>Экспорт, импорт .csv, .xlsх</title>
    <style>
        form {
            width: 300px;
        }
        fieldset {
            display: inline-block;
        }
        table {
            border-collapse: collapse;
        }
        td {
            border: 1px solid black;
        }
        #result {
            height: 20px;
        }
    </style>
    <script>
        function validateCsvForm() {
            var csv = document.getElementById('importCSV');
            return validateFile(csv, 'csv');
        }

        function validateXlsxForm() {
            var xlsx = document.getElementById('importXLSX');
            return validateFile(xlsx, 'xlsx');
        }

        function validateFile(file, extension) {
            var result = document.getElementById('result');

            if (file.files.length == 0) {
                result.innerHTML = "Файл не выбран!";
                return false;
            }

            if (getFileNameExtension(file.files[0].name) !== extension) {
                result.innerHTML = "Выберите файл с расширением" + " ." + extension + "!";
                return false;
            }

            return true;
        }

        function getFileNameExtension(fileName) {
            return fileName.split('.').pop();
        }
    </script>
</head>
<body>
    <div>
        <a href="..">Портфолио</a> &bull; <a href="#">экспорт / импорт CSV, XLSX</a>
        <hr>
    </div>
    <fieldset>
        <legend>импорт</legend>
        <form enctype="multipart/form-data" method="POST" action="index.php" onsubmit="return validateCsvForm();">
            <fieldset>
                <legend>.csv</legend>
                Выберите csv-файл:
                <input type="file" accept="text/csv" name="importCSV" id="importCSV">
                <input type="submit" value="Импортировать csv-файл">
            </fieldset>
        </form>
        <br>
        <form enctype="multipart/form-data" method="POST" action="index.php" onsubmit="return validateXlsxForm();">
            <fieldset>
                <legend>.xlsx</legend>
                Выберите xlsx-файл:
                <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                       name="importXLSX" id="importXLSX">
                <input type="submit" value="Импортировать xlsx-файл">
            </fieldset>
        </form>
    </fieldset>
    <fieldset>
        <legend>экспорт</legend>
        <form action="index.php">
            <input type="submit" name="exportCSV" value="Экспортировать в .csv">
        </form>
        <br>
        <form action="index.php">
            <input type="submit" name="exportXLSX" value="Экспортировать в .xlsx">
        </form>
    </fieldset>
    <div id="result"><?=$result?></div>
    <p>Содержимое базы данных:</p>
    <div><?=$table?></div>
</body>
</html>