<?php

use App\Model\Stocks;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Stocks::class, function (ModelConfiguration $model) {
    $model->setTitle('Stocks')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::datatables()->with('tree')->setColumns([
            AdminColumn::link('securityName')->setLabel('Title')->setWidth('300px'),
            AdminColumn::text('securityType')->setLabel('Type')->setHtmlAttribute('class', 'text-muted'),
            AdminColumn::text('securityID')->setLabel('ID')->setHtmlAttribute('class', 'text-muted'),
            AdminColumn::text('ISIN')->setLabel('ISIN')->setHtmlAttribute('class', 'text-muted'),
            AdminColumn::text('CUSIP')->setLabel('CUSIP')->setHtmlAttribute('class', 'text-muted'),
            AdminColumn::text('symbol')->setLabel('symbol')->setHtmlAttribute('class', 'text-muted'),
            AdminColumn::text('exchange')->setLabel('exchange')->setHtmlAttribute('class', 'text-muted'),
            AdminColumn::text('issuerID')->setLabel('ID')->setHtmlAttribute('class', 'text-muted'),
            AdminColumn::link('issuerName')->setLabel('Name')->setHtmlAttribute('class', 'text-muted'),
            AdminColumn::datetime('updated_at')->setLabel('updated')->setFormat('Y-m-d h:i:s')->setWidth('50px')
        ])->setHtmlAttribute('class', 'table-warning');

        $display->paginate(15);

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return $form = AdminForm::panel()->addBody(
            AdminFormElement::text('securityName',  'Title')->required()->unique(),
            AdminFormElement::text('securityType',  'Type')->required(),
            AdminFormElement::text('securityID',    'ID')->required()->unique(),
            AdminFormElement::text('ISIN',          'ISIN'),
            AdminFormElement::text('CUSIP',         'CUSIP'),
            AdminFormElement::text('symbol',        'symbol')->required(),
            AdminFormElement::text('exchange',      'exchange')->required(),
            AdminFormElement::text('issuerID',      'ID')->required()->unique(),
            AdminFormElement::text('issuerName',    'Name')->required()->unique()
        );

        return $form;
    });
})
    ->addMenuPage(Stocks::class, 0)
    ->setIcon('fa fa-bank');