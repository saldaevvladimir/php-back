<?php 

declare(strict_types= 1);

namespace App\DataFixtures;

use App\Entity\Task;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Utils\Helpers;


class TaskFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager): void {
        $projects = $this->getReference(ProjectFixtures::PROJECTS);

        foreach ($projects as $project) {
            $task = new Task();
            $task->setName(Helpers::generateRandomString());
            $task->setDescription(Helpers::generateRandomString(20));
            $task->setProject($project);
            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            ProjectFixtures::class
        ];
    }

}

?>