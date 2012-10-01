<?php

namespace Cybernox\AmazonWebServicesBundle\StreamWrapper;

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
}