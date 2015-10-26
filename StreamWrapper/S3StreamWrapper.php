<?php

namespace AmazonWebServicesBundle\StreamWrapper;

use \S3StreamWrapper as BaseS3StreamWrapper;
use \CFMimeTypes;

class S3StreamWrapper extends BaseS3StreamWrapper
{
    /**
     * {@inheritdoc}
     */
    public function stream_flush()
    {
        if ($this->buffer === null)
        {
            return false;
        }

        list($protocol, $bucket, $object_name) = $this->parse_path($this->path);

        $extension = explode('.', $object_name);
        $extension = array_pop($extension);
        if ('woff' === $extension) {
            $contentType = 'application/x-font-woff';
        } else {
            $contentType = CFMimeTypes::get_mimetype($extension);
        }

        $response = $this->client($protocol)->create_object($bucket, $object_name, array(
            'body' => $this->buffer,
            'contentType' => $contentType,
            'headers' => $this->buildHeadersForContent($this->buffer)
        ));

        $this->seek_position = 0;
        $this->buffer = null;
        $this->eof = true;

        return $response->isOK();
    }

    public static function register(\AmazonS3 $s3 = null, $protocol = 's3')
    {
        self::$_clients[$protocol] = $s3 ? $s3 : new \AmazonS3();

        return stream_wrapper_register($protocol, __CLASS__);
    }

    private function buildHeadersForContent($content)
    {
        $path = tempnam(sys_get_temp_dir(), 's3_mime_type');        
        file_put_contents($path, $content);

        $headers = array();

        if($this->isFileGzipped($path)){
            $headers['Content-Encoding'] = "gzip";
        }

        unlink($path);

        return $headers;
    }

    private function isFileGzipped($path)
    {
        return $this->getFileMimeType($path) == "application/x-gzip";
    }

    private function getFileMimeType($path)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $path);
        finfo_close($finfo);
        
        return $mimeType;
    }
}