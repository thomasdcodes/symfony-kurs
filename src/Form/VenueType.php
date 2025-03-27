<?php

namespace App\Form;

use App\Entity\Venue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name des Veranstaltungsortes',
                'required' => false,
            ])
            ->add('numOfAdvancedGuards', NumberType::class, [
                'label' => 'Anzahl der Wachhabenden',
                'help' => 'Minimale Anzahl der Wachhabenden für diesen Ort',
            ])
            ->add('numOfGuards', NumberType::class, [
                'label' => 'Anzahl der Posten',
                'help' => 'Minimale Anzahl der Posten für diesen Ort',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Speichern',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Venue::class,
        ]);
    }
}