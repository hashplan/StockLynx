<?php

use App\Model\ValuationTree;
use App\Model\RosettaTree;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(ValuationTree::class, function (ModelConfiguration $model) {
    $model->setTitle('Valuation')->setAlias('valuation')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->setHtmlAttribute('class', 'table-warning');
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
            AdminColumn::text('metric_value')->setLabel('metric value'),
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
    $model->onCreateAndEdit(function($model) {
        $result = [];
        $vt = (\Request::get('valuation-type'))?\Request::get('valuation-type'):ValuationTree::getTransactValues(ValuationTree::find(\Request::segment(3))->first()->toArray()['metric']);
        switch ($vt) {
            case 'pe': //Price to Earnings
                $result = [
                    AdminFormElement::hidden('user_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                    AdminFormElement::hidden('scenario_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                    AdminFormElement::hidden('identifier')->setDefaultValue(Auth::user()->getAttribute('id')),
                    AdminFormElement::hidden('tree_id')->setDefaultValue(\Request::get('node_id')),
                    AdminFormElement::hidden('level', 'level')->setDefaultValue(\Request::get('node_id')),
                    AdminFormElement::hidden('scenario_name')->setDefaultValue(\Request::get('node-name')),
                    AdminFormElement::hidden('scenario_comment')->setDefaultValue(\Request::get('scenario-description')),
                    AdminFormElement::date('valuation_date', 'Valuation Date')->setCurrentDate(),
                    AdminFormElement::select('valuation_method', 'Valuation Method', ValuationTree::getPossibleEnumValues('valuation_method')),
                    AdminFormElement::hidden('metric')->setDefaultValue('EPS'),
                    AdminFormElement::text('metric_value', 'EPS')->required(),
                    AdminFormElement::text('metric_comment', 'EPS Comment'),
                    AdminFormElement::date('valuation_date', 'Valuation Date')->setCurrentDate(),
//                    AdminFormElement::date('', 'Fiscal Date')->setCurrentDate(),
//                    AdminFormElement::date('', 'Calendar Date')->setCurrentDate(),
                    AdminFormElement::text('modifier', 'P|E multiple')->required(),
                    AdminFormElement::text('modifier_comment', 'P|E multiple Comment'),
                    AdminFormElement::text('diluted_shares', 'Diluted Shares')->required('to prevent ZERO val!'),
                    ];
                break;

            case 'fcfy': //Free Cash Flow Yield
                $result = [
                    AdminFormElement::hidden('user_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                    AdminFormElement::hidden('scenario_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                    AdminFormElement::hidden('identifier')->setDefaultValue(Auth::user()->getAttribute('id')),
                    AdminFormElement::hidden('tree_id')->setDefaultValue(\Request::get('node_id')),
                    AdminFormElement::hidden('level', 'level')->setDefaultValue(\Request::get('node_id')),
                    AdminFormElement::hidden('scenario_name')->setDefaultValue(\Request::get('node-name')),
                    AdminFormElement::hidden('scenario_comment')->setDefaultValue(\Request::get('scenario-description')),
                    AdminFormElement::date('valuation_date', 'Valuation Date')->setCurrentDate(),
                    AdminFormElement::select('valuation_method', 'Valuation Method', ValuationTree::getPossibleEnumValues('valuation_method')),
                    AdminFormElement::hidden('metric')->setDefaultValue('Levered FCF'),
                    AdminFormElement::text('metric_value', 'Levered FCF')->required(),
                    AdminFormElement::text('metric_comment', 'Levered FCF Comment'),
                    AdminFormElement::date('valuation_date', 'Valuation Date')->setCurrentDate(),
//                    AdminFormElement::date('', 'Fiscal Date')->setCurrentDate(),
//                    AdminFormElement::date('', 'Calendar Date')->setCurrentDate(),
                    AdminFormElement::text('modifier', 'Yield')->required(),
                    AdminFormElement::text('modifier_comment', 'Yield Comment'),
                    AdminFormElement::text('cash', 'Cash'),
                    AdminFormElement::text('debt', 'Debt'),
                    AdminFormElement::text('diluted_shares', 'Diluted Shares')->required('to prevent division by ZERO!'),
                ];
                break;

            case 'evebitda': //EV to EBITDA
                $result = [
                    AdminFormElement::hidden('user_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                    AdminFormElement::hidden('scenario_id')->setDefaultValue(Auth::user()->getAttribute('id')),
                    AdminFormElement::hidden('identifier')->setDefaultValue(Auth::user()->getAttribute('id')),
                    AdminFormElement::hidden('tree_id')->setDefaultValue(\Request::get('node_id')),
                    AdminFormElement::hidden('level', 'level')->setDefaultValue(\Request::get('node_id')),
                    AdminFormElement::hidden('scenario_name')->setDefaultValue(\Request::get('node-name')),
                    AdminFormElement::hidden('scenario_comment')->setDefaultValue(\Request::get('scenario-description')),
                    AdminFormElement::date('valuation_date', 'Valuation Date')->setCurrentDate(),
                    AdminFormElement::select('valuation_method', 'Valuation Method', ValuationTree::getPossibleEnumValues('valuation_method')),
                    AdminFormElement::hidden('metric')->setDefaultValue('EBITDA'),
                    AdminFormElement::text('metric_value', 'EBITDA')->required(),
                    AdminFormElement::text('metric_comment', 'EBITDA Comment'),
                    AdminFormElement::date('valuation_date', 'Valuation Date')->setCurrentDate(),
//                    AdminFormElement::date('', 'Fiscal Date')->setCurrentDate(),
//                    AdminFormElement::date('', 'Calendar Date')->setCurrentDate(),
                    AdminFormElement::text('modifier', 'EBITDA multiple')->required(),
                    AdminFormElement::text('modifier_comment', 'EBITDA multiple Comment'),
                    AdminFormElement::text('cash', 'Cash'),
                    AdminFormElement::text('debt', 'Debt'),
                    AdminFormElement::text('diluted_shares', 'Diluted Shares')->required('to prevent division by ZERO!'),
                ];
                break;

            case 'dy': //Dividend Yield
                break;

            case 'evsales': //EV to Sales
                break;

            case 'sumparts': //Sum of the Parts
                break;

            case 'other': //Other
                break;

            default:
                echo 'npm go!';
        }

        $form = AdminForm::panel()
            ->addBody($result);

        $form->getButtons()
            ->setSaveButtonText('Save Valuation')
            ->hideSaveAndCloseButton();

        return $form;
    });

});
