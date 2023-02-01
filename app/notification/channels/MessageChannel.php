<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 01.02.2023
 * Time: 14:51
 */

namespace App\notification\channels;


use App\notification\exceptions\InvalidChannelException;

class MessageChannel
{

    protected $availableChannels = [
        'email_confirmation' => EmailChannel::class,
        'mobile_confirmation' => SMSChannel::class,
    ];

    public function getChannel(string $type) : IMessageChannel
    {
        if( !isset($this->availableChannels[$type]) )
        {
            throw new InvalidChannelException();
        }

        return new ($this->availableChannels[$type]);
    }

}
