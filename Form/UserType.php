<?php

namespace App\Oni\UserManagerBundle\Form;

use App\Oni\UserManagerBundle\Entity\Repository\GroupRepository;
use App\Oni\UserManagerBundle\Service\UserService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    /**
     * @var \App\Oni\UserManagerBundle\Entity\Repository\UserRepository
     */
    protected $userService;

    /**
     * @var \App\Oni\UserManagerBundle\Entity\Repository\GroupRepository
     */
    protected $groupRepository;

    /**
     * @var
     */
    protected $authenticationToken;

    public function __construct(
        TokenStorageInterface $authenticationToken,
        UserService $userService,
        GroupRepository $groupRepository
        )
    {
        $this->authenticationToken = $authenticationToken;
        $this->userService = $userService;
        $this->groupRepository = $groupRepository;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'Oni\UserManagerBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        ));

    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $buttonName = $options['data']->getId() > 0 ? 'Save' : 'Add';
        $id = $options['data']->getId();
        $currentUser = $this->authenticationToken->getToken()->getUser();
        $accessLevel = $this->userService->getUserHighestAccessLevel($currentUser);

        $builder
            ->add('firstName', TextType::class, array(
                    'label'=>'First Name',
                )
            )
            ->add('lastName', TextType::class, array(
                    'label'=>'Last Name',
                )
            )
            ->add('username', TextType::class, array(
                'label'=>'Username',
                )
            )
            ->add('email', EmailType::class, array(
                    'label'=>'Email Address',
                    'attr' => array(
                        'plugin' => 'switch'
                    )
                )
            )

            ->add('enabled', CheckboxType::class, array(
                    'label'=>'Enabled',
                    'required' => 'false',
                    'attr' => array(
                        'plugin' => 'switch'
                    )
                )
            )

            ->add('groups', EntityType::class , array(
                    'class' => 'UserManagerBundle:Group',
                    'choice_label' => 'name',
                    'attr' => array(
                        'class' => 'select2 input-xlarge',
                        'multiple' => 'true'
                    ),
                    'choices' => $this->groupRepository->findGroupsWhereAccessLevelIsLessThan($accessLevel),
                    'multiple' => true
                )
            )

            ->add('add', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary'),
                    'label' => $buttonName
                )
            );
    }


    public function getName()
    {
        return 'user_manager_bundle_user_form';
    }
}
