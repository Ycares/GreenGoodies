<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // Utilisateur admin
        $admin = new User();
        $admin->setEmail('admin@greengoodies.fr');
        $admin->setFirstName('Admin');
        $admin->setLastName('GreenGoodies');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setApiEnabled(true);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $admin->setCreatedAt(new \DateTimeImmutable('2024-01-01'));
        $manager->persist($admin);

        // Utilisateur standard
        $user1 = new User();
        $user1->setEmail('jean.dupont@example.fr');
        $user1->setFirstName('Jean');
        $user1->setLastName('Dupont');
        $user1->setRoles([]);
        $user1->setApiEnabled(false);
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'test'));
        $user1->setCreatedAt(new \DateTimeImmutable('2024-02-15'));
        $manager->persist($user1);

        // Utilisateur avec API activée
        $user2 = new User();
        $user2->setEmail('marie.martin@example.fr');
        $user2->setFirstName('Marie');
        $user2->setLastName('Martin');
        $user2->setRoles([]);
        $user2->setApiEnabled(true);
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'test'));
        $user2->setCreatedAt(new \DateTimeImmutable('2024-03-10'));
        $manager->persist($user2);

        // Utilisateur supplémentaire
        $user3 = new User();
        $user3->setEmail('pierre.bernard@example.fr');
        $user3->setFirstName('Pierre');
        $user3->setLastName('Bernard');
        $user3->setRoles([]);
        $user3->setApiEnabled(false);
        $user3->setPassword($this->passwordHasher->hashPassword($user3, 'test'));
        $user3->setCreatedAt(new \DateTimeImmutable('2024-04-20'));
        $manager->persist($user3);

        $manager->flush();
    }
}
