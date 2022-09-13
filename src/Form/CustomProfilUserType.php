<?php

namespace App\Form;

use App\Entity\CustomProfilUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

class CustomProfilUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'logo',
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
            )
            ->add('color1', ColorType::class, [

                'label' => 'Couleur Primaire',
                'attr' => ['autocomplete' => 'Couleur Primaire'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Couleur Primaire',
                    ]),
                ],
            ])
            ->add('color2', ColorType::class, [

                'label' => 'Couleur Secondaire',
                'attr' => ['autocomplete' => 'Couleur Secondaire'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Couleur Secondaire',
                    ]),
                ],
            ])
            ->add('color3', ColorType::class, [

                'label' => 'Couleur Tertiaire',
                'attr' => ['autocomplete' => 'Couleur Tertiaire'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Couleur Tertiaire',
                    ]),
                ],
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre de la personnalisation',
                'attr' => ['autocomplete' => 'Titre'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Titre de votre personnalisation',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomProfilUser::class,
        ]);
    }
}
