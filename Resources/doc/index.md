# Amazon Web Services Bundle #

This is a Symfony 2 Bundle for interfacing with Amazon Web Services (AWS).

## AWS SDK for PHP ##

This bundle utilizes the [AWS SDK for PHP](http://github.com/amazonwebservices/aws-sdk-for-php) by loading the SDK and providing the means to instantiate the SDK's various web service objects, passing them back to you for direct use.

The AWS SDK for PHP is the the official Amazon-supported library for interfacing with with Amazon's Web Service offerings. As such, the bundle merely provides a means (via Dependency Injection) to get at the SDK's various web service objects. There is no additional functionality at present time.

Once objects have been created, you have full access to the SDK. Please see the [AWS SDK for PHP documentation](http://docs.amazonwebservices.com/AWSSDKforPHP/latest/) for a list of each service's API calls.

## Installation ##

1) Add the AWS SDK for PHP library and the Amazon Web Services Bundle to your project's deps file:

    [aws-sdk-for-php]
        git=http://github.com/amazonwebservices/aws-sdk-for-php.git
        version=1.4.7

    [AmazonWebServicesBundle]
        git=http://github.com/mbadolato/AmazonWebServicesBundle.git
        target=/bundles/Cybernox/AmazonWebServicesBundle

2) Add AmazonWebServicesBundle to your application kernel:

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Cybernox\AmazonWebServicesBundle\CybernoxAmazonWebServicesBundle(),
            // ...
        );
    }

3) Register the Cybernox namespace:

    // app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Cybernox'         => __DIR__.'/../vendor/bundles',
        // ...
    ));

4) Autoload the SDK by adding the following `require_once` statement to end of your `app/autoload.php` file:

    // app/autoload.php

    // Amazon Web Services SDK
    require_once __DIR__.'/../vendor/aws-sdk-for-php/sdk.class.php';

5) Run `bin/vendors install` to have Symfony download and install the packages

## Usage ##

Once installed, you simply need to request the appropriate service for the Amazon Web Service object you wish to use. The returned object will then allow you full access the the API for the requested service.

**Please see the [AWS SDK for PHP documentation](http://docs.amazonwebservices.com/AWSSDKforPHP/latest/) for a list of each service's API calls.**

In this example, we get an AmazonSQS object from the AWS SDK for PHP library by requesting the `aws_sqs` service. We then use that object to retrieve a message from an existing Amazon SQS queue.

```php

    // src/Acme/DemoBundle/Controller/YourController.php
    public function someAction()
    {
        // Get a AmazonSQS object
        $sqs = $this->container->get('aws_sqs');

        // Get a message from an existing queue
        $response = $sqs->receive_message($queueUrl);

        // Do stuff with the received message response object
        // ...
    }
```

### Available Services ###

The following services are available, each returning an object allowing access to the respective Amazon Web Service

_Please note, at this time, thorough testing has not been completed. Because this bundle merely creates object from the SDK and passes them though to you, there shouldn't be any issues. However, this message is here as warning, just in case. In the event that a bug exists within the bundle's service definitions (and not within the SDK itself), please let me know!_

<table>
  <tr>
    <th>Symfony Service Name</th>
    <th>AWS SDK for PHP Object</th>
    <th>Description</th>
  </tr>

  <tr>
    <td>aws_as</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonAS">AmazonAS</a></td>
    <td>Amazon Auto Scaling</td>
  </tr>

  <tr>
    <td>aws_cloud_formation</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonCloudFormation">AmazonCloudFormation</a></td>
    <td>Amazon Cloud Formation</td>
  </tr>

  <tr>
    <td>aws_cloud_front</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonCloudFront">AmazonCloudFront</a></td>
    <td>Amazon Cloud Front</td>
  </tr>

  <tr>
    <td>aws_cloud_watch</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonCloudWatch">AmazonCloudWatch</a></td>
    <td>Amazon Cloud Watch</td>
  </tr>

  <tr>
    <td>aws_ec2</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonEC2">AmazonEC2</a></td>
    <td>Amazon Elastic Compute Cloud (EC2)</td>
  </tr>

  <tr>
    <td>aws_elb</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonELB">AmazonELB</a></td>
    <td>Amazon Elastic Load Balancing</td>
  </tr>

  <tr>
    <td>aws_emr</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonEMR">AmazonEMR</a></td>
    <td>Amazon Elastic MapReduce</td>
  </tr>

  <tr>
    <td>aws_elasti_cache</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonElastiCache">AmazonElastiCache</a></td>
    <td>Amazon ElastiCache</td>
  </tr>

  <tr>
    <td>aws_elastic_beanstalk</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonElasticBeanstalk">AmazonElasticBeanstalk</a></td>
    <td>Amazon Elastic Beanstalk</td>
  </tr>

  <tr>
    <td>aws_iam</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonIAM">AmazonIAM</a></td>
    <td>Amazon Identity and Access Management</td>
  </tr>

  <tr>
    <td>aws_import_export</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonImportExport">AmazonImportExport</a></td>
    <td>Amazon Import/Export</td>
  </tr>

  <tr>
    <td>aws_rds</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonRDS">AmazonRDS</a></td>
    <td>Amazon Relational Database Service</td>
  </tr>

  <tr>
    <td>aws_s3</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonS3">AmazonS3</a></td>
    <td>Amazon Simple Storage Service (S3)</td>
  </tr>

  <tr>
    <td>aws_sdb</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonSDB">AmazonSDB</a></td>
    <td>Amazon SimpleDB</td>
  </tr>

  <tr>
    <td>aws_ses</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonSES">AmazonSES</a></td>
    <td>Amazon Simple Email Service</td>
  </tr>

  <tr>
    <td>aws_sns</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonSNS">AmazonSNS</a></td>
    <td>Amazon Simple Notification Service</td>
  </tr>

  <tr>
    <td>aws_sqs</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonSQS">AmazonSQS</a></td>
    <td>Amazon Simple Queue Service</td>
  </tr>

  <tr>
    <td>aws_sts</td>
    <td><a href="http://docs.amazonwebservices.com/AWSSDKforPHP/latest/#i=AmazonSTS">AmazonSTS</a></td>
    <td>Amazon Security Token Service</td>
  </tr>
</table>
