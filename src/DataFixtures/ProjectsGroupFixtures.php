<?php 

declare(strict_types= 1);

namespace App\DataFixtures;

use App\Entity\ProjectsGroup;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Utils\Helpers;


class ProjectsGroupFixtures extends Fixture {
    public const PROJECTS_GROUPS = 'projects-groups';

    public function load(ObjectManager $manager): void {
        $projectsGroups = [];

        for ($i = 0; $i < 20; $i++) {
            $projectsGroup = new ProjectsGroup();
            $projectsGroup->setName(Helpers::generateRandomString());
            $manager->persist($projectsGroup);
            $projectsGroups[] = $projectsGroups;
        }

        $manager->flush();
        $this->addReference(self::PROJECTS_GROUPS, $projectsGroups);
    }
}

?>