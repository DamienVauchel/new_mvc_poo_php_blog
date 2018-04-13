<?php

namespace Framework\Security;


class Token
{
    public static function create()
    {
        $token = bin2hex(random_bytes(32));
        return $token;
    }
}