<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 6/18/18
 * Time: 11:52 AM
 */

namespace BelVG\Mailhog\Helper;


use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const ENABLE = 'system/belvg_mailhog/enabled';
    const SMTP_HOST = 'system/belvg_mailhog/host';
    const PORT = 'system/belvg_mailhog/port';

    public function isActive()
    {
       return $this->scopeConfig->getValue(self::ENABLE);
    }

    public function getSmtpHost()
    {
        return $this->scopeConfig->getValue(self::SMTP_HOST);
    }

    public function getSmtpPort()
    {
        return $this->scopeConfig->getValue(self::PORT);
    }


}