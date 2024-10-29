<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Plan;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PlanType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    : void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Name',
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('price', NumberType::class, [
                'label'=>'Price',
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('download_upload', TextType::class, [
                'label'=>'Download/Upload',
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('description', TextType::class, [
                'label'=>'Description',
                'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('is_active', TextType::class, [
            'label'=>'isActive',
            'attr'=>[
                'class'=>'form-control',
            ],
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plan::class,
        ]);
    }

}