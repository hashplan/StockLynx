<?php

use App\Role;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Role::class, function (ModelConfiguration $model) {
    $model->setTitle('Roles')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::datatables()->with('users')
            ->setHtmlAttribute('class', 'table-primary table-warning')
            ->setColumns([
                AdminColumn::text('id')->setLabel('#')->setWidth('30px'),
                AdminColumn::link('label')->setLabel('Label')->setWidth('100px'),
                AdminColumn::text('name')->setLabel('Name')
            ])->paginate(20);
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Key')->required(),
            AdminFormElement::text('label', 'Label')->required()
        ]);
    });
});
