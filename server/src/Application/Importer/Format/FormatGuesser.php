<?php

namespace App\Application\Importer\Format;

use App\Domain\File\FileInterface;

class FormatGuesser implements FormatGuesserInterface
{
    /**
     * @var array
     */
    private static $mimetypes = [
        'text/csv'         => 'csv',
        'application/json' => 'json',
        'text/xml'         => 'xml',
        'application/xml'  => 'xml',
    ];

    /**
     * {@inheritdoc}
     */
    public function guess(FileInterface $file): string
    {
        if (isset(self::$mimetypes[$file->getMimeType()])) {
            return self::$mimetypes[$file->getMimeType()];
        }

        throw new \LogicException('Exporter not found');
    }
}
