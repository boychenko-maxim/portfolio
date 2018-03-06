<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 05.03.18
 * Time: 23:25
 */

class SimpleLibraryForm extends CFormModel
{
    public $authorsNumber;

    public function rules()
    {
        return array(
            array('authorsNumber', 'required', 'message'=>'Поле "Минимальное количество авторов" не может быть пустым'),
            array('authorsNumber', 'numerical', 'integerOnly' => true, 'min' => 1,
                'message'=>'Количество авторов содержит нецифровые символы',
                'tooSmall'=>'Количество авторов не может быть меньше единицы')
        );
    }
}