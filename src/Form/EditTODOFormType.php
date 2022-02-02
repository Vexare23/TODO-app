<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\TODO;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTODOFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['is_authenticated']) {
            $builder
                ->add('name', TextType::class, array(
                    'attr' => array(
                        'placeholder' => 'TODO name')
                ))
                ->add('description', TextareaType::class, array(
                    'attr' => array(
                        'maxlength' => 255,
                        'placeholder' => 'TODO description')
                ))
                ->add('datetime', null, [
                    'widget' => 'single_text',
                    'label' => 'To be done by'
                ])
                ->add('status', ChoiceType::class, [
                    'choices' => [
                        'Done' => true,
                        'To be done' => false]
                ])
                ->add(
                    'assignedTo',
                    EntityType::class,
                    [
                    'class' => User::class,
                    'required' => false,
                    'placeholder' => 'Nobody']
                );
        } else {
            $builder
                ->add('name', TextType::class, array(
                    'attr' => array(
                        'placeholder' => 'TODO name')
                ))
                ->add('description', TextareaType::class, array(
                    'attr' => array(
                        'maxlength' => 255,
                        'placeholder' => 'TODO description')
                ))
                ->add(
                    'assignedTo',
                    EntityType::class,
                    [
                    'class' => User::class,
                    'required' => false,
                    'placeholder' => 'Nobody']
                );
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TODO::class,
            'is_authenticated' => false,
            'validation_groups' => false
        ]);

        $resolver->setRequired([
            'is_authenticated'
        ]);
    }
}
