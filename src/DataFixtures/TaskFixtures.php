<?php 

declare(strict_types= 1);

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Utils\Helpers;


class TaskFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager): void {
        $projects = $manager->getRepository(Project::class)->findAll();

        foreach ($projects as $project) {
            $tasksCount = rand(5, 20);
            for ($i = 0; $i < $tasksCount; $i++) {
                $task = new Task();
                $task->setName(Helpers::generateRandomString());
                $task->setDescription(Helpers::generateRandomString(20));
                $project->addTask($task);
                $manager->persist($task);
            }
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