<?php 

declare(strict_types= 1);

namespace App\DataFixtures;
use App\Entity\ProjectsGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Utils\Helpers;


class ProjectsGroupFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        $projectsGroupsCount = 15;
        for ($i = 0; $i < $projectsGroupsCount; $i++) {
            $projectsGroup = new ProjectsGroup();
            $projectsGroup->setName(Helpers::generateRandomString());
            $manager->persist($projectsGroup);
        }

        $manager->flush();
    }
}

?>