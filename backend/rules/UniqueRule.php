<?php

namespace Rules;

use Rakit\Validation\Rule;
use Utils\EntityManager;

class UniqueRule extends Rule
{
    protected $message = ":attribute :value has been used";

    protected $fillableParams = ['entity', 'column', 'except'];

    public function __construct()
    {
        //
    }

    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['entity', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $entity = $this->parameter('entity');
        $except = $this->parameter('except');

        if ($except AND $except == $value) {
            return true;
        }

        // set entity manager
        $entityManager = EntityManager::getInstance();
        $repository = $entityManager->getRepository($entity);

        // do query
        $count = $repository->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->where('e.'.$column.' = :value')
            ->setParameter('value', $value);

        if (isset($except)) {
            $count = $count->where('e.'.$column.' != :except')
                ->setParameter('except', 'except');
        }

        $count = $count->getQuery()->getSingleScalarResult();

        return $count == 0;
    }
}
