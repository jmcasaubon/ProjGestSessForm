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
        $usr1 = new User();

        $pass = $this->encoder->encodePassword($usr1, "JMi-65++");

        $usr1->setEmail("jmcasaubon@gmail.com");
        $usr1->setPseudo("jmc");
        $usr1->setRoles(["ROLE_ADMIN"]);
        $usr1->setPassword($pass);

        $usr2 = new User();

        $pass = $this->encoder->encodePassword($usr2, "JMi-65++");

        $usr2->setEmail("jm_casaubon@hotmail.com");
        $usr2->setPseudo("jmi");
        $usr2->setRoles(["ROLE_FORM"]);
        $usr2->setPassword($pass);

        $manager->persist($usr1);
        $manager->persist($usr2);
        $manager->flush();
    }
}
