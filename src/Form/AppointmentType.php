<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\User;
use App\Entity\Venue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('startDateTime', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('venue', EntityType::class, [
                'class' => Venue::class,
                'choice_label' => 'name',
                'label' => 'Veranstaltungsort',
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'preName',
                'expanded' => true,
                'multiple' => true,
                'label' => 'form.user.label',
                'help' => 'form.user.help',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
            'translation_domain' => 'appointment',
        ]);
    }
}
