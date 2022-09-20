<?php

namespace App\Form\navbar;

use App\Entity\CustomProfilUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BackgroundProfilUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'pictureProfilBackground',
            FileType::class,
            ['constraints' => [
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
            ],]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomProfilUser::class,
        ]);
    }
}
