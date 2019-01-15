<?php

namespace App\Form;

use App\Entity\Event;
use App\Form\DataTransformer\EventStaffTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    private $eventStaffTransformer;

    public function __construct(EventStaffTransformer $eventStaffTransformer)
    {
        $this->eventStaffTransformer = $eventStaffTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('type', EntityType::class, [
                'class' => Event\Type::class,
                'choice_label' => 'title',
            ])
            ->add('priorKnowledge', ChoiceType::class, [
                'choices' => [
                    'Nein' => '0',
                    'Ya' => '1',
                ],
            ])
            ->add('coach', ChoiceType::class, [
                'choices' => [
                    'Nein' => '0',
                    'Ya' => '1',
                ],
            ])
            ->add('education', ChoiceType::class, [
                'choices' => [
                    'Nein' => '0',
                    'Ya' => '1',
                ],
            ])
            ->add('startDate', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy',
            ])
            ->add('endDate', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'format' => 'MM/dd/yyyy',
            ])
            ->add('trainers',CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('staffMembers',CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('location', LocationType::class)
            ->add('priceType', ChoiceType::class, [
                'choices' => [
                    'Preis fix' => 'fixed',
                    'Preis ab' => 'min',
                ]
            ])
            ->add('price', MoneyType::class, [
                'divisor' => 100,
            ])
            ->add('currency', ChoiceType::class, [
                'choices' => [
                    'EUR' => 'EUR',
                    'CHF' => 'CHF',
                ]
            ])
            ->add('save', SubmitType::class);

        $builder->get('trainers')
            ->addModelTransformer($this->trainerDataTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => Event::class,
            // enable/disable CSRF protection for this form
//            'csrf_protection' => false,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
        ));
    }
}