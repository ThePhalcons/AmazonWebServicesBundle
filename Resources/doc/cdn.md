# How to use Amazon S3 and Amazon CloudFront as a CDN ?

Here is a step-by step tutorial on how to use Amazon CloudFront and Amazon S3 as
a CDN for Symfony2, thanks to the AmazonWebServicesBundle and the AWS PHP SDK.

It probably goes beyond the specificities of Symfony2.

We will assume you have a website called acme.com, that runs with Symfony2. The 
configuration file paths are the ones that you could have under MacOS X with MAMP.

## Development server configuration

### Some helpers

For testing purposes, we simulate the behavior of the production website the following way :

* on development machines :
 * the URL of the project must be `http://local.acme.com`
 * and all the assets will be accessible through `http://localcdn.acme.com`
* on production servers :
 * the URL of the project can be whatever you want.
 * the CDN will be hosted on Amazon S3, and accessible through `http://cdn.acme.com`

Let's first try to make it work locally : append these lines to your `hosts`: 

```
sudo nano /private/etc/hosts
```

```
127.0.0.1       local.acme.com
127.0.0.1       localcdn.acme.com
```

Then, update the Virtual Hosts of your local server in order to handle these calls :

```
sudo nano /Applications/MAMP/conf/apache/httpd.conf 
```

```
<VirtualHost *>
   DocumentRoot "/Applications/MAMP/htdocs/Acme/web"
   ServerName local.acme.com
</VirtualHost>

<VirtualHost *>
   DocumentRoot "/Applications/MAMP/htdocs/AcmeCDN/"
   ServerName localcdn.acme.com
</VirtualHost>
```

Restart your local server to apply changes. Check you are able to see the local 
website and the CDN (empty) page in your browser.

Let's now switch to Symfony.

### Templating vs Assetic

There are 2 different things that need to be distinguished in Symfony2 : 

* The templating engine : handles the rendering or web pages, and, as matter of 
fact, writes every URL, especially the ones of the assets.
* The AsseticBundle : his goal is to compress/merge/optimize assets. He is not 
the one that writes URL in templates, but he decides where to store these optimized 
assets.

We thus have to configure both of them.

### Templating engine configuration

The configuration of the templating engine is made in the `config.yml` file. 
Provided the templating engine is part of the Symfony2 framework, we have to 
configure it under the `framework.templating` path.

Everytime a helper method will be called, Symfony has to append to the url a given 
domain. As a default, Symfony assumes that the assets are stored on the server 
itself. Thus, this prefix is simply `/`. But, because we use a CDN, we need to 
specify it here.

```
// app/config/config_dev.yml
framework:
    templating:
        assets_base_urls:
            http:             [%cdn_url_dev%]

// app/config/parameters.ini
cdn_url_dev= "http://localcdn.acme.com/web"
```

We now need to transfer our assets to the CDN (this syntax I quite hairy, I agree): 

```
php app/console assets:install /Applications/MAMP/htdocs/AcmeCDN/web --symlink

```

We can load `http://local.acme.com` to check that the assets have correctly 
been migrated.

See also : [Configuration reference](http://symfony.com/doc/2.0/reference/configuration/framework.html).

### Assetic Bundle configuration

We now need to configure assetic so it also use the CDN. Assetic does three things : 

* he searches assets to optimize from the `read_from` directory, 
* deals with them, 
* and eventually writes them in the `write_to` directory. 

As a default, these two values are set to  `%kernel.root_dir%/../web`, directly 
in the same server as the application. We can now change these values to the CDN :

```
// app/config/config_dev.yml
assetic:
    read_from:        %cdn_path_dev%
    write_to:          %cdn_path_dev%

// app/config/parameters.ini
cdn_path_dev                    = "/Applications/MAMP/htdocs/AcmeCDN/web"
```

In the dev environnement, we need to specify the disk path, so the application 
can write directly in the directory. Eventually, we can dump the assets to the CDN :

```
php app/console assetic:dump
```

If you test your local pages in your browser, you will see that the assets have
correctly moved.

## Setting up Amazon S3 and CloudFront as a CDN

Amazon S3 is simply a storage system. In order to build an actual CDN, we need to 
use CloudFront, that replicates the content stored on Amazon S3 to various locations 
for maximum speed. 

### Create S3 bucket

First, we need to create a bucket that will hold the content that will be broadcasted on the CDN. 

* Log in the **AWS Console**.
* Open the **S3** tab.
* Click **Create new bucket** (name example : _cdn-acme_).
* Click **Upload** and choose a test file `test.png`, and be sure to :
 * click **Set details**, tick **Reduced Redundancy Storage**.
 * click **Set Permissions** and **Make everything public**.

### Create a CloudFront distribution

* Then, go on the **CloudFront** tab.
* Click **Create distribution**
* Select the bucket you just created
* Setup the CNAME to _cdn.acme.com_
* Review changes and click **Create distribution**
* Wait a bit, and copy paste the domain name (ex : _42jhdsqhdj.cloudfront.net_) 
to your browser, and append the test file name (ex : _test.png_). Check that you 
see your test file.

### Setup CNAMEs

You finally need to create the CNAME that will redirect _http://cdn.acme.com_ 
to our distribution.

* Copy the domain name that was just generated.
* Go to the **Route 53** tab.
* Select the _acme.com_ zone.
* Create/update a CNAME with name _http://cdn.acme.com_ and redirect it to 
the CloudFront domaon Name.
* Check that _http://cdn.acme.com/test.png_ works fine.

References :

- [CloudFront homepage](http://aws.amazon.com/cloudfront/)
- [Getting started tutorial](http://docs.amazonwebservices.com/AmazonCloudFront/latest/GettingStartedGuide/StartingCloudFront.html)
- [S3 homepage](http://aws.amazon.com/s3/)

## Production server configuration

Now we need to setup the configuration for the Product server : 

```
// app/config/config_prod.yml
framework:
    templating:
        assets_base_urls:
            http:             [%cdn_url_prod%]

// app/config/config_prod.yml
assetic:
    read_from:        %cdn_path_prod%
    write_to:          %cdn_path_prod%

// app/config/parameters.ini
cdn_url_prod= "http://cdn.acme.com/web"
cdn_path_prod= "s3://cdn-acme"
```

NB : no need to be more accurate for the bucket path, we will use a special service 
to provide the key/secret (see below).

## Dump assets to the S3 bucket

At this point, if we try to simply run the `assetic:dump` command, it will output 
an error : `Unable to find the wrapper "s3" - did you forget to enable it when you 
configured PHP?`. This is due to the fact that PHP does not know natively how to 
handle the `s3` protocol. 

In order to teach him to do so, there are several solutions. We could use the 
[Zend S3 Stream Wrapper](http://framework.zend.com/manual/en/zend.service.amazon.s3.html#zend.service.amazon.s3.streams) 
but it's quite overkill to load the entire Zend Framework just for that. 

A better thing to do is use the Amazon AWS PHP SDK, which (although it suffers some 
bugs), is integrated in Symfony thanks to the [AmazonWebServicesBundle](https://github.com/Cybernox/AmazonWebServicesBundle). 

Pittifully, simply installing the Bundle is not enough : at no point we load the 
S3 service when calling the Assetic command. We need to force the registration 
of the StreamWrapper some way.

You can register the stream wrapper when the Kernel boot by editing your AppKernel.php
Simply copy paste that code in it:

```
public function boot()
{
     \Aws\S3\S3Client::factory()->registerStreamWrapper();
     return parent::boot();
}
```

Now we can give it one more try : run `php app/console assetic:dump`. And one more 
bug : `Unable to create directory s3:/...`. According to [this link](https://github.com/symfony/AsseticBundle/issues/37), 
it seems that "S3 doesn't really have directories, it only pretends to.".

An extremely quick and dirty way to solve that is to return systematically true 
in the `mkdir` method of the StreamWrapper :

```
// vendor/aws-sdk-for-php/extensions/s3streamwrapper.class.php

public function mkdir($path, $mode, $options)
{
    /** **/
    return true;
    // return $response->isOK();
}
```

And then, one more try :

```
php app/console assetic:dump
```

It works ! But there is still a couple of issues : 

- As a default, none of the assets is set to be public. We need to run another script to do so.
- Similarly, none of them is stored in Reduced Redundancy mode. Which you may want.

References :

- [StackOverflow question](http://stackoverflow.com/questions/8163717/dump-symfony2-assets-to-amazon-s3)
- [Initial PR on Symfony](https://github.com/symfony/symfony/pull/108)
- [Assetic presentation](http://www.slideshare.net/kriswallsmith/assetic-symfony-live-paris) (see slide 72)

## Optimize security

