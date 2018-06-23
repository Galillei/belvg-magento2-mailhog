<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 6/22/18
 * Time: 12:26 PM
 */

namespace BelVG\Mailhog\Test\Unit\Plugin\Mail;


use BelVG\Mailhog\Helper\Data;
use BelVG\Mailhog\Plugin\Mail\TransportPlugin;
use BelVG\Mailhog\Test\Unit\Plugin\Mail\TransportPluginMock;
use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class TransportPluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    protected function setUp()
    {
       $this->objectManager = new ObjectManager($this);
    }

    public function testAroundSendMessage()
    {
        $configMock  = $this->getMockBuilder(Data::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $configMock->expects(self::once())
                   ->method('getSmtpHost');
        $configMock->expects(self::once())
                   ->method('getSmtpPort');
        $configMock->expects(self::any())
                   ->method('isActive')
                   ->willReturn(true);
        $subject  = $this->getMockBuilder(TransportInterface::class)
                        ->setMethods(['getMessage', 'sendMessage'])
                        ->disableOriginalConstructor()
                        ->getMock();
        $mailMock  = $this->getMockBuilder(\Zend_Mail::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $subject->expects(self::once())
                ->method('getMessage')
                ->willReturn($mailMock);
        $that = $this;
        $procced = function() use ($that){
                $this->fail('This function shouldn\'t be invoke')    ;
        } ;
        $model = $this->objectManager->getObject(TransportPluginMock::class, ['dataConfig' => $configMock]);
        $model->aroundSendMessage($subject, $procced);
    }

    public function testAroundSendMessageDisable()
    {
        $configMock  = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->getMock();
        $configMock->expects(self::once())
            ->method('getSmtpHost');
        $configMock->expects(self::once())
            ->method('getSmtpPort');
        $configMock->expects(self::any())
            ->method('isActive')
            ->willReturn(false);
        $subject  = $this->getMockBuilder(TransportInterface::class)
            ->setMethods(['getMessage', 'sendMessage'])
            ->disableOriginalConstructor()
            ->getMock();
        $mailMock  = $this->getMockBuilder(\Zend_Mail::class)
            ->disableOriginalConstructor()
            ->getMock();
        $subject->expects(self::never())
            ->method('getMessage')
            ->willReturn($mailMock);
        $that = $this;
        $procced = function() use ($that){
            $this->isTrue('This function invoke!')    ;
        } ;
        $model = $this->objectManager->getObject(TransportPluginMock::class, ['dataConfig' => $configMock]);
        $model->aroundSendMessage($subject, $procced);
    }
}