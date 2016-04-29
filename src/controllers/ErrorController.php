<?php
/**
 * Created by PhpStorm.
 * User: Darren Cosgrave
 * Date: 27/04/2016
 * Time: 15:25
 */
namespace Itb\Controller;

use Silex\Application;

/**
 * Class file used for errors
 * Class ErrorController
 * @package Itb\Controller
 */
class ErrorController
{
    /**
     * Method to handle uncaught errors
     * @param Application $app
     * @param $code
     * @return mixed
     */
    public function errorAction(Application $app, $code)
    {
        // default - assume a 404 error
        $argsArray = [];
        $templateName = '404';

        if (404 != $code) {
            $argsArray = [
                'message' => 'sorry - an unknown error occurred'
            ];
            $templateName = 'error';
        }

        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
