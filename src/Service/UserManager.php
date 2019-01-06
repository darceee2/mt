<?php

namespace App\Service;

use App\Document\User;
use App\Repository\UserRepository;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManager as BaseUserManager;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use FOS\UserBundle\Util\PasswordUpdaterInterface;

/**
 * App\Service\UserManager
 */
class UserManager extends BaseUserManager
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserManager constructor.
     *
     * @param PasswordUpdaterInterface $passwordUpdater
     * @param CanonicalFieldsUpdater   $canonicalFieldsUpdater
     * @param UserRepository           $userRepository
     */
    public function __construct(
        PasswordUpdaterInterface $passwordUpdater,
        CanonicalFieldsUpdater $canonicalFieldsUpdater,
        UserRepository $userRepository
    ) {
        parent::__construct($passwordUpdater, $canonicalFieldsUpdater);

        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteUser(UserInterface $user)
    {
        // TODO: Implement deleteUser() method.
    }

    /**
     * {@inheritdoc}
     */
    public function findUserBy(array $criteria)
    {
        return $this->userRepository->findOne($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function findUsers()
    {
        // TODO: Implement findUsers() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function reloadUser(UserInterface $user)
    {
        // TODO: Implement reloadUser() method.
    }

    /**
     * {@inheritdoc}
     */
    public function updateUser(UserInterface $user)
    {
        $this->updateCanonicalFields($user);
        $this->updatePassword($user);

        $this->userRepository->save($user);
    }
}
