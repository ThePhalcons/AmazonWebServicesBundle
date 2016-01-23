<?php
/**
 * Created by PhpStorm.
 * User: elmehdi
 * Date: 23/01/16
 * Time: 02:31
 */

namespace Core\WSBundle\Service;

use Monolog\Logger;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class SESMailingService
 *
 * @package Core\WSBundle\Service
 *
 * @Author : El Mehdi Mouddene  <mouddene@gmail.com>
 *
 * Initial version created on: 23/01/16 02:31
 *
 */
class SESMailingService
{


    /**
     * @var Container
     */
    private $container;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var object
     */
    protected $mailer;

    /**
     * The email address that is sending the email.
     * @var
     */
    protected $source;

    /**
     * The sender name that is sending the email.
     * @var
     */
    protected $name;

    /**
     * The subject of the message: A short summary of the content, which will appear in the recipient's inbox.
     * @var
     */
    protected $subject;

    /**
     * The To: field(s) of the message.
     * @var array
     */
    protected $toAddresses = array();

    /**
     * The message body.
     * @var
     */
    protected $body;

    /**
     * The CC: field(s) of the message.
     * @var array
     */
    protected $ccAddresses = array();

    /**
     * The To: field(s) of the message.
     * @var array
     */
    protected $bccAddresses = array();

    /**
     * he reply-to email address(es) for the message. If the recipient replies to the message, each reply-to address will receive the reply.
     *
     * @var array
     */
    protected $replyToAddresses = array();

    /**
     * f the message cannot be delivered to the recipient, then an error message will be returned from the recipient's
     * @var String
     */
    protected $returnPath;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->mailer = $container->get('amazon_SES');
        $this->logger = $container->get('logger');
        $this->initMailer();
    }

    /**
     * init mailer service
     */
    private function initMailer()
    {
        $this->setDefaultSource();
        //TODO: remove on go live
        $this->bccAddresses[] = 'mouddene@gmail.com';
    }

    /**
     * set default source and reply addresses from global config
     */
    public function setDefaultSource()
    {
        $this->source = $this->container->getParameter('ws.services.SES.mail_config.no_reply_address');

        $this->replyToAddresses[] = $this->container->getParameter('ws.services.SES.mail_config.reply_address');

        return $this;
    }

    /**
     * @param String $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source =  $source;

        return $this;
    }

    /**
     * @param $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param Array $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->toAddresses = $to;
        return $this;
    }

    /**
     * @param $toAddress
     * @return $this
     */
    public function addToAddress($toAddress){
        $this->toAddresses[] = $toAddress;
        return $this;
    }

    /**
     * @param $body
     * @return $this
     */
    public function setMessage($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param $ccAddress
     * @return $this
     */
    public function addCCAddress($ccAddress){
        $this->ccAddresses[] = $ccAddress;
        return $this;
    }

    /**
     * @param $bccAddress
     * @return $this
     */
    public function addBccAddress($bccAddress){
        $this->bccAddresses[] = $bccAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function sendEmail(){
        $result = $this->mailer->sendEmail(
            array(
                // Source is required
                'Source' => $this->source,

                // Destination is required
                'Destination' => array(
                    'ToAddresses' => $this->toAddresses,
                    'CcAddresses' => $this->ccAddresses,
                    'BccAddresses' => $this->bccAddresses,
                ),
                // Message is required
                'Message' => array(
                    // Subject is required
                    'Subject' => array(
                        // Data is required
                        'Charset' => 'UTF-8' ,
                        'Data' => $this->subject,
                    ),
                    // Body is required
                    'Body' => array(
                        'Text' => array(
                            // Data is required
                            'Charset' => 'UTF-8',
                            'Data' =>  $this->body, // REQUIRED
                        ),
                        'Html' => array(
                            // Data is required
                            'Charset' => 'UTF-8',
                            'Data' => $this->body, // REQUIRED
                        ),
                    ),
                ),
                'ReplyToAddresses' => $this->replyToAddresses,
                //TODO: add below params
//            'ReturnPath' => 'string',
//            'SourceArn' => 'string',
//            'ReturnPathArn' => 'string',
            ));
        return $result;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return mixed
     */
    public function getToAddresses()
    {
        return $this->toAddresses;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getCcAddresses()
    {
        return $this->ccAddresses;
    }

    /**
     * @return array
     */
    public function getBccAddresses()
    {
        return $this->bccAddresses;
    }

}
