<?php

namespace App\Core;

class Router
{

    /**
     * @param $url
     * @param array $data - POST data to be send to requested page.
     */
    public function redirect($uri, $getParams=array(), $data=array())
    {
        $_SESSION['redirectData'] = $data;
        $url = static::buildUrl($uri, $getParams);
        header('location: ' . $url);
        exit();
    }

    /**
     * Builds absolute url address.
     *
     * Example of usage: url('/nmkd/input', array($id));.
     *
     * @param string $uri
     * @param array $params
     * @return string
     */
    public static function buildUrl($uri, $params = array())
    {
        $strParams = '';
        if (!empty($params)) {
            $strParams .= '?';
            foreach ($params as $param => $val) {
                $strParams .= $param . '=' . $val . '&';
            }
            $strParams = substr($strParams, 0, -1);
        }

        $protocol = Container::get('params')->getProtocol();
        $baseUrl = Container::get('params')->getBaseUrl();
        return $protocol . $baseUrl . $uri . $strParams;
    }

}
