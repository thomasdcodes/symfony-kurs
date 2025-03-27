<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\ToGermanDateTimeExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ToGermanDateTimeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('to_german_datetime', [ToGermanDateTimeExtensionRuntime::class, 'toGermanDatetime']),
        ];
    }
}
