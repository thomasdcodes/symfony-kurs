<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ToGermanDateTimeExtensionRuntime implements RuntimeExtensionInterface
{
    public function toGermanDatetime(\DateTimeInterface $value): string
    {
        return $value->format('d.m.Y H:i');
    }
}
