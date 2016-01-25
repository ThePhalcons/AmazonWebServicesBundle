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


    public function testCreateBucket(){
        /** @var S3Client $client */
        $client = $this->createClient();
        $s3 = $client->getContainer()->get('amazon_S3');

        $s3->createBucket(array(
            'Bucket' => 'mybucket',
            'LocationConstraint' => 'us-west-2',
        ));

        assert($s3->doesBucketExist("mybucket") === true, "bucket doesn't exist !!!")
        $s3->deleteBucket(array(
            'Bucket' => 'mybucket',
            'LocationConstraint' => 'us-west-2',
        ));

        assert($s3->doesBucketExist("mybucket") === false, "bucket hasn't been deleted !!!")
    }

}
