<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
        ) {
        }
    
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setFirstName('Morgan')
        ->setLastName('Nawrot')
        ->setBirthDate(new \DateTime('28-03-1987'))
        ->setEmail('test@gmail.com')
        ->setPassword($this->hasher->hashPassword($user, 'test1234'))
        ->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);
        $manager->flush();
    }
}