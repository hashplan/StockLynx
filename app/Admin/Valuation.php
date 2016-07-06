<?php

use App\Model\ValuationTree;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(ValuationTree::class, function (ModelConfiguration $model) {
    $model->setTitle('Valuation')->setAlias('valuation')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->setHtmlAttribute('class', 'table-warning');
        $display->setOrder([[1, 'desc']]);

        $display->setColumns([
//            AdminColumn::text('user_id')->setLabel('user_id'),
//            AdminColumn::text('tree_id')->setLabel('tree_id'),
//            AdminColumn::text('scenario_id')->setLabel('scenario_id'),
//            AdminColumn::text('identifier')->setLabel('identifier'),
            AdminColumn::text('class')->setLabel('class'),
            AdminColumn::text('framework')->setLabel('framework'),
            AdminColumn::text('level')->setLabel('level'),
            AdminColumn::text('scenario_name')->setLabel('scenario_name'),
            AdminColumn::text('scenario_comment')->setLabel('scenario_comment'),
            AdminColumn::text('valuation_method')->setLabel('valuation_method'),
            AdminColumn::datetime('valuation_date')->setLabel('valuation_date'),
            AdminColumn::text('metric')->setLabel('metric'),
            AdminColumn::text('metric_comment')->setLabel('metric_comment'),
            AdminColumn::text('modifier')->setLabel('modifier'),
            AdminColumn::text('modifier_comment')->setLabel('modifier_comment'),
            AdminColumn::text('cash')->setLabel('cash'),
            AdminColumn::text('cash_comment')->setLabel('cash_comment'),
            AdminColumn::text('debt')->setLabel('debt'),
            AdminColumn::text('debt_comment')->setLabel('debt_comment'),
            AdminColumn::text('ev')->setLabel('ev'),
            AdminColumn::text('mkt_cap')->setLabel('mkt_cap'),
            AdminColumn::text('diluted_shares')->setLabel('diluted_shares'),
            AdminColumn::text('discount_rate')->setLabel('discount_rate'),
            AdminColumn::text('discount_rate_comment')->setLabel('discount_rate_comment'),
            AdminColumn::text('discount_days')->setLabel('discount_days'),
            AdminColumn::text('value_per_share_raw')->setLabel('value_per_share_raw'),
            AdminColumn::text('value_per_share_current')->setLabel('value_per_share_current'),
            AdminColumn::text('valuation_comment')->setLabel('valuation_comment'),
        ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::hidden('user_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                AdminFormElement::hidden('tree_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                AdminFormElement::hidden('scenario_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                AdminFormElement::hidden('identifier')->setDefaultValue(Auth::user()->getAttribute('id')),
                AdminFormElement::text('name', 'Title')->required(),
                AdminFormElement::wysiwyg('comment', 'Comment')->required(),
                AdminFormElement::checkbox('status', 'Status'),
            ]);

        $form->getButtons()
            ->setSaveButtonText('Save Tree')
            ->hideSaveAndCloseButton();

        return $form;
    });
})->addMenuPage(ValuationTree::class)->setIcon('fa fa-sitemap');
