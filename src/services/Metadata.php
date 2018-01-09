<?php
/**
 * Created by PhpStorm.
 * User: dsmrt
 * Date: 1/9/18
 * Time: 9:48 AM
 */

namespace flipbox\saml\sp\services;


use craft\base\Component;
use craft\helpers\UrlHelper;
use flipbox\saml\sp\exceptions\InvalidMetadata;
use LightSaml\Model\Metadata\EntityDescriptor;
use LightSaml\Model\Metadata\SpSsoDescriptor;
use LightSaml\Model\Metadata\KeyDescriptor;
use LightSaml\Credential\X509Certificate;
use LightSaml\Model\Metadata\AssertionConsumerService;
use LightSaml\SamlConstants;
use flipbox\saml\sp\Saml;


class Metadata extends Component
{

    /**
     *
     */
    const LOGIN_LOCATION = 'saml-sp/login';

    /**
     * @var array
     */
    protected $supportedBindings = [
        SamlConstants::BINDING_SAML2_HTTP_REDIRECT,
        SamlConstants::BINDING_SAML2_HTTP_POST,
    ];

    /**
     * @return EntityDescriptor
     */
    public function create()
    {

        $spRedirectDescriptor = $this->createRedirectDescriptor();
        $spPostDescriptor = $this->createPostDescriptor();

        $entityDescriptor = new EntityDescriptor(
            Saml::getInstance()->getSettings()->getEntityId(),
            [
                $spRedirectDescriptor,
                $spPostDescriptor,

            ]);

        return $entityDescriptor;
    }

    /**
     * @return SpSsoDescriptor
     */
    public function createRedirectDescriptor()
    {
        return $this->createDescriptor(SamlConstants::BINDING_SAML2_HTTP_REDIRECT);
    }

    /**
     * @return SpSsoDescriptor
     */
    public function createPostDescriptor()
    {
        return $this->createDescriptor(SamlConstants::BINDING_SAML2_HTTP_POST);
    }

    /**
     * @param $binding
     * @return SpSsoDescriptor
     * @throws InvalidMetadata
     */
    public function createDescriptor($binding)
    {
        if (!in_array($binding, $this->supportedBindings))
        {
           throw new InvalidMetadata(
               sprintf("Binding is not supported: %s", $binding)
           );
        }

        $spDescriptor = (new SpSsoDescriptor())
            ->setWantAssertionsSigned(Saml::getInstance()->getSettings()->signAssertions);

        $acs = new AssertionConsumerService();
        $acs->setBinding($binding)
            ->setLocation(UrlHelper::actionUrl(static::LOGIN_LOCATION));
        $spDescriptor->addAssertionConsumerService($acs);

        $this->setEncrypt($spDescriptor);
        $this->setSign($spDescriptor);

        return $spDescriptor;

    }

    /**
     * @param SpSsoDescriptor $spSsoDescriptor
     */
    public function setSign(SpSsoDescriptor $spSsoDescriptor)
    {
        if (Saml::getInstance()->getSettings()->signAssertions) {

            $spSsoDescriptor->addKeyDescriptor(
                $keyDescriptor = (new KeyDescriptor())
                    ->setUse(KeyDescriptor::USE_SIGNING)
                    ->setCertificate(X509Certificate::fromFile(Saml::getInstance()->getSettings()->certPath))
            );
        }

    }

    /**
     * @param SpSsoDescriptor $spSsoDescriptor
     */
    public function setEncrypt(SpSsoDescriptor $spSsoDescriptor)
    {

        if (Saml::getInstance()->getSettings()->encryptAssertions) {
            $spSsoDescriptor->addKeyDescriptor(
                $keyDescriptor = (new KeyDescriptor())
                    ->setUse(KeyDescriptor::USE_ENCRYPTION)
                    ->setCertificate(X509Certificate::fromFile(Saml::getInstance()->getSettings()->certPath))
            );

        }


    }

}