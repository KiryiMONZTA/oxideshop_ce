<?php

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extension;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\IncludeWidgetLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\IncludeWidgetExtension;
use PHPUnit\Framework\TestCase;

class IncludeWidgetExtensionTest extends TestCase
{

    /**
     * @var IncludeWidgetExtension
     */
    protected $includeWidgetExtension;

    protected function setUp()
    {
        parent::setUp();
        $includeWidgetLogic = new IncludeWidgetLogic();
        $this->includeWidgetExtension = new IncludeWidgetExtension($includeWidgetLogic);
    }

    /**
     * @covers       \OxidEsales\EshopCommunity\Internal\Twig\Extensions\IncludeWidgetExtension::includeWidget
     */
    public function testIncludeWidget()
    {
        $widgetControl = $this->createMock(\OxidEsales\Eshop\Core\WidgetControl::class);
        $widgetControl->expects($this->any())->method("start")->will($this->returnValue('html'));
        \OxidEsales\Eshop\Core\Registry::set(\OxidEsales\Eshop\Core\WidgetControl::class, $widgetControl);

        $actual = $this->includeWidgetExtension->includeWidget(['cl' => 'oxwTagCloud', 'blShowTags' => 1]);
        $this->assertEquals('html', $actual);
    }

}
