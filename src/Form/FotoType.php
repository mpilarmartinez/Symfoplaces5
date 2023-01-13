<?php

namespace App\Form;

use App\Entity\Foto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;


class FotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Titulo'
            ])
            ->add('descripcion')
            ->add('fecha', DateType::class, [
                'html5' => false
            ])
            ->add('archivo', FileType::class, [
                'label' => 'Caratula (jpg, png o gif):',
                'attr' => [
                    'class' => 'file-with-preview'
                ],
                'required'  =>  false,
                'data_class'   =>   NULL,
                'constraints'   =>  [
                    new File([
                        'maxSize'   =>  '10240k',
                        'mimeTypes' =>  ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage'  => 'Debes subir una imagen png, jpg o  gif'
                    ])
                    
                ]
                
            ])
          ->add('submit', SubmitType::class, [
                'label' => 'Guardar',
              'attr' => [
                  'class' => 'btn btn-primary'
              ],
              ]
          );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Foto::class,
        ]);
    }
}
