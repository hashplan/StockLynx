<?php

use App\Model\News;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(News::class, function (ModelConfiguration $model) {
    $model->setTitle('Stock News')->setAlias('news')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->setHtmlAttribute('class', 'table-warning');
        $display->setOrder([[1, 'desc']]);

        $display->setColumns([
            AdminColumn::link('title')->setLabel('Title'),
            AdminColumn::datetime('date')->setLabel('Date')->setFormat('d.m.Y')->setWidth('150px'),
            AdminColumnEditable::checkbox('published')->setLabel('Published')->setWidth('50px')->setHtmlAttribute('class', 'text-center')->setOrderable(false)
        ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::text('title', 'Title')->required(),
                AdminFormElement::date('date', 'Date')->required()->setFormat('d.m.Y'),
                AdminFormElement::checkbox('published', 'Published'),
            ])->addBody([
                AdminFormElement::wysiwyg('text', 'Text'),
            ]);

        $form->getButtons()
            ->setSaveButtonText('Save news')
            ->hideSaveAndCloseButton();

        return $form;
    });
})->addMenuPage(News::class)->setIcon('fa fa-sitemap');
