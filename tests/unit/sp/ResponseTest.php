<?php


namespace tests\unit\sp;

use Codeception\Scenario;
use Codeception\Test\Unit;
use craft\elements\User;
use flipbox\saml\core\exceptions\InvalidMessage;
use flipbox\saml\core\helpers\ClaimTypes;
use flipbox\saml\sp\models\Settings;
use flipbox\saml\sp\records\ProviderRecord;
use flipbox\saml\sp\Saml;
use SAML2\Assertion;
use SAML2\EncryptedAssertion;
use Step\Unit\Common\Metadata;
use Step\Unit\Common\Response;
use Step\Unit\Common\SamlPlugin;

class ResponseTest extends Unit
{

    /**
     * @var Saml
     */
    private $module;

    /**
     * @var Metadata
     */
    private $metadataFactory;
    /**
     * @var SamlPlugin
     */
    private $pluginHelper;

    /**
     * @var Response
     */
    private $responseFactory;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     * phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
     */
    protected function _before()
    {
        $this->module = new Saml('saml-sp');

        $scenario = new Scenario($this);

        $this->metadataFactory = new Metadata($this->module, $scenario);
        $this->pluginHelper = new SamlPlugin($this->module, $scenario);
        $this->responseFactory = new Response(
            $this->module,
            $this->metadataFactory,
            $scenario
        );
    }

    private function getIdp()
    {
        $idp = $this->metadataFactory->createTheirProviderWithSigningKey($this->module);
        $this->responseFactory->setAttributeMapping(
            $idp
        );
        return $idp;
    }

    private function getSp()
    {
        return $this->metadataFactory->createMyProviderWithKey($this->module);
    }

    private function getResponse(ProviderRecord $idp, ProviderRecord $sp, $encrypted = false)
    {
        return $this->responseFactory->createSuccessfulResponse(
            $idp,
            $sp,
            $encrypted
        );
    }

    private function getUser(){
        return new User([
            'firstName' => 'Damien',
            'lastName' => 'Smrt',
            'email' => 'damien@flipboxdigital.com',
            'username' => 'damien@flipboxdigital.com',
        ]);
    }
    protected static function getMethod(string $class, string $name) {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }


    public function testUserSync()
    {
        $this->pluginHelper->installIfNeeded();
        $this->module->loadSaml2Container();

        $idp = $this->getIdp();
        $sp = $this->getSp();

        $response = $this->getResponse(
            $idp,
            $sp
        );

        $user = $this->getUser();

        $foo = self::getMethod(\flipbox\saml\sp\services\login\User::class, 'construct');
        $obj = new \flipbox\saml\sp\services\login\User();
        
        $foo->invokeArgs($obj,
            [
                $user,
                $response,
                $idp,
                $sp,
                $this->module->getSettings()
            ]
        );


        $this->assertSame(
            $user->firstName,
            $this->responseFactory->getFirstName()
        );

        $this->assertSame(
            $user->lastName,
            $this->responseFactory->getLastName()
        );

        $this->assertSame(
            $user->email,
            $this->responseFactory->getEmail()
        );

//        $identity =
//            Saml::getInstance()->getProviderIdentity()->getByUserAndResponse(
//            $user,
//            $response,
//            $sp,
//            $idp
//        );


//        // TODO fix this
//        $this->expectException(UserException::class);
//        Saml::getInstance()->getLogin()->byIdentity($identity);

    }
    public function testGetByUserAndResponse(){
        $this->pluginHelper->installIfNeeded();
        $this->module->loadSaml2Container();

        $idp = $this->getIdp();
        $sp = $this->getSp();

        $response = $this->getResponse(
            $idp,
            $sp
        );
        Saml::getInstance()->getProviderIdentity()->getByUserAndResponse(
            $this->getUser(),
            $response,
            $sp,
            $idp
        );
    }

    public function testEmptyAssertion()
    {
        $idp = $this->getIdp();
        $sp = $this->getSp();

        $response = $this->getResponse(
            $idp,
            $sp,
        );
        $response->setAssertions([]);

        $this->expectException(InvalidMessage::class);

        Saml::getInstance()->getUser()->getFirstAssertion(
            $response,
            $sp
        );
    }

    public function testEncryptedResponse()
    {
        $idp = $this->getIdp();
        $sp = $this->getSp();

        $response = $this->getResponse(
            $idp,
            $sp,
            true
        );

        $assertion = $this->module->getUser()->getFirstAssertion(
            $response,
            $sp
        );

        $this->assertInstanceOf(
            Assertion::class,
            $assertion
        );
    }

    public function testGetByResponse()
    {

        $idp = $this->getIdp();
        $sp = $this->getSp();

        $response = $this->getResponse(
            $idp,
            $sp
        );

//        \Craft::$app->elements->saveElement(new User([
//            'email'=>$this->responseFactory->getEmail(),
//            'username'=>$this->responseFactory->getEmail(),
//            'firstName'=>$this->responseFactory->getFirstName(),
//            'lastName'=>$this->responseFactory->getLastName(),
//        ]));

        $settings = new Settings();

        $user = Saml::getInstance()->getUser()->getByResponse(
            $response,
            $sp,
            $idp,
            $settings
        );

        $this->assertInstanceOf(
            User::class,
            $user
        );

        $response->getAssertions()[0]->setNameId(null);
        $this->expectException(InvalidMessage::class);
        Saml::getInstance()->getUser()->getByResponse(
            $response,
            $sp,
            $idp,
            $settings
        );

        $settings->nameIdAttributeOverride = ClaimTypes::EMAIL_ADDRESS;
        Saml::getInstance()->getUser()->getByResponse(
            $response,
            $sp,
            $idp,
            $settings
        );
    }
    public function testAssertionTrait(){

        $idp = $this->getIdp();
        $sp = $this->getSp();

        $response = $this->getResponse(
            $idp,
            $sp
        );

        $assertion = Saml::getInstance()->getUser()->getFirstAssertion(
            $response,
            $sp
        );

        $this->assertInstanceOf(
            Assertion::class,
            $assertion
        );

        $response->setAssertions([]);

        $assertion = Saml::getInstance()->getUser()->getFirstAssertion(
            $response,
            $sp
        );

    }

    public function testUserGroups(){
        $user = $this->getUser();

        $identityProvider = $this->getIdp();
        $serviceProvider = $this->getSp();

        $response = $this->getResponse(
            $identityProvider,
            $serviceProvider
        );

//        \Craft::$app->elements->saveElement($user);

        $settings = new Settings();

        Saml::getInstance()->getUserGroups()->sync(
            $user,
            $response,
            $serviceProvider,
            $settings
        );
    }
}