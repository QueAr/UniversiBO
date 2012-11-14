<?php

namespace Universibo\Bundle\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Universibo\Bundle\CoreBundle\Entity\Person;

/**
 * BatchRenameRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function getUsernameFromId($id)
    {
        $user = $this->find($id);

        return $user instanceof User ? $user->getUsername() : null;
    }

    /**
     * Tells if a username exists
     *
     * @param  string  $username
     * @return boolean
     */
    public function usernameExists($username)
    {
        return $this->findOneByUsername($username) instanceof User;
    }

    public function search($usernameQuery, $mailQuery, $showLocked = false,
            $showDisabled = false)
    {
        $qb = $this->createQueryBuilder('u');

        if (!$showLocked) {
            $qb->andWhere('u.locked = false');
        }

        if (!$showDisabled) {
            $qb->andWhere('u.enabled = true');
        }

        if (strlen($usernameQuery) > 0) {
            $qb->andWhere('u.usernameCanonical LIKE ?0');
        }

        if (strlen($mailQuery) > 0) {
            $qb->andWhere('u.emailCanonical LIKE ?1');
        }

        return
            $qb -> getQuery()
                -> setParameters(array(mb_strtolower($usernameQuery), mb_strtolower($mailQuery)))
                -> getResult();
    }

    public function countByPerson(Person $person)
    {
        $dql = <<<EOT
SELECT COUNT(u)
    FROM UniversiboCoreBundle:User u
    WHERE
            u.person = ?0
        AND u.locked = false
EOT;

        $query = $this
            ->getEntityManager()
            ->createQuery($dql)
        ;

        $query->execute(array($person));

        return $query->getSingleScalarResult();
    }

    public function findCollaborators()
    {
        $qb = $this->createQueryBuilder('u');

        $qb->add('where', $qb->expr()->in('u.legacyGroups', array(4, 64)));

        return $qb->getQuery()->getResult();
    }

    /**
     * @param  Person                   $person
     * @throws NonUniqueResultException
     * @return User
     */
    public function findOneAllowedToLogin(Person $person)
    {
        $dql = <<<EOT
SELECT u
    FROM UniversiboCoreBundle:User u
    WHERE
            u.person = ?0
        AND u.locked = false
        AND u.enabled = true
EOT;

        $query = $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameter(0, $person)
        ;

        return $query->getSingleResult();
    }

    public function save(User $user)
    {
        $em = $this->getEntityManager();
        $user = $em->merge($user);
        $em->flush($user);

        return $user;
    }
}
