<?php

use App\Model\TreeCapitalization;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(TreeCapitalization::class, function (ModelConfiguration $model) {
    $model->setTitle('Capitalization')->setAlias('capitalization')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->setHtmlAttribute('class', 'table-warning');
        $display->setOrder([[1, 'desc']]);

        $display->setColumns([
            AdminColumn::link('type_capitalization')->setLabel('Title'),
            AdminColumn::text('shares')->setLabel('Shares')->setWidth('30px'),
            AdminColumn::text('debt_value')->setLabel('Debt')->setWidth('50px'),
            AdminColumn::text('cash_value')->setLabel('Cash')->setWidth('50px'),
            AdminColumn::text('exercise_price')->setLabel('Exercise Price')->setWidth('50px')
        ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $form = AdminForm::panel()
            ->addBody([
//                AdminFormElement::text('name', 'Title')->required(),
//                AdminFormElement::wysiwyg('comment', 'Comment')->required(),
//                AdminFormElement::checkbox('status', 'Status'),
            ]);

        $form->getButtons()
            ->setSaveButtonText('Save Capitalization')
            ->hideSaveAndCloseButton();

        return $form;
    });
})->addMenuPage(TreeCapitalization::class)->setIcon('fa fa-sitemap');

AdminNavigation::addPage('capitalization');