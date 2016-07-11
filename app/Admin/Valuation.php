<?php

use App\Model\ValuationTree;
use App\Model\RosettaTree;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(ValuationTree::class, function (ModelConfiguration $model) {
    $model->setTitle('Valuation')->setAlias('valuation')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->with('trees')->setHtmlAttribute('class', 'table-warning');
        $display->setOrder([[1, 'desc']]);

        $display->setColumns([
//            AdminColumn::text('identifier')->setLabel('identifier'),
            AdminColumn::text('class')->setLabel('class'),
            AdminColumn::text('framework')->setLabel('framework'),
//            AdminColumn::text('level')->setLabel('level'),
            AdminColumn::text('scenario_name')->setLabel('scenario name'),
//            AdminColumn::text('scenario_comment')->setLabel('scenario_comment'),
            AdminColumn::text('valuation_method')->setLabel('valuation method'),
            AdminColumn::datetime('valuation_date')->setLabel('valuation date'),
            AdminColumn::text('metric')->setLabel('metric'),
//            AdminColumn::text('metric_comment')->setLabel('metric_comment'),
            AdminColumn::text('modifier')->setLabel('modifier'),
//            AdminColumn::text('modifier_comment')->setLabel('modifier_comment'),
            AdminColumn::text('cash')->setLabel('cash'),
//            AdminColumn::text('cash_comment')->setLabel('cash_comment'),
            AdminColumn::text('debt')->setLabel('debt'),
//            AdminColumn::text('debt_comment')->setLabel('debt_comment'),
            AdminColumn::text('ev')->setLabel('ev'),
            AdminColumn::text('mkt_cap')->setLabel('mkt cap'),
            AdminColumn::text('diluted_shares')->setLabel('diluted shares'),
            AdminColumn::text('discount_rate')->setLabel('discount rate'),
//            AdminColumn::text('discount_rate_comment')->setLabel('discount_rate_comment'),
            AdminColumn::text('discount_days')->setLabel('Discount Days'),
            AdminColumn::text('value_per_share_raw')->setLabel('vpsr'), //value per share raw
            AdminColumn::text('value_per_share_current')->setLabel('vpsc'),//value per share current
//            AdminColumn::text('valuation_comment')->setLabel('valuation_comment'),
        ]);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::hidden('user_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                AdminFormElement::hidden('scenario_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                AdminFormElement::hidden('identifier')->setDefaultValue(Auth::user()->getAttribute('id')),
                AdminFormElement::hidden('tree_id')->setDefaultValue(\Request::get('node_id')),
                //AdminFormElement::select('tree_id', 'Select Node', RosettaTree::own()->lists('name', 'id')->all())->required(),
                AdminFormElement::select('class', 'Class', ValuationTree::getPossibleEnumValues('class')),//['Equity','Credit','Option']
                AdminFormElement::select('framework', 'Framework', ValuationTree::getPossibleEnumValues('framework')),//['Fundamental','Merger Arbitrage','Volatility Arbitrage','Distressed','Catalyst']
//                AdminFormElement::text('level', 'level'),//level of the node
                AdminFormElement::text('scenario_name', 'Scenario Name')->required(),
                AdminFormElement::wysiwyg('scenario_comment', 'Scenario Comment')->required(),
                AdminFormElement::select('valuation_method', 'Valuation Method', ValuationTree::getPossibleEnumValues('valuation_method')),//['custom', 'multiple', 'yield']
                AdminFormElement::date('valuation_date', 'Valuation Date')->setCurrentDate(),
                AdminFormElement::select('metric', 'Metric', ValuationTree::getPossibleEnumValues('metric')),//['null', 'Net Income', 'EPS', 'EBITDA', 'Revenue', 'Levered FCF', 'Levered FCF per Share', 'Unlevered FCF', 'Dividend per Share']
                AdminFormElement::wysiwyg('metric_comment', 'Metric Comment'),
                AdminFormElement::select('modifier', 'Modifier', ValuationTree::getPossibleEnumValues('modifier')),//['null', 'multiple', 'yield']
                AdminFormElement::wysiwyg('modifier_comment', 'Modifier Comment'),
                AdminFormElement::text('cash', 'Cash'),//Pull from XML , [Allow user override]
                AdminFormElement::wysiwyg('cash_comment', 'Cash Comment'),
                AdminFormElement::select('debt', 'Debt', ValuationTree::getPossibleEnumValues('debt')),//Pull from XML ['Current Portion', 'Long-term Portion', 'Minority Interest'] , [Allow user override]
                AdminFormElement::wysiwyg('debt_comment', 'Debt Comment'),
//                AdminFormElement::text('ev', 'EV'),//COMPUTED
//                AdminFormElement::text('mkt_cap', 'MKT cap'),//COMPUTED
//                AdminFormElement::text('diluted_shares', 'Diluted Shares'),//COMPUTED field 'Shares' from TreeCapitalization table, Based on value/share [Allow user override]
                AdminFormElement::text('discount_rate', 'Discount Rate'),//Suggest 10%, Pop up suggestion, that this is for Equity - time value
                AdminFormElement::wysiwyg('discount_rate_comment', 'Discount Rate Comment'),
//                AdminFormElement::text('discount_days', 'Discount Days'),//COMPUTED
//                AdminFormElement::text('value_per_share_raw', 'value per share raw'),//COMPUTED
//                AdminFormElement::text('value_per_share_current', 'value_per_share_current'),//COMPUTED
                AdminFormElement::wysiwyg('valuation_comment', 'Valuation Comment'),
                /***/
//                AdminFormElement::text('name', 'Title')->required(),
//                AdminFormElement::wysiwyg('comment', 'Comment')->required(),
//                AdminFormElement::checkbox('status', 'Status'),
            ]);

        $form->getButtons()
            ->setSaveButtonText('Save Tree')
            ->hideSaveAndCloseButton();

        return $form;
    });
});
