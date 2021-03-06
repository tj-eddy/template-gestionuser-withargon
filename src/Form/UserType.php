<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    private $_translator;
    private $security;

    /**
     * PpApprovisionementDirecteType constructor.
     */
    public function __construct(Security $security)
    {
        $this->security    = $security;
        $this->_translator = new Translator(\Locale::getDefault());
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = array_values($this->security->getUser()->getRoles());

        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => "Nom ..."
                ],

            ])
            ->add('email', EmailType::class, [
                "label" => "Adresse email",
                'attr'  => [
                    'class'       => 'form-control',
                    "placeholder" => "Addresse email ..."
                ]
            ]);
        if (!in_array('ROLE_SUPERADMIN', $roles)) {
            $builder
                ->add('password', RepeatedType::class, [
                    'type'            => PasswordType::class,
                    'first_options'   => [
                        'attr'        => [
                            'class' => 'form-control'
                        ],
                        'constraints' => [
                            new NotBlank([
                                'message' => $this->_translator->trans('password.validation'),
                            ]),
                            new Length([
                                'min'        => 6,
                                'minMessage' => 'Votre mot de passe doit comporter au moins 6 caract??res',
                                // max length allowed by Symfony for security reasons
                                'max'        => 4096,
                            ]),
                        ],
                        'label'       => $this->_translator->trans('new.password'),
                    ],
                    'second_options'  => [
                        'attr'  => [
                            'class' => 'form-control'
                        ],
                        'label' => $this->_translator->trans('repeated.password'),
                    ],
                    'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                    'mapped'          => false,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
