<?php

class SiteController extends CController
{
	public function actionIndex()
	{
        $model = new SimpleLibraryForm;
        $books = array();
        if(isset($_GET['SimpleLibraryForm']))
        {
            // получаем данные от пользователя
            $model->attributes=$_GET['SimpleLibraryForm'];
            // проверяем полученные данные
            if ($model->validate())
            {
                $books = Yii::app()->db->createCommand()
                    ->select('books.name')
                    ->from('books')
                    ->join('booksauthors', 'books.id = booksauthors.booksid')
                    ->group('books.name')
                    ->having("count(books.name) >= {$model['authorsNumber']}")
                    ->query()
                    ->readAll();
            }
        }
        // рендерим представление
        $this->render('index',array('model'=>$model, 'books'=>$books));
	}
}