<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add(
                'name',
                TextType::class
                // [
                //     'constraints' => [
                //         new NotBlank(['message' => 'Please enter your full name.']),
                //         new Length(
                //             [
                //                 'min'        => 2,
                //                 'max'        => 50,
                //                 'minMessage' => 'Your first name must be at least {{ limit }} characters long.',
                //                 'maxMessage' => 'Your first name must be longer than {{ limit }} characters long.'
                //             ]    
                //         )
                //     ],
                //     'label'    => 'Full Name',
                //     'required' => true,
                //     'attr'     => [
                //         'placeholder' => 'Enter your full name...'    
                //     ]
                // ]
            )
            ->add(
                'phone',
                TextType::class
                // [
                //     'constraints' => [
                //         new NotBlank(['message' => 'Please enter your phone number.']),
                //         new Length(
                //             [
                //                 'min'        => 2,
                //                 'max'        => 20,
                //                 'minMessage' => 'Your phone number must be at least {{ limit }} characters long.',
                //                 'maxMessage' => 'Your phone number must be longer than {{ limit }} characters long.'
                //             ]    
                //         )
                //     ],
                //     'label'    => 'Phone Number',
                //     'required' => true,
                //     'attr'     => [
                //         'placeholder' => 'Enter your phone number...'    
                //     ]
                // ]
            )
            ->add(
                'email',
                EmailType::class
                // [
                //     'constraints' => [
                //         new NotBlank(['message' => 'Please enter your email address.']),
                //         new Length(
                //             [
                //                 'min'        => 2,
                //                 'max'        => 50,
                //                 'minMessage' => 'Your email address must be at least {{ limit }} characters long.',
                //                 'maxMessage' => 'Your email address must be longer than {{ limit }} characters long.'
                //             ]    
                //         )
                //     ],
                //     'label'    => 'Full Name',
                //     'required' => true,
                //     'attr'     => [
                //         'placeholder' => 'Enter your email address...'    
                //     ]
                // ]
            )
            ->add('save', SubmitType::class);
    }
}