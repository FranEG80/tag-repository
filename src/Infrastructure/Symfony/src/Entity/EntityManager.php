<?php

namespace XTags\App\Entity;

class EntityManager
{    
    public function saveEntity($entity, $em): void {
        $em->persist($entity);
        $em->flush();
    }
}