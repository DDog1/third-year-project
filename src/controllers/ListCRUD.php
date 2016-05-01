<?php
/**
 * Created by PhpStorm.
 * User: Darren Cosgrave
 * Date: 30/04/2016
 * Time: 23:53
 */

namespace Itb\Controller;

use Itb\Model\Action;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListCRUD
 * @package Itb\Controller
 */
class ListCRUD
{
    /**
     * This method will return an array of lists from the database
     * @return array
     */
    public function displayActions()
    {
        $actions = Action::getAll();

        return $actions;
    }

    /**
     * This method will display the admin add function,
     * will give error if not logged in as admin
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addAction(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role']>=1 && $_SESSION['role']<=2) {
                $actions = $this->displayActions();
                $argsArray = [
                    'actions' => $actions,
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'addAction';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }
        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again :)',
            'errorType' => 'notLoggedIn',// Type of error used to give the right link back
        ];

        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Lets the admins add a new list to the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processAddAction(Request $request, Application $app)
    {
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $implementorid = filter_input(INPUT_POST, 'implementorid', FILTER_SANITIZE_STRING);
        $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

        if ($description!=null) {
            if ($implementorid!=null) {
                if ($deadline!=null) {
                    if ($status!=null) {
                        //Action::addNewActionToDatabase($description, $implementorid, $deadline, $status);
                        $action = new Action();
                        $action->setDescription($description);
                        $action->setImplementorid($implementorid);
                        $action->setDeadline($deadline);
                        $action->setStatus($status);
                        Action::insert($action);

                        $argsArray = [
                            'message' => "List has been added",// Success message
                            'nav' => $_SESSION["role"],
                            'successType' => "add list"
                        ];

                        $templateName = 'process';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    } else {
                        print "<p>Status was not filled in!</p>";
                        $argsArray = [
                            'message' => "Error - Status was not filled in",// Error message
                            'message2' => 'Please trying again :)',
                            'errorType' => 'addAction',// Type of error used to give the right link back
                            'nav' => $_SESSION["role"]
                        ];

                        $templateName = 'error';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    }
                } else {
                    $argsArray = [
                        'message' => "Error - Deadline was not filled in",// Error message
                        'message2' => 'Please trying again :)',
                        'errorType' => 'addAction',// Type of error used to give the right link back
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            } else {
                $argsArray = [
                    'message' => "Error - Implementor Id was not filled in",// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'addAction',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Description was not filled in",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'addAction',// Type of error used to give the right link back
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * This method will display the admin remove function,
     * will give error if not logged in as admin
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function removeAction(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] >= 1 && $_SESSION['role'] <= 2) {
                $actions = $this->displayActions();
                $argsArray = [
                    'actions' => $actions,
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'removeAction';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }
        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again :)',
            'errorType' => 'notLoggedIn',// Type of error used to give the right link back
        ];

        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Lets the admins remove a list from the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processRemoveAction(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        if ($id!=null) {
            $isOnDatabase = Action::getOneById($id);
            if ($isOnDatabase!=null) {
                $list = new Action();
                $list->setId($id);
                Action::delete($id);

                $argsArray = [
                    'message' => "List has been removed",// Success message
                    'nav' => $_SESSION["role"],
                    'successType' => "remove list"
                ];

                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            } else {
                $argsArray = [
                    'message' => "Error - There was no list with Id : ".$id,// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'removeAction',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Id was not filled in",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'removeAction',// Type of error used to give the right link back
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * This method will display the admin update function,
     * will give error if not logged in as admin
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function updateAction(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] >= 1 && $_SESSION['role'] <= 2) {
                $actions = $this->displayActions();
                $argsArray = [
                    'actions' => $actions,
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'updateAction';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }
        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again :)',
            'errorType' => 'notLoggedIn',// Type of error used to give the right link back
        ];

        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Lets the admins update a list info
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processUpdateAction(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $implementorid = filter_input(INPUT_POST, 'implementorid', FILTER_SANITIZE_STRING);
        $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

        if ($id!=null) {
            $isOnDatabase = Action::getOneById($id);
            if ($isOnDatabase!=null) {
                $list = new Action();
                $list->setId($id);
                $list->setDescription($description);
                $list->setImplementorid($implementorid);
                $list->setDeadline($deadline);
                $list->setStatus($status);
                Action::update($list);

                $argsArray = [
                    'message' => "List has been updated",// Success message
                    'nav' => $_SESSION["role"],
                    'successType' => "update list"
                ];

                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            } else {
                $argsArray = [
                    'message' => "Error - There was no list with Id : ".$id,// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'updateAction',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Id was not filled in",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'updateAction',// Type of error used to give the right link back
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }
}
