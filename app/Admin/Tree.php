<?php

use App\Model\RosettaTree;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(RosettaTree::class, function (ModelConfiguration $model) {
    $model->setTitle('Tree')->setAlias('trees')->enableAccessCheck();

    // Display
    $model->onDisplay(function () {
        return AdminDisplay::tree()->with('trees')->setValue('name');//->setValue('value')
    });

    // Create And Edit
    $model->onCreateAndEdit(function() {
        $form = AdminForm::panel()
            ->addBody([
                AdminFormElement::select('parent_id', 'Select Parent Node', RosettaTree::own()->lists('name', 'id')->all()),
                AdminFormElement::text('name', 'Title')->required()->addValidationRule('alpha_num')->addValidationRule('max:255'),
                AdminFormElement::wysiwyg('comment', 'Comment')->required()->addValidationRule('max:255'),
                AdminFormElement::select('status', 'Status', RosettaTree::getPossibleEnumValues('status')),
            ]);

        $form->getButtons()
            ->setSaveButtonText('Save Tree')
            ->hideSaveAndCloseButton();

        return $form;
    });

});