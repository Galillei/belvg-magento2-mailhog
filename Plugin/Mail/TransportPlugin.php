<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 6/16/18
 * Time: 10:52 PM
 */

namespace BelVG\Mailhog\Plugin\Mail;


use BelVG\Mailhog\Helper\Data;
use Magento\Framework\Mail\TransportInterface;

class TransportPlugin extends \Zend_Mail_Transport_Smtp
{
    /**
     * @var Data
     */
    private $dataConfig;

    public function aroundSendMessage(TransportInterface $subject, \Closure $proceed)
    {

        if ($this->dataConfig->isActive()) {
            $message = $subject->getMessage();
            try {
                $this->sendMessage($message);
            }catch (\Exception $e){
                throw $e;
            }
        } else {
            $proceed();
        }
    }

    /**
     * TransportPlugin constructor.
     * @param Data $dataConfig
     */
    public function __construct(Data $dataConfig)
    {

        $this->dataConfig = $dataConfig;
        $smtpHost = $this->dataConfig->getSmtpHost();
        $smtpPort = $this->dataConfig->getSmtpPort();
        parent::__construct($smtpHost, ['port' => $smtpPort]);
    }

    public function sendMessage($message)
    {
        parent::send($message);
    }
}