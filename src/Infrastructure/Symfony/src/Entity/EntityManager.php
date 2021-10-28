<?php

namespace XTags\App\Entity;

use Doctrine\ORM\EntityManagerInterface;

class EntityManager
{    
    public function saveEntity($entity, $em): void {
        $em->persist($entity);
        $em->flush();
    }
}