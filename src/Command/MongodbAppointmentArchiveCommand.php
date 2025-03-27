<?php

namespace App\Command;

use App\Repository\AppointmentRepository;
use App\Service\MongoDb\AppointmentCollectionFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AsCommand(
    name: 'mongodb:appointment:archive',
    description: 'Archives old Appointments to MongoDb',
)]
class MongodbAppointmentArchiveCommand extends Command
{
    public function __construct(
        private AppointmentCollectionFactory $appointmentCollectionFactory,
        private AppointmentRepository        $appointmentRepository,
        private NormalizerInterface          $normalizer,
        private EntityManagerInterface       $entityManager
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $oldAppointments = $this->appointmentRepository->findAppointmentsFromThePast();

        $io->progressStart(count($oldAppointments));

        foreach ($oldAppointments as $appointment) {
            $appointmentArray = $this->normalizer->normalize($appointment, null, ['groups' => ['appointment']]);

            $result = $this->appointmentCollectionFactory->getCollection()->insertOne($appointmentArray);

            if ($result->getInsertedCount() === 1) {
                $this->entityManager->remove($appointment);
                $this->entityManager->flush();
            }

            $io->progressAdvance();
        }

        $io->progressFinish();
        $io->success("Archiving successfully done!");

        return Command::SUCCESS;
    }
}
