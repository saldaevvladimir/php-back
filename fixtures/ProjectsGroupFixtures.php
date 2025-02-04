<?php 

declare(strict_types= 1);

namespace App\DataFixtures;

use App\Entity\ProjectsGroup;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function App\helpers\generateRandomString;
use function App\helpers\generateDatetimeBetween;


class ProjectsGroupFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        $date1 = new DateTimeImmutable('2020-01-01');
        $date2 = new DateTimeImmutable('2022-10-10');
        $date3 = new DateTimeImmutable('2024-10-10');
        for ($i = 0; $i < 20; $i++) {
            $projectsGroup = new ProjectsGroup();
            $projectsGroup->setName(generateRandomString());
            $projectsGroup->setCreatedAt(generateDatetimeBetween($date1, $date2));
            $projectsGroup->setUpdatedAt(generateDatetimeBetween($date2, $date3));

            $manager->persist($projectsGroup);
        }

        $manager->flush();
    }

}

?>