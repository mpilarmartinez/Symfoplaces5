<?php

namespace App\Form;

use App\Entity\Lugar;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LugarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre'
            ])
                
            ->add('pais',  TextType::class, [
                'label' => 'Pais' 
                ])
            ->add('descripcion')
            ->add('tipo', TextType::class, [
                'label' => 'Tipo'
            ])        
            ->add('valoracion')
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lugar::class,
        ]);
    }
}
