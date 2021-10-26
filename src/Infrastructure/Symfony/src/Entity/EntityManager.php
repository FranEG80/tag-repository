<?php

namespace XTags\App\Entity;

use Doctrine\ORM\EntityManagerInterface;

class EntityManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function saveEntity($entity): void {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
