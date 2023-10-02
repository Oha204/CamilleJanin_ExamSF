<?php

namespace App\DataFixtures;

use App\Entity\ActivityArea;
use App\Entity\ContractType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const SECTOR = ["RH", "Informatique", "Comptabilité", "Direction"];
    private const CONTRACT_TYPES = ["CDI", "CDD", "Intérim"];
    private const NB_EMPLOYE = 10;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        $sectors = [];

        foreach (self::SECTOR as $sectorName) {
            $activityArea = new ActivityArea();
            $activityArea->setName($sectorName);
        
            $manager->persist($activityArea);
            $sectors[] = $activityArea;
        }

        $contractTypes = [];

        foreach (self::CONTRACT_TYPES as $contractTypeName) {
            $contractType = new ContractType();
            $contractType->setName($contractTypeName);
            
            $manager->persist($contractType);
            $contractTypes[] = $contractType;
        }
        
        for ($i = 1; $i <= self::NB_EMPLOYE; $i++) {
            
            $employeeUser = new User();
            $employeeUser
            ->setEmail($faker->email())
            ->setRoles(['ROLE_USER'])
            ->setImage('profil.jpg')
            ->setPassword($faker->password())
            ->setLastname($faker ->lastName())
            ->setFirstname($faker->firstName())
            ->setContractStatus($faker->numberBetween(0, 1))
            ->setActivity($faker->randomElement($sectors))
            ->setContractType($faker->randomElement($contractTypes));
        
            $manager->persist($employeeUser);
        }

        $adminUser = new User();
        $adminUser
            ->setEmail('rh@hb.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('azerty123')
            ->setImage('profil.jpg')
            ->setLastname($faker ->lastName())
            ->setFirstname($faker->firstName())
            ->setActivity($faker->randomElement($sectors))
            ->setContractType($faker->randomElement($contractTypes))
            ->setContractStatus(1);
            
        $manager->persist($adminUser);

        $manager->flush();
    }
}
