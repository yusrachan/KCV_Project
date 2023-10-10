<?php

namespace App\Form;

use App\Entity\RendezVous;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom'])
            ->add('prenom', TextType::class, ['label' => 'Prénom'])
            ->add('email', TextType::class, ['label' => 'E-mail'])
            ->add('numero', IntegerType::class, ['label' => 'N° de téléphone'])
            ->add('adresse', TextType::class, ['label' => 'Adresse'])
            ->add('valider', IntegerType::class, ['label' => 'Réserver'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
