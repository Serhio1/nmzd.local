<?php

namespace App\Core;

class Router
{

    public function redirect($url, $data=array())
    {
        $_SESSION['redirectData'] = $data;
        header('location: '.'/'.$url);
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
