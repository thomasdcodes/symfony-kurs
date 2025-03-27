<?php

namespace App\Security\Voter;

use App\Entity\Appointment;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class AppointmentVoter extends Voter
{
    public const VIEW = 'APPOINTMENT:VIEW';
    public const EDIT = 'APPOINTMENT:EDIT';
    public const DELETE = 'APPOINTMENT:DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])
            && $subject instanceof Appointment;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:

                break;
            case self::EDIT:

                break;
            case self::DELETE:

                break;
            default:
                return false;
        }

        return false;
    }
}
