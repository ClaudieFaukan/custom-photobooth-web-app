<?php

namespace App\Form;

use App\Entity\UserOfClient;
use App\Entity\TemplateTheme;
use App\Entity\TemplateFormat;
use Symfony\Component\Form\AbstractType;
use App\Repository\TemplateThemeRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserOfClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "Email",
                "attr" => [
                    "placeholder" => 'Email'
                ]
            ])
            ->add('templateFormat', EntityType::class, [
                "class" => TemplateTheme::class,
                "choices" => [],
                "attr" => [
                    "placeholder" => 'Template format'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserOfClient::class,
        ]);
    }
}
