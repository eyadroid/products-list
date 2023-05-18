<?php

namespace App\Rules;

use Rakit\Validation\Rule;
use App\DB\EntityManager;

class UniqueRule extends Rule
{
    /**
     * Validation fail message.
     *
     * @var string
     */
    protected $message = ":attribute :value has been used";

    /**
     * Rule parameters.
     *
     * @var array
     */
    protected $fillableParams = ['entity', 'column', 'except'];

    /**
     * Check if value is unique.
     *
     * @param $value
     * @return boolean
     */
    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['entity', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $entity = $this->parameter('entity');
        $except = $this->parameter('except');

        if ($except and $except == $value) {
            return true;
        }

        // set entity manager
        $entityManager = EntityManager::getInstance();
        $repository = $entityManager->getRepository($entity);

        // do query
        $count = $repository->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->where('e.' . $column . ' = :value')
            ->setParameter('value', $value);

        if (isset($except)) {
            $count = $count->where('e.' . $column . ' != :except')
                ->setParameter('except', 'except');
        }

        $count = $count->getQuery()->getSingleScalarResult();

        return $count == 0;
    }
}
