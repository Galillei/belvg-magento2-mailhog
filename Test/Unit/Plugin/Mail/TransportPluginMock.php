<?php
/**
 * Created by PhpStorm.
 * User: artsemmiklashevich
 * Date: 6/23/18
 * Time: 8:55 AM
 */

namespace BelVG\Mailhog\Test\Unit\Plugin\Mail;


use BelVG\Mailhog\Plugin\Mail\TransportPlugin;

class TransportPluginMock extends TransportPlugin
{
    public function sendMessage($message)
    {

    }
}