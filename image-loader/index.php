<?php

include 'pdoHelper.php';
include 'helper.php';

require __DIR__ . '/vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

$pdo = getMysqlPDO('databaseSettings.php');
$result = '';

if (isset($_FILES['image'])) {
    $submittedImage = $_FILES['image'];

    if (is_uploaded_file($submittedImage['tmp_name'])) {
        $imageExtension = '.' . getFileExtension($submittedImage['name']);
        $tmpCopyWithExtensionName = $submittedImage['tmp_name'] . $imageExtension;

        copy($submittedImage['tmp_name'], $tmpCopyWithExtensionName);

        $saveDir = __DIR__ . '/images/';
        $uniqid = uniqid("img_");
        try {
            saveMediumImage($tmpCopyWithExtensionName, $uniqid, $saveDir, $pdo);
            saveSmallImage($tmpCopyWithExtensionName, $uniqid, $saveDir, $pdo);
            $result = "Изображение корректено и было успешно загружено.\n";
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
            $result = "Файл не является изображением!";
        }
    } else {
        $result = "Возможная атака с помощью файловой загрузки!\n";
    }
}

$imagePathsTable = prepareAndExecuteSql($pdo, "SELECT * FROM images");
while (($imagePathRow = $imagePathsTable->fetchObject()) !== false) {
    $imagePaths[] = getAbsoluteUrl('images/') . $imagePathRow->imagePath;
}

function saveMediumImage($tmpCopyWithExtensionName, $uniqid, $saveDir, $pdo)
{
    $mediumImage = Image::make($tmpCopyWithExtensionName);
    $mediumImage->resize(500, 300, function ($constraint) {
        $constraint->aspectRatio();
    });
    $imageExtension = getFileExtension($tmpCopyWithExtensionName);
    $saveMediumImageName = $uniqid . "_medium" . $imageExtension;
    $watermark = Image::make('Github-icon.png')->resize(50, 50)->opacity(30);
    $mediumImage->insert($watermark, 'bottom-right');
    $mediumImage->save($saveDir . $saveMediumImageName);

    $statement = $pdo->prepare("INSERT INTO images(imagePath) VALUE (:saveMediumImageName)");
    $statement->execute(array(':saveMediumImageName' => $saveMediumImageName));
}

function saveSmallImage($tmpCopyWithExtensionName, $uniqid, $saveDir, $pdo)
{
    $smallImage = Image::make($tmpCopyWithExtensionName);
    $smallImage->fit(150, 150);
    $imageExtension = getFileExtension($tmpCopyWithExtensionName);
    $saveSmallImageName = $uniqid . "_small" . $imageExtension;
    $smallImage->save($saveDir . $saveSmallImageName);

    $statement = $pdo->prepare("INSERT INTO images(imagePath) VALUE (:saveSmallImageName)");
    $statement->execute(array(':saveSmallImageName' => $saveSmallImageName));
}

function getFileExtension($filePath)
{
    return pathinfo($filePath, PATHINFO_EXTENSION);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>Загрузка фото</title>
    <style>
        form {
            width: 300px;
        }
        input[type='file'] {
            margin-bottom: 5px;
        }
        div#result {
            margin-top: 5px;
            height: 15px;
        }
    </style>
    <script>
        function validateForm() {
            var image = document.getElementById('image');
            var result = document.getElementById('result');
            var maxImageSizeInMb = 5;

            if (image.files.length == 0) {
                result.innerHTML = "Файл с изображением не выбран!";
                return false;
            }

            if (!(/\.(jpe?g|png)$/i).test(image.files[0].name)) {
                result.innerHTML = "Выберите файл с расширением .jpeg, .jpg или .png!";
                return false;
            }

            if (getFileSizeInMb(image.files[0]) > maxImageSizeInMb) {
                result.innerHTML = "Размер файла с изображением превышает " + maxImageSizeInMb + " MB!";
                return false;
            }

            return true;
        }

        function getFileSizeInMb(file) {
            return file.size / 1024 / 1024;
        }

        function getFileNameExtension(fileName) {
            return fileName.split('.').pop();
        }
    </script>
</head>
<body>
    <div>
        <a href="..">Портфолио</a> &bull; <a href="#">Загрузка фото</a>
        <hr>
    </div>
    <form method="POST" enctype="multipart/form-data" action="index.php" onsubmit="return validateForm();">
        <fieldset>
            Изображение для загрузки<br>
            Ограничения:<br>
            формат jpeg, jpg или png<br>
            максимальный размер 5 MB
            <input type="file" id="image" accept="image/png,image/jpeg" name="image">
            <input type="submit" value="Загрузить изображение">
        </fieldset>
    </form>
    <div id="result"><?=$result?></div>
    <p>Загруженные изображения:<p>
    <?php if (isset($imagePaths)): ?>
        <?php foreach ($imagePaths as $imagePath): ?>
            <img src="<?=$imagePath?>">
        <?php endforeach; ?>
    <?php else: ?>
        Загруженных изображений нет
    <?php endif; ?>
</body>
</html>