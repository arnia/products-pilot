<?php

class Application_Form_SignUp extends Zend_Form {

    public function init(){
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setAttribs(
            array(
                'class' => 'form-horizontal' ,
            )
        );

        $decoratorField = new My_Decorator_FieldLogin();

        $elements = array();

        // Add name field
        $input = new Zend_Form_Element_Text('email',array(
            'required'   => true,
            'label'      => 'Email Address:',
            'id'         => 'email',
            'placeholder'=> 'Your email..',
            'class'      => 'form-control',
            'type'       => 'email',
        ));

        $input->addValidators(array(new Zend_Validate_EmailAddress(),new Zend_Validate_NotEmpty()));
        $input->addDecorator($decoratorField);
        $elements[] = $input;

        // Add category field
        $input = new Zend_Form_Element_Password('password1',array(
            'required'   => true,
            'label'      => 'Password:',
            'id'         => 'password1',
            'class'      => 'form-control',
            'placeholder'=> 'Your password..',
        ));

        $input->addValidators(array(new Zend_Validate_Alnum(), new Zend_Validate_StringLength(array('min' => 8)), new Zend_Validate_NotEmpty()));

        $input->addDecorator($decoratorField);
        $elements[] = $input;

        // Add category field
        $input = new Zend_Form_Element_Password('password2',array(
            'required'   => true,
            'label'      => 'Password Again:',
            'id'         => 'password2',
            'class'      => 'form-control',
            'placeholder'=> 'Your password again..',
            'validators' => array(
                array('identical', false, array('token' => 'password1')))
        ));

        $input->addDecorator($decoratorField);
        $elements[] = $input;


        //Add Submit button
        $input = new Zend_Form_Element_Submit('submit',array(
            'Label'      => '',
            'class'      => 'btn btn-default',
            'value'      => 'SignUp',
        ));
        $input->addDecorator($decoratorField);
        $elements[] = $input;


        $this->addElements($elements);

        $this->addDisplayGroup(
            array('email', 'password1' , 'password2', 'submit'),
            'displgrp',
            array(
                'decorators' => array(
                    'FormElements',
                    /*// need to alias the HtmlTag decorator so you can use it twice
                    array(array('Dashed'=>'HtmlTag'), array('tag'=>'div', 'class'=>'dashed-outline')),
                    array('HtmlTag',array('tag' => 'div',  'class' => 'settings')),*/
                )
            )
        );
    }
}