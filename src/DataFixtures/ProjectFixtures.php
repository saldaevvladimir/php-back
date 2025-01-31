<?php 

declare(strict_types= 1);

namespace App\DataFixtures;

use App\Entity\Project;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Utils\Helpers;


class ProjectFixtures extends Fixture implements DependentFixtureInterface {
    public const PROJECTS = 'projects';

    public function load(ObjectManager $manager): void {
        $projectsGroups = $this->getReference(ProjectsGroupFixtures::PROJECTS_GROUPS);
        $projects = [];

        foreach ($projectsGroups as $projectsGroup) {
            $project = new Project();
            $project->setName(Helpers::generateRandomString());
            $project->setProjectsGroup($projectsGroup);
            $manager->persist($project);
            $projects[] = $project;
        }

        $manager->flush();
        $this->addReference(self::PROJECTS, $projects);
    }

    public function getDependencies(): array {
        return [
            ProjectsGroupFixtures::class
        ];
    }
}

?>