<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * App\Form\ListSortType
 */
class ListSortType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'sort',
                ChoiceType::class,
                [
                    'empty_data' => '',
                    'choices'    => [
                        '- Sort -'  => '',
                        'Created'   => 'createdAt.date',
                        'Email'     => 'email',
                        'Name'      => 'name',
                    ],
                ]
            )
            ->setMethod('GET');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['csrf_protection' => false]);
    }
}
