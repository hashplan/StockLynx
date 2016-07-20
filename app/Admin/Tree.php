<?php

use App\Model\RosettaTree;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(RosettaTree::class, function (ModelConfiguration $model) {
    $model->setTitle('Tree')->setAlias('trees')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        $display = AdminDisplay::tree()->setValue('name');

        $display->getScopes()->push('stock');
        $display->getScopes()->push('own');

        return $display;
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $parent = (\Request::has('node_id'))?\Request::get('node_id'):null;
        $form = AdminForm::panel()
            ->addBody([
                //AdminFormElement::select('parent_id', 'Select Parent Node', RosettaTree::own()->lists('name', 'id')->all()),
                AdminFormElement::hidden('stock_id')->setDefaultValue(\Request::get('stock_id')),
                ($parent)?AdminFormElement::hidden('parent_id')->setDefaultValue($parent):'',//RosettaTree::own()->lists('name', 'id')->all()
                AdminFormElement::text('name', 'Title')->required()->addValidationRule('max:255'),//->addValidationRule('regex:/^[\pL\s]+$/u')
                AdminFormElement::wysiwyg('comment', 'Comment')->required()->addValidationRule('max:255'),
                AdminFormElement::select('status', 'Status', RosettaTree::getPossibleEnumValues('status')),
            ]);

        $form->getButtons()
            ->setSaveButtonText('Save Tree')
            ->hideSaveAndCloseButton();

        return $form;
    });

});