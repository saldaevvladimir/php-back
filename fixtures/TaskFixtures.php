<?php 

declare(strict_types= 1);

namespace App\DataFixtures;

use App\Entity\Task;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function App\helpers\generateRandomString;
use function App\helpers\generateDatetimeBetween;


class TaskFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        $date1 = new DateTimeImmutable('2020-01-01');
        $date2 = new DateTimeImmutable('2022-10-10');
        $date3 = new DateTimeImmutable('2024-10-10');
        for ($i = 0; $i < 80; $i++) {
            $task = new Task();
            $task->setName(generateRandomString());
            $task->setDescription(generateRandomString(20));
            $task->setCreatedAt(generateDatetimeBetween($date1, $date2));
            $task->setUpdatedAt(generateDatetimeBetween($date2, $date3));

            $manager->persist($task);
        }

        $manager->flush();
    }

}

?>