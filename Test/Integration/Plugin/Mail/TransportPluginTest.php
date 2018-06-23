<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 6/19/18
 * Time: 4:21 PM
 */

namespace BelVG\Mailhog\Test\Integration\Plugin\Mail;


use BelVG\Mailhog\Plugin\Mail\TransportPlugin;
use Magento\Framework\Mail\Transport;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\Interception\PluginList;
use Magento\TestFramework\ObjectManager;

class TransportPluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    public function setUp()
    {
        /**
        * @var ObjectManager
        **/
        $this->objectManager = Bootstrap::getObjectManager();
    }

    public function testIsExists()
    {
        /**
         * @var PluginList $pluginList
         */
        $pluginList = $this->objectManager->create(PluginList::class);
        $config = $pluginList->get(\Magento\Framework\Mail\TransportInterface::class);
        $this->assertEquals(TransportPlugin::class, $config['mailhogbelvg']['instance']);
    }

    public function testExecute()
    {
        $config = $this->objectManager->get(\BelVG\Mailhog\Helper\Data::class);
        $mockPlugin  = $this->getMockBuilder(TransportPlugin::class)
                        ->setConstructorArgs([$config])
                        ->getMock();
        $mockPlugin->expects($this->any())
                    ->method('sendMessage')
                    ->with('message');
        $this->objectManager->addSharedInstance($mockPlugin, TransportPlugin::class);

        $magentoMail = $this->objectManager->create(\Magento\Framework\Mail\TransportInterface::class );
        $message  = $this->getMockBuilder(\Magento\Framework\Mail\TransportInterface::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $message->expects($this->any())
                ->method('sendMessage')
                ->willReturn('message');
        $magentoMail->sendMessage($message);

    }

}