<?php

namespace Statamic\Addons\Pdfcrowd;

use Statamic\Extend\Tags;

class PdfcrowdTags extends Tags
{
    private $url;
    private $pdf;

    public function generate()
    {
        // The URL of the PDF-able content will either be specified by
        // the tag pair content, or the single tag's url parameter.
        $this->url = trim(
            ($this->isPair) ? $this->parse([]) : $this->get('url')
        );

        $this->generatePdf();

        $this->download();
    }

    private function generatePdf()
    {
        $generator = new PdfGenerator($this->getConfig());

        $this->pdf = $generator->generate($this->url);
    }

    private function download()
    {
        header("Content-Type: application/pdf");
        header("Cache-Control: no-cache");
        header("Accept-Ranges: none");
        header("Content-Disposition: attachment; filename=\"{$this->filename()}\"");

        echo $this->pdf;
    }

    private function filename()
    {
        $filename = str_replace('http://', '', $this->url);
        $filename = str_replace('www.', '', $filename);
        $filename = str_replace('.', '_', $filename);
        $filename = str_replace('/', '_', $filename);

        return $filename . '.pdf';
    }
}
