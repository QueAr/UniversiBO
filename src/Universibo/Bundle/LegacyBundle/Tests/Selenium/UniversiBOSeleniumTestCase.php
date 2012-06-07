<?php
namespace Universibo\Bundle\LegacyBundle\Tests\Selenium;

/**
 * Parent class for all Selenium tests in UniversiBO
 * @author Davide Bellettini <davide.bellettini@gmail.com>
 */
use Universibo\Bundle\LegacyBundle\Tests\TestConstants;

abstract class UniversiBOSeleniumTestCase extends \PHPUnit_Extensions_SeleniumTestCase
{
    protected function setUp()
    {
        $this->setBrowser('*firefox');
        $this->setBrowserUrl('http://www.universibo.local/');
    }

    protected function login($username, $password = null)
    {
        if (is_null($password)) {
            $password = TestConstants::DUMMY_PASSWORD;
        }

        $this->deleteAllVisibleCookies();
        $this->open('/');
        $this->type('id=f1_username', $username);
        $this->type('id=f1_password', $password);
        $this->clickAndWait('name=f1_submit');

        if ($this->isTextPresent('Informativa sulla privacy')) {
            $this->clickAndWait('name=action');
        }

        self::assertTrue($this->isTextPresent('Benvenuto '.$username), 'Welcome text must be present');
    }

    protected function logout()
    {
        $this->clickAndWait('name=f2_submit');
        self::assertTrue($this->isTextPresent('Registrazione studenti'));
        self::assertTrue($this->isTextPresent('Username smarrito'));
        self::assertTrue($this->isTextPresent('Password smarrita'));
        self::assertTrue($this->isTextPresent('I servizi personalizzati sono disponibili solo agli utenti che hanno effettuato il login'));
    }

    protected function openCommand($do, $params = '')
    {
        $this->open('/v2.php?do='.$do.$params);
        self::assertTrue(preg_match('/UniversiBO/', $this->getTitle()) !== false, 'UniversiBO should be present in title');
    }

    protected function assertSentence($sentence)
    {
        $this->assertSentences(array($sentence));
    }

    protected function assertSentences(array $sentences)
    {
        foreach ($sentences as $sentence) {
            self::assertTrue($this->isTextPresent($sentence), 'Text: "'.$sentence.'" should be present.');
        }
    }
}