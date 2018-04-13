<?php

namespace Framework\Security;

use Framework\Session\Cookie;
use Framework\Session\Session;

class Ticket
{
    public static function create()
    {
        $ticket = session_id().microtime().rand(0, 999999999);
        $ticket = hash('sha512', $ticket);

        $cookie = new Cookie();
        $cookie->set('bl_ti', $ticket, time() + (60*20));

        $session = new Session();
        $session->set('bl_ti', $ticket);
    }
}