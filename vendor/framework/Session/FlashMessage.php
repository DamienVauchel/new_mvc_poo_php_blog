<?php

namespace Framework\Session;


/**
 * Class FlashMessage
 * @package Framework\Session
 */
class FlashMessage
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     *
     */
    const KEY = 'flash-msg';

    /**
     * FlashMessage constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param $message
     * @param $type
     */
    public function setMessage($message, $type)
    {
        $this->session->set(self::KEY, array(
            'message'       => $message,
            'type'          => $type
        ));
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $flash = $this->session->get(self::KEY);
        $this->session->delete(self::KEY);

        return $flash;
    }
}