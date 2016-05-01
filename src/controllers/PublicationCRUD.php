<?php
/**
 * Created by PhpStorm.
 * User: Darren Cosgrave
 * Date: 30/04/2016
 * Time: 23:48
 */

namespace Itb\Controller;

use Itb\Model\Publication;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PublicationCRUD
 * @package Itb\Controller
 */
class PublicationCRUD
{
    /**
     * This method will return an array of publications from the database
     * @return array
     */
    public function displayPublications()
    {
        $publications = Publication::getAll();

        return $publications;
    }


    /**
     * This method will display the admin add function,
     * will give error if not logged in as admin
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addPublication(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] >= 1 && $_SESSION['role'] <= 2) {
                $publications = $this->displayPublications();
                $argsArray = [
                    'publications' => $publications,
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'addPublication';
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
     * Lets the admins add a new publication to the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processAddPublication(Request $request, Application $app)
    {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $authorId = filter_input(INPUT_POST, 'authorId', FILTER_SANITIZE_STRING);
        $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);

        if ($title != null) {
            if ($authorId != null) {
                if ($url != null) {
                    $publication = new Publication();
                    $publication->setUrl($url);
                    $publication->setTitle($title);
                    $publication->setAuthorId($authorId);
                    Publication::insert($publication);

                    $argsArray = [
                        'message' => "Publication has been added to the database :)",// Success message
                        'nav' => $_SESSION["role"],
                        'successType' => "add Publication"
                    ];

                    $templateName = 'process';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                } else {
                    $argsArray = [
                        'message' => "Error - URL was not filled in",// Error message
                        'message2' => 'Please trying again :)',
                        'errorType' => 'addPublication',// Type of error used to give the right link back
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            } else {
                $argsArray = [
                    'message' => "Error - AuthorId was not filled in",// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'addPublication',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Title was not filled in",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'addPublication',// Type of error used to give the right link back
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
    public function removePublication(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] >= 1 && $_SESSION['role'] <= 2) {
                $publications = $this->displayPublications();
                $argsArray = [
                    'publications' => $publications,
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'removePublication';
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
     * Lets the admins remove a publication from the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processRemovePublication(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        if ($id!=null) {
            $isOnDatabase = Publication::getOneById($id);
            if ($isOnDatabase!=null) {
                Publication::delete($id);
                $argsArray = [
                    'message' => "Publication has been removed",// Success message
                    'nav' => $_SESSION["role"],
                    'successType' => "remove Publication"
                ];

                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            } else {
                $argsArray = [
                    'message' => "Error - There was no list with Id : ".$id,// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'removePublication',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Id was not filled in",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'removePublication',// Type of error used to give the right link back
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
    public function updatePublication(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] >= 1 && $_SESSION['role'] <= 2) {
                $publications = $this->displayPublications();
                $argsArray = [
                    'publications' => $publications,
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'updatePublication';
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
     * Lets the admins update a users info
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processUpdatePublication(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $authorId = filter_input(INPUT_POST, 'authorId', FILTER_SANITIZE_STRING);
        $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);

        if ($id!=null) {
            if ($title!=null) {
                if ($authorId!=null) {
                    if ($url!=null) {
                        $isOnDatabase = Publication::getOneById($id);
                        if ($isOnDatabase != null) {
                            $publication = new Publication();
                            $publication->setId($id);
                            $publication->setTitle($title);
                            $publication->setAuthorId($authorId);
                            $publication->setUrl($url);
                            Publication::update($publication);

                            $argsArray = [
                                'message' => "List has been updated",// Success message
                                'nav' => $_SESSION["role"],
                                'successType' => "update Publication"
                            ];

                            $templateName = 'process';
                            return $app['twig']->render($templateName . '.html.twig', $argsArray);
                        } else {
                            $argsArray = [
                                'message' => "Error - There was no list with Id : " . $id,// Error message
                                'message2' => 'Please trying again :)',
                                'errorType' => 'updatePublication',// Type of error used to give the right link back
                                'nav' => $_SESSION["role"]
                            ];

                            $templateName = 'error';
                            return $app['twig']->render($templateName . '.html.twig', $argsArray);
                        }
                    } else {
                        $argsArray = [
                            'message' => "Error - URL was not filled in",// Error message
                            'message2' => 'Please trying again :)',
                            'errorType' => 'updatePublication',// Type of error used to give the right link back
                            'nav' => $_SESSION["role"]
                        ];

                        $templateName = 'error';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    }
                } else {
                    $argsArray = [
                        'message' => "Error - Author Id was not filled in",// Error message
                        'message2' => 'Please trying again :)',
                        'errorType' => 'updatePublication',// Type of error used to give the right link back
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            } else {
                $argsArray = [
                    'message' => "Error - Title was not filled in",// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'updatePublication',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Id was not filled in",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'updatePublication',// Type of error used to give the right link back
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }
}
