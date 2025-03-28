<?php

namespace App\EventSubscriber;

use App\Event\AppointmentCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AppointmentSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            AppointmentCreatedEvent::class => ['notifyUsersForNewAppointment', 1024]
        ];
    }

    public function __construct(
        //private NotifyUsersForNewAppointmentService $service
    )
    {
    }

    public function notifyUsersForNewAppointment(AppointmentCreatedEvent $event): void
    {
        $users = $event->getAppointment()->getUsers();

        foreach ($users as $user) {
            //Call Email Service to notify user
            //$this->service->notify($user->getId());
        }
    }
}
