<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ToGermanDateTimeExtensionRuntime implements RuntimeExtensionInterface
{
    public function toGermanDatetime(string|\DateTimeInterface $value): string
    {
        if (is_string($value)) {
            $value = new \DateTimeImmutable($value);
        }

        return $value->format('d.m.Y H:i');
    }
}
