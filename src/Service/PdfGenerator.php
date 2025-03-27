<?php

declare(strict_types=1);

namespace App\Service;

use Dompdf\Dompdf;

class PdfGenerator
{
    public function generate(string $html): string
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4');

        $dompdf->render();

        return $dompdf->output();
    }
}