<?php

namespace App\Form;

use App\Entity\InfoEleve;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FicheUrgenceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSecuSocial')
            ->add('addresseSecuSocial')

            ->add('nomAssurance')
            ->add('addresseAssurance')
            ->add('numeroAssurance')
            ->add('dateAntitetanique'
            , DateType::class,  [
                'widget' => 'single_text',
                'input' => 'datetime'
            ])
            ->add('observation')
            ->add('nomContactUrgence')
            ->add('numContactUrgence')

            ->add('nomMedecin')
            ->add('adresseMedecin')
            ->add('numeroMedecin');
    }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class'=>InfoEleve::class,
    //     ]);
    // }
}
