<?php 

declare(strict_types= 1);

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\ProjectsGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Utils\Helpers;


class ProjectFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager): void {
        $projectsGroups = $manager->getRepository(ProjectsGroup::class)->findAll();

        foreach ($projectsGroups as $projectsGroup) {
            $projectsCount = rand(5, 10);
            for ($i = 0; $i < $projectsCount; $i++) {
                $project = new Project();
                $project->setName(Helpers::generateRandomString());
                $projectsGroup->addProject($project);
                $manager->persist($project);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            ProjectsGroupFixtures::class
        ];
    }
}

?>