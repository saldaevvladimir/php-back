<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProjectsGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectsGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectsGroup|null findByOne(array $criteria, array $orderBy = null)
 * @method ProjectsGroup[]    findAll()
 * @method ProjectsGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @template-extends ServiceEntityRepository<ProjectsGroup>
*/
class ProjectsGroupRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ProjectsGroup::class);
    }
}

?>