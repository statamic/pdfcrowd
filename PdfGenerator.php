<?php

namespace Statamic\Addons\Pdfcrowd;

use Pdfcrowd;

class PdfGenerator
{
    private $config;
    private $client;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new Pdfcrowd($config['username'], $config['api_key']);
    }

    public function generate($url)
    {
        $this->setPageSize();
        $this->setFooter();
        $this->setSecurity();
        $this->setInitialView();
        $this->setHtmlOptions();
        $this->client->setPdfScalingFactor($this->config['pdf_scaling'] / 100);

        return $this->client->convertURI($url);
    }

    private function setPageSize()
    {
        $this->client->setPageWidth(
            $this->config['page_width'] . $this->config['page_width_dimension']
        );

        $this->client->setPageHeight(
            $this->config['one_long_page']
                ? -1
                : $this->config['page_height'] . $this->config['page_height_dimension']
        );

        $this->client->setHorizontalMargin(
            $this->config['horizontal_margins'] . $this->config['horizontal_margins_dimension']
        );

        $this->client->setVerticalMargin(
            $this->config['vertical_margins'] . $this->config['vertical_margins_dimension']
        );
    }

    private function setFooter()
    {
        $footer_text = [];

        if ($this->config['add_page_number']) {
            $footer_text[] = '%p';
        }

        if ($this->config['add_footer_source_url']) {
            $footer_text[] = '%u';
        }

        $this->client->setFooterText(implode('|', $footer_text));

        $this->client->enablePdfcrowdLogo($this->config['add_pdfcrowd_logo']);
    }

    private function setSecurity()
    {
        if ($user_pass = $this->config['user_password']) {
            $this->client->setUserPassword($user_pass);
        }

        if ($owner_pass = $this->config['owner_password']) {
            $this->client->setOwnerPassword($owner_pass);
        }

        $this->client->setNoPrint(! $this->config['printing_allowed']);

        $this->client->setNoCopy(! $this->config['copying_allowed']);

        $this->client->setNoModify(! $this->config['modification_allowed']);

        $this->client->setEncrypted($this->config['encrypt']);
    }

    private function setInitialView()
    {
        if ($layout = $this->config['page_layout']) {
            $this->client->setPageLayout($layout);
        }

        if ($zoom = $this->config['initial_zoom']) {
            if ($zoom != 'zoom') {
                $this->client->setInitialPdfZoomType($zoom);
            } else {
                $this->client->setInitialPdfExactZoom($this->config['zoom']);
            }
        }

        if ($this->config['full_screen']) {
            $this->client->setPageMode(Pdfcrowd::FULLSCREEN);
        }
    }

    private function setHtmlOptions()
    {
        $this->client->enableJavaScript($this->config['run_js']);

        $this->client->enableImages($this->config['print_images']);

        $this->client->enableBackgrounds($this->config['print_backgrounds']);

        $this->client->enableHyperlinks($this->config['make_hyperlinks']);

        $this->client->usePrintMedia($this->config['use_print_version']);

        $this->client->setHtmlZoom($this->config['html_zoom']);
    }
}
