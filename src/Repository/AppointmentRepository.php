<?php

namespace App\Repository;

use App\Entity\Appointment;
use App\Service\MongoDb\AppointmentCollectionFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MongoDB\Model\BSONDocument;

/**
 * @extends ServiceEntityRepository<Appointment>
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private AppointmentCollectionFactory $appointmentCollectionFactory
    )
    {
        parent::__construct($registry, Appointment::class);
    }

    /** @return Appointment[] Returns an array of Appointment objects */
    public function findAppointmentsFromThePast(): array
    {
        $dateTimeNow = new \DateTimeImmutable('now');

        return $this->createQueryBuilder('a')
            ->andWhere('a.startDateTime < :val')
            ->setParameter('val', $dateTimeNow)
            ->getQuery()
            ->getResult();
    }

    public function findArchived(): array
    {
        $collection = $this->appointmentCollectionFactory->getCollection();

        $result = $collection->find();

        $resultArray = [];
        /** @var BSONDocument $appointment */
        foreach ($result as $appointment) {
            //TODO: Mapping auf DomainModel wäre besser
            $resultArray[] = $appointment->getArrayCopy();
        }

        return $resultArray;
    }
}
