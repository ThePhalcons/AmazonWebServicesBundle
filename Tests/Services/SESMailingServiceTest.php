<?php
/**
 * Created by PhpStorm.
 * User: elmehdi
 * Date: 23/01/16
 * Time: 03:42
 */

/**
 * Class SESMailingServiceTest
 *
 */
class SESMailingServiceTest extends PHPUnit_Framework_TestCase
{

    /**
     * test if SES service exists
     */
    public function testSESInjection()
    {
        $client = $this->createClient();
        $ses = $client->getContainer()->get('amazon_SES');
        assert($ses !== null, 'SES is not defined');
    }

    /**
     * tests if verified email address exist in global config
     */
    public function testMailingServiceInjection()
    {
        $client = $this->createClient();
        $mailer = $client->getContainer()->get('ws.service.mailing');
        assert($mailer !== null, 'Mailing Service injection is not working');
        assert($mailer instanceof MailingService, 'given Object is not an instance of MailingService');
    }

//    public function testSendMail()
//    {
//        $client = $this->createClient();
//        /**@var $mailer MailingService */
//        $mailer = $client->getContainer()->get('ws.service.mailing');
//        $mailer->setSubject('Drivy UNIT TEST')
//            ->addToAddress('mouddene@gmail.com')
//            ->setMessage('UNIT TEST is working');
//        $result = $mailer->sendEmail();
//
//        var_dump($result);
//        assert(true === true, "todo");
//    }
//
}
