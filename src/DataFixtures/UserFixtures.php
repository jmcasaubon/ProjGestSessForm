<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $pass = $this->encoder->encodePassword($user, "JMi-65++");

        $user->setEmail("jmcasaubon@gmail.com");
        $user->setPseudo("jmc");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($pass);

        $manager->persist($user);
        $manager->flush();
    }
}
