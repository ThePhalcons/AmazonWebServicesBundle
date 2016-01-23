# Amazon Web Services Bundle - TODO#

1. Refactor aws-sdk-for-php (or find what we can pass in during instantiation to circumvent) so the config.inc.php file presence issue isn't an issue

2. Integrate the cloudfusion AmazonPAS functionality

3. update documentation

4. Using credentials from environment variables, credentials profiles or env provider

```

 
    $this->sdk = new Sdk(
             array(
                 'region'  => $this->getRegion(),
                 // use specific aws sdk php version or latest version if not defined
                 'version' => ($this->getVersion() != '' ) ? $this->getVersion() : 'latest',
                'credentials' => CredentialProvider::env()
             )
         );

    //instead of 

  $credentials = new Credentials($this->getKey(), $this->getSecret());

    // it's more bette to use Credentials provide.
    // possibility to use memorize function which will cache your credentials
    // and optimize performances

    $this->sdk = new Sdk(
        array(
            'region'  => $this->getRegion(),
            // use specific aws sdk php version or latest version if not defined
            'version' => ($this->getVersion() != '' ) ? $this->getVersion() : 'latest',
            'credentials' => $credentials
        )
    );

```

