<?php

namespace App\Application\Importer\Format;

use App\Domain\File\UploadedFileInterface;

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
    public function guess(UploadedFileInterface $file): string
    {
        if (isset(self::$mimetypes[$file->getMimeType()])) {
            return self::$mimetypes[$file->getMimeType()];
        }

        throw new \LogicException('Exporter not found');
    }
}
