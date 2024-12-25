<?php

namespace Kernel\Components\File\Pdf;

use TCPDF;

class PdfWriterFromHtml
{
    /**
     * @infection-ignore-all
     * @param int[] $format
     */
    public function generatePdfFromHtml(
        string $html,
        string $title,
        string $subject = '',
        string $orientation = 'P',
        array $format = [100, 200],
        string $dest = 'I',
        string $author = "Qrpay",
        string $keywords = '',
        int $fontSize = 8
    ): string {
        // create new PDF document
        /** @var string $pdfUnit */
        $pdfUnit = PDF_UNIT;
        $pdf = new TCPDF($orientation, $pdfUnit, $format, true, 'UTF-8', false);

        // set document information
        /** @var string $pdfCreator */
        $pdfCreator = PDF_CREATOR;
        $pdf->SetCreator($pdfCreator);
        $pdf->SetAuthor($author);
        $pdf->SetTitle($title);
        $pdf->SetSubject($subject);
        $pdf->SetKeywords($keywords);
        // set image scale factor

        // set font
        $pdf->SetFont('freeserif', '', $fontSize);

        // remove top horizontal line
        $pdf->SetPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->setImageScale(1.8);

        // add a page
        $pdf->AddPage();

        $pdf->writeHTML($html, false);
        switch ($dest) {
            case 'I':
                $pdf->Output($title . '.pdf', 'I');
                return '';
            case 'F':
                $pdf->Output(sys_get_temp_dir() . '/' . $title . '.pdf', 'F');
                return sys_get_temp_dir() . '/' . $title . '.pdf';
            default:
                return '';
        }
    }
}
