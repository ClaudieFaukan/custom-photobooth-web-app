<?php

namespace App\Form\navbar;

use App\Entity\CustomProfilUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProfilPictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'pictureProfil',
            FileType::class,
            [
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],
            ]
        )->add(
            'pictureProfilBackground',
            FileType::class,
            [
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomProfilUser::class,
        ]);
    }
}
