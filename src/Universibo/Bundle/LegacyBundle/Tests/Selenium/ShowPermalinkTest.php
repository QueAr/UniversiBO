<?php
namespace Universibo\Bundle\LegacyBundle\Tests\Selenium;

class ShowPermalinkTest extends UniversiBOSeleniumTestCase
{
    public function testSimple()
    {
        $this->openPrefix('/permalink/1');
        $this->assertSentences(array(
                'Test news',
                'Test content',
                '5/03/2013 - 20:29'
        ));
    }

    /**
     * @ticket 251
     */
    public function testExpiredNewsShouldNotBeFound()
    {
        $this->openPrefix('/permalink/2');
        $this->assertSentence('Not Found');
    }
}
