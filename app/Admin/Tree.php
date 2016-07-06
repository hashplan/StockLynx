<?php

use App\Model\RosettaTrees;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(RosettaTrees::class, function (ModelConfiguration $model) {
    $model->setTitle('Tree')->setAlias('tree')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->setHtmlAttribute('class', 'table-warning');
        $display->setOrder([[1, 'desc']]);

        $display->setColumns([
            AdminColumn::link('name')->setLabel('Title'),
            AdminColumn::text('comment')->setLabel('Comment')->setWidth('150px'),
            AdminColumn::select('status')->setLabel('Status')->setWidth('50px')->setHtmlAttribute('class', 'text-center')->setOrderable(false)
        ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::text('name', 'Title')->required(),
                AdminFormElement::wysiwyg('comment', 'Comment')->required(),
                AdminFormElement::checkbox('status', 'Status'),
            ]);

        $form->getButtons()
            ->setSaveButtonText('Save Tree')
            ->hideSaveAndCloseButton();

        return $form;
    });

})->addMenuPage(RosettaTrees::class)->setIcon('fa fa-sitemap');

AdminNavigation::addPage('tree');

//SleepingOwl\Admin
//$items = AdminNavigation::instance()->getMenu();