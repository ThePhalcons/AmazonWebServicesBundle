<?php
/**
 * Created by PhpStorm.
 * User: elmehdi
 * Date: 25/10/15
 * Time: 19:01
 */

namespace Core\WSBundle\Service;


use Aws\Exception\AwsException;
use Aws\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Core\RentalBundle\Entity\RentalImage;
use Core\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


/**
 * Class StorageSerivce
 *
 * @package Core\WSBundle\Helper
 *
 * @Author : El Mehdi Mouddene  <mouddene@gmail.com>
 *
 * Initial version created on: 25/10/15 19:01
 *
 */
class StorageService {

    /**
     * const ACL
     */
    const ACL_PUBLIC = 'acl_public';

    /**
     * @var Container
     */
    private $container;

    /**
     * @var string
     */
    private $target;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var EventDispatcher
     */
    private $event_dispatcher;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Filesystem
     */
    private $fs;

    /**
     * @var S3Client
     */
    private $s3;

    /**
     * StorageService constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');

        // AWS SQS logging queue
        $this->logger = $this->container->get('api.logger');
        $this->event_dispatcher = $container->get('event_dispatcher');
        $this->fs = new Filesystem();
        $this->target =  $container->get('kernel')->getRootDir() . '/../web/tmp_uploads';
        $this->s3 = $this->container->get('amazon_s3');
    }

    /**
     * send file to S3 aws bucket
     * @param $Path file to upload
     * @param $aws_key aws target path
     * @return JsonResponse
     * @throws
     * @throws Exception
     */
    public function process($Path, $aws_key)
    {

        try {

            $this->multipartUploader($path, $aws_key);

        }catch (MultipartUploadException $e) {

            $this->logger->error('MultiPart Uploader error : ' . $e->getMessage());

            return new JsonResponse(['Error' => $e->getMessage(), 'status' => 500], 200);
        }

        $webPath = $this->container->getParameter('api.imgix.source') . '/'. $aws_key;

        return new JsonResponse(
            ['message' => "success",
                'status' => 200,
                'callback_url' => $webPath,
                'resource_id' => $image->getId()
            ], 200);
    }


    /**
     * @param $awsPath aws file  to delete
     * @return mixed|null
     * @throws Exception
     */
    private function deleteObject($bucket, $awsPath){

        $this->logger->debug('delete ' . $awsPath . ' from ' . $bucket .' bucket ...');

        $result = $this->s3->deleteObject(
            array(
                'Bucket' => $bucket,
                'Key' =>$awsPath,
            )
        );

        try {
            return $result;
            $this->logger->debug('delete ' . $awsPath . ' from ' . $bucket .' bucket ! done');
        } catch (AwsException $e) {
            throw $e;
        }
    }

    /**
     * send file to aws bucket
     * @param $absolutePath String locale file
     * @param $awsTargetPath String  aws targetPath
     * @return \Aws\Result
     * @throws \NotFoundBucket
     */
    private function multipartUploader($absolutePath, $awsTargetPath)
    {
        $bucket = 'my_bucket_name';

        $uploader = new MultipartUploader($this->s3, $absoluteFilePath, [
            'bucket' => $absolutePath,
            'key'    =>  $awsTargetPath,
        ]);


        do {
            try {
                $result = $uploader->upload();
            } catch (MultipartUploadException $e) {
                $uploader = new MultipartUploader($this->s3, $absoluteFilePath, [
                    'state' => $e->getState(),
                ]);
            }
        } while (!isset($result));

        try {
            $result = $uploader->upload();
            return $result;
        } catch (MultipartUploadException $e) {
            throw $e;
        }
    }

}

