<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;

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
            if (strpos($uri,'?') == false) {
                $strParams .= '?';
            } else {
                $strParams .= '&';
            }
            
            foreach ($params as $param => $val) {
                $strParams .= $param . '=' . $val . '&';
            }
            $strParams = substr($strParams, 0, -1);
        }

        $request = Request::createFromGlobals();
        $protocol = $request->server->get('REQUEST_SCHEME');
        $baseUrl = $request->server->get('SERVER_NAME');
        $doc_root = $request->server->get('DOCUMENT_ROOT');
        $full_path = $request->server->get('SCRIPT_FILENAME');
        $file = basename($request->server->get('SCRIPT_FILENAME'));
        $urlSlug = str_replace($file, '', str_replace($doc_root, '', $full_path));
        $uri = ltrim($uri, '/');

        return $protocol . '://' . $baseUrl . $urlSlug . $uri . $strParams;
    }

}
