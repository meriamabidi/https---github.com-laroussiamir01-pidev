<?php

namespace App\Form;

use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Cardiologie' => 'cardiologie',
                    'Neurologie' => 'neurologie',
                    'Hepatologie' => 'hepatologie',
                    'Pediatrie' => 'pediatrie',
                    'Urgence' => 'Urgence',
                ],
                'required' => true,
                'placeholder' => 'Choose a status',
            ])
            ->add('description')
            ->add('chef_service', ChoiceType::class, [
                'choices' => [
                    'Doctor1' => 'doctor1',
                    'Doctor2' => 'doctor2',
                ],
                'required' => true,
                'placeholder' => 'Choose a status',
            ])
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
