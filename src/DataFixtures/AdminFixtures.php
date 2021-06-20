<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{

    
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
    $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $admin = new Admin();

        $admin->setEmail("admin@gmail.com");
        $admin->setFull(true);
        $admin->setModerator(false);
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setMobile(29892420);
        $admin->setProfileimage('default.jpg');
        $admin->setCreatedAt(new \DateTime());
        $admin->setPassword($this->passwordEncoder->encodePassword(
        $admin,
        "02111998"
        ));
        $manager->persist($admin);
        $manager->flush();

    }
}
