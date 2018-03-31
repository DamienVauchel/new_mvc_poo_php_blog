<?php

namespace Framework\Session;


class FlashMessage
{
    private $session;

    const KEY = 'flash-msg';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function setMessage($message, $type)
    {
        $this->session->set(self::KEY, array(
            'message'       => $message,
            'type'          => $type
        ));
    }

    public function get()
    {
        $flash = $this->session->get(self::KEY);
        $this->session->delete(self::KEY);

        return $flash;
    }
}