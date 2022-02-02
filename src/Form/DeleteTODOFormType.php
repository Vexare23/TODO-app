<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\TODO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeleteTODOFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['is_authenticated']) {
            $builder
                ->add('name', TextType::class, array(
                    'attr' => array(
                        'readonly' => true,
                    )
                ))
                ->add('status', ChoiceType::class, [
                    'attr' => array(
                        'readonly' => true,
                    ),
                    'choices' => [
                        'TODO marked as done!!!' => true, ///only admin can see this
                    ]
                ]);
        } else {
            $builder
                ->add('name', TextType::class, array(
                    'attr' => array(
                        'readonly' => true,
                    )
                ));
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TODO::class,
            'is_authenticated' => false,
            'validation_groups' => false,
        ]);

        $resolver->setRequired([
            'is_authenticated',
        ]);
    }
}
