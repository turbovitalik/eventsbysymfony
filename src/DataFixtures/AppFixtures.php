<?php

namespace App\DataFixtures;

use App\Entity\Event\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $eventTypeNames = [
        'Abendveranstaltung',
        'Ausbildung',
        'Fortlaufender Kurs',
        'Mehrtägige Veranstaltung',
        'Online-Programm',
        'Tagesseminar',
        'Vortrag',
    ];

    private $userNames = [
        ['John', 'Doe'],
        ['Will', 'Smith'],
        ['Boris', 'Johnson'],
        ['Mike', 'Tyson'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->eventTypeNames as $typeName) {
            $type = new Type();
            $type->setTitle($typeName);
            $manager->persist($type);
        }

        foreach ($this->userNames as $userData) {
            $user = new User();
            $user->setFirstName($userData[0]);
            $user->setLastName($userData[1]);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
