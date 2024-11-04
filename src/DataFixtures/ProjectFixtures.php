<?php 

declare(strict_types= 1);

namespace App\DataFixtures;

use App\Entity\Project;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Utils\Helpers;


class ProjectFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        $date1 = new DateTimeImmutable('2020-01-01');
        $date2 = new DateTimeImmutable('2022-10-10');
        $date3 = new DateTimeImmutable('2024-10-10');
        for ($i = 0; $i < 40; $i++) {
            $project = new Project();
            $project->setName(Helpers::generateRandomString());
            $project->setCreatedAt(Helpers::generateDatetimeBetween($date1, $date2));
            $project->setUpdatedAt(Helpers::generateDatetimeBetween($date2, $date3));

            $manager->persist($project);
        }

        $manager->flush();
    }

}

?>