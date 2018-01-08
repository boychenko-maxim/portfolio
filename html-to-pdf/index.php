<?php
    require 'vendor/autoload.php';

    include 'helper.php';

    // reference the Dompdf namespace
    use Dompdf\Dompdf;
    use Dompdf\Options;

    if (isset($_GET['invoice']) || isset($_GET['completionCertificate'])) {
        // instantiate and use the dompdf class
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        if (isset($_GET['invoice'])) {
            $dompdf->loadHtmlFile(getAbsoluteUrl('счет.html'));
        } else {
            $dompdf->loadHtmlFile(getAbsoluteUrl('акт-выполненных-работ.html'));
        }

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>HTMl => PDF</title>
    <style>
        input {
            width: 200px;
            white-space: normal;
        }
        form {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div>
        <a href="..">Портфолио</a> &bull; <a href="#">HTMl => PDF</a>
        <hr>
    </div>
    <form action="index.php">
        <input type="submit" name="invoice" value="Создать счет в формате pdf c подписью и печатью">
    </form>
    <form action="index.php">
        <input type="submit" name="completionCertificate"
               value="Создать акт выполненных работ в формате pdf c подписью и печатью">
    </form>
</body>
</html>
