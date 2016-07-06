<?php

use App\Model\TreeCapitalization;
use App\Model\RosettaTree;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(TreeCapitalization::class, function (ModelConfiguration $model) {
    $model->setTitle('Capitalization')->setAlias('capitalization')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->with('trees')->setHtmlAttribute('class', 'table-warning');
        $display->setOrder([[1, 'desc']]);

        $display->setColumns([
            AdminColumn::link('name')->setLabel('Tree Name')->setWidth('250px'),
            AdminColumn::text('type_capitalization')->setLabel('Type')->setWidth('250px'),
            AdminColumn::text('shares')->setLabel('Shares')->setWidth('30px'),
            AdminColumn::text('debt_value')->setLabel('Debt')->setWidth('30px'),
            AdminColumn::text('cash_value')->setLabel('Cash')->setWidth('30px'),
            AdminColumn::text('exercise_price')->setLabel('Exercise Price')->setWidth('30px')
        ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::select('id', 'Title', RosettaTree::lists('name', 'id')->all())->required(),
                AdminFormElement::select('type_capitalization', 'Type', TreeCapitalization::getPossibleEnumValues('type_capitalization'))->required(),
                AdminFormElement::text('shares', 'Shares')->required(),
                AdminFormElement::text('debt_value', 'Debt')->required(),
                AdminFormElement::text('cash_value', 'Cash')->required(),
                AdminFormElement::text('exercise_price', 'Exercise Price')->required(),
            ]);

        $form->getButtons()
            ->setSaveButtonText('Save Capitalization')
            ->hideSaveAndCloseButton();

        return $form;
    });
})
    ->addMenuPage(TreeCapitalization::class)
    ->setIcon('fa fa-money');

//AdminNavigation::addPage('capitalization');