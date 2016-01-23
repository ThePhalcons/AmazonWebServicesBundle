Amazon Web Services Bundle
==========================

Notice
======

This bundle is now officially maintained. Special thanks to Mark Badolato [`mbadolato`](https://github.com/mbadolato)

[![Latest Stable Version](https://poser.pugx.org/cybernox/amazon-webservices-bundle/v/stable.png)](https://packagist.org/packages/cybernox/amazon-webservices-bundle)
[![Total Downloads](https://poser.pugx.org/cybernox/amazon-webservices-bundle/downloads.png)](https://packagist.org/packages/cybernox/amazon-webservices-bundle)


Overview
--------
This is a Symfony2 Bundle for interfacing with Amazon Web Services (AWS).

This bundle uses the latest [AWS SDK for PHP](http://github.com/amazonwebservices/aws-sdk-for-php) by loading the SDK, and enabling you to instantiate the SDK's various web service objects, passing them back to you for direct use in your Symfony2 application..

For installation, configuration, and usage details, please see [`Resources/doc/README.md`](https://github.com/ThePhalcons/AmazonWebServicesBundle/blob/master/Resources/doc/README.md)


## Resources

* [Get started] – For getting started usage information
* [Sample Project][sdk-sample] - A quick, sample project to help get you started
* [Issues][sdk-issues] – Report issues, submit pull requests, and get involved
  (see [Apache 2.0 License][sdk-license])

## Features

* Provides easy-to-use HTTP clients for all supported AWS
  [services][docs-services], [regions][docs-rande], and authentication
  protocols.
* Is built on [Guzzle][guzzle-docs], and utilizes many of its features,
  including persistent connections, asynchronous requests, middlewares, etc.
* Provides convenience features including easy result pagination via
  [Paginators][docs-paginators], [Waiters][docs-waiters], and simple
  [Result objects][docs-results].
* Provides a [multipart uploader tool][docs-s3-multipart] for Amazon S3 and
  Amazon Glacier that can be paused and resumed.
* Provides an [Amazon S3 Stream Wrapper][docs-streamwrapper], so that you can
  use PHP's native file handling functions to interact with your S3 buckets and
  objects like a local filesystem.
* Provides the [Amazon DynamoDB Session Handler][docs-ddbsh] for easily scaling
  sessions on a fast, NoSQL database.
* Automatically uses [IAM Instance Profile Credentials][aws-iam-credentials] on
  configured Amazon EC2 instances.



Example Use Cases
-----------------
1. Connect to, and manipulate, any of the available Amazon Web Services, such as EC2, Amazon S3, SQS, SES, Amazon DynamoDB, Amazon Glacier, etc.

2. Utilize Amazon S3 and CloudFront as a Content Delivery Network (CDN) for a Symfony 2 application. Please see the information, graciously provided by [adurieux](https://github.com/adurieux), in [`Resources/doc/cdn.md`](https://github.com/ThePhalcons/AmazonWebServicesBundle/blob/master/Resources/doc/cdn.md).

3. Score dates with Supermodels (This feature not yet implemented)

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

   [Get started]: <https://github.com/ThePhalcons/AmazonWebServicesBundle/blob/dev-master/Resources/doc/README.md>
