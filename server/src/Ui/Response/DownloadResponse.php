<?php

namespace App\Ui\Response;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DownloadResponse extends BinaryFileResponse
{
    /**
     * DownloadResponse constructor.
     *
     * @param \SplFileInfo|string $file
     * @param string              $filename
     */
    public function __construct($file, $filename)
    {
        parent::__construct($file);

        $this->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
    }
}
