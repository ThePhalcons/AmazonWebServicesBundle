<?php

/**
 * Class StorageServiceTest
 *
 * @package Core\WSBundle\Tests\Service
 *
 * @Author : El Mehdi Mouddene  <mouddene@gmail.com>
 *
 * Initial version created on: 23/01/16 23:59
 *
 */

class StorageServiceTest extends WebTestCase
{

    public function testServiceInjection(){
        $client = $this->createClient();
        $s3 = $client->getContainer()->get('amazon_S3');
        assert( $s3 !== null, 'Requested service unavailble');
    }

    public function testDoesContainerHasUploadBucketParameter(){
        $client = $this->createClient();
        assert($client->getContainer()->hasParameter('the_phalcons_amazon_web_services.services.S3.bucket') === true, "Container hasn't the_phalcons_amazon_web_services.services.S3.bucket parameter");
    }

    public function testCreateBucket(){
        /** @var S3Client $client */
        $client = $this->createClient();
        $client->createBucket(array(
            'Bucket' => 'mybucket',
            'LocationConstraint' => 'us-west-2',
        ));

        assert($client->doesBucketExist("mybucket") === true, "bucket doesn't exist !!!")
        $client->deleteBucket(array(
            'Bucket' => 'mybucket',
            'LocationConstraint' => 'us-west-2',
        ));

        assert($client->doesBucketExist("mybucket") === false, "bucket hasn't been deleted !!!")
    }

}
