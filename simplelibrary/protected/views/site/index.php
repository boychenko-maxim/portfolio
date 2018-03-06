<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'method'=>'get',
        'action' => $this->createUrl('/')
    )); ?>

    <?php echo $form->errorSummary($model, 'Исправьте, пожалуйста, следующие ошибки:'); ?>

    <div class="row">
        <?php echo $form->label($model,'Минимальное количество авторов'); ?>
        <?php echo $form->textField($model,'authorsNumber') ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Отобразить книги'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php foreach ($books as $book):?>
    <?=$book['name']?><br>
<?php endforeach;?>

</body>
</html>