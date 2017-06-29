<?php

namespace App\Infrastructure\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GantzDownloadCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $base = 'http://www.mangareader.net';
        $href = '/gantz/1';

        list ($tome, $page) = $this->getTome($href);

        $continue = true;

        do {
            if ($tome === 383 && $page === 31) {
                $continue = false;
            }

            $html = file_get_contents($base.$href);

            $document = new \DOMDocument();
            $document->loadHTML($html);

            $xpath = new \DOMXPath($document);

            // next

            $next = $xpath->query('//*[@id="navi"]/div[1]/span[2]/a/@href');
            $href = $next->item(0)->nodeValue;

            // img

            $image = $xpath->query('//*[@id="img"]/@src');
            $src = $image->item(0)->nodeValue;

            // dl
            $dest = sprintf('%s/gantz/%s-%s.jpg', __DIR__, str_pad((string) $tome, 3, 0, STR_PAD_LEFT), str_pad((string) $page, 3, 0, STR_PAD_LEFT));

            file_put_contents($dest, file_get_contents($src));

            list ($tome, $page) = $this->getTome($href);

        } while ($continue);
    }

    private function getTome($href)
    {
        $matches = [];

        preg_match('/^\/gantz\/([0-9]+)(?:\/([0-9]+))?$/', $href, $matches);

        return [(int) $matches[1], (int) ($matches[2] ?? 1)];
    }
}
