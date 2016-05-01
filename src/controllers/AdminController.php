<?php
/**
 * Admin controller used for doing CRUD
 */
namespace Itb\Controller;

use Itb\Model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class manages the admin operations
 * Class AdminController
 * @package Itb\Controller
 */
class AdminController
{
    /**
     * This method will return an array of students from the database
     * @return array
     */
    public function displayUsers()
    {
        $users = User::getAll();

        return $users;
    }

    /**
     * This method will display the admin add function,
     * will give error if not logged in as admin
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addUser(Request $request, Application $app)//Only the admin can use this method
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == 2) {
                $users = $this->displayUsers();
                $argsArray = [
                    'users' => $users,
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'addUser';
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
     * Lets the admins add a new user to the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processAddUser(Request $request, Application $app)
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $retypePassword = filter_input(INPUT_POST, 'retypePassword', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        if ($password == $retypePassword) {
            if ($username!=null) {
                if ($role == 1 || $role == 2 || $role == 3) {
                    $isOnDatabase = User::getOneByUsername($username);
                    if ($isOnDatabase != true) {
                        $user = new User();
                        $user->setPassword($password);
                        $user->setUsername($username);
                        $user->setRole($role);
                        User::insert($user);

                        $argsArray = [
                            'message' => "user has been added to the database :)",// Success message
                            'nav' => $_SESSION["role"],
                            'successType' => "add User"
                        ];

                        $templateName = 'process';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    } else {
                        $argsArray = [
                            'message' => "Error - Cant have more than one user with this name",// Error message
                            'message2' => 'Please trying again :)',
                            'errorType' => 'addUser',// Type of error used to give the right link back
                            'nav' => $_SESSION["role"]
                        ];

                        $templateName = 'error';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    }
                } else {
                    $argsArray = [
                        'message' => "Error - Role must be 1 for user, 2 for admin or 3 for supervisor",// Error message
                        'message2' => 'Please trying again :)',
                        'errorType' => 'addUser',// Type of error used to give the right link back
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            } else {
                $argsArray = [
                    'message' => "Error - Username not filled in",// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'addUser',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Passwords don't mach",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'addUser',// Type of error used to give the right link back
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
    public function removeUser(Request $request, Application $app)//Only the admin can use this method
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role']==2) {
                $users = $this->displayUsers();
                $argsArray = [
                    'users' => $users,
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'removeUser';
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
     * Lets the admins remove a user from the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processRemoveUser(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        if ($id!=null) {
            $isOnDatabase = User::getOneById($id);
            if ($isOnDatabase!=null) {
                $user = new User();
                $user->setId($id);
                User::delete($id);

                $argsArray = [
                    'message' => "User has been removed form the database",// Success message
                    'nav' => $_SESSION["role"],
                    'successType' => "remove User"
                ];

                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            } else {
                $argsArray = [
                    'message' => "Error - There was no user with Id : ".$id,// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'removeUser',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Id not filled in",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'removeUser',// Type of error used to give the right link back
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
    public function updateUser(Request $request, Application $app)//Only the admin can use this method
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role']==2) {
                $users = $this->displayUsers();
                $argsArray = [
                    'users' => $users,
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'updateUser';
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
    public function processUpdateUser(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $retypePassword = filter_input(INPUT_POST, 'retypePassword', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        if ($id!=null) {
            if ($password == $retypePassword) {
                if ($username != null) {
                    if ($role == 1 || $role == 2) {
                        $isOnDatabase = User::getOneByUsername($username);
                        if ($isOnDatabase != true) {
                            $user = new User();
                            $user->setId($id);
                            $user->setUsername($username);
                            $user->setPassword($password);
                            $user->setRole($role);
                            User::update($user);

                            $argsArray = [
                                'message' => "User has been updated",// Success message
                                'nav' => $_SESSION["role"],
                                'successType' => "update User"
                            ];

                            $templateName = 'process';
                            return $app['twig']->render($templateName . '.html.twig', $argsArray);
                        } else {
                            $argsArray = [
                                'message' => "Error - Cant have more than one user with this name",// Error message
                                'message2' => 'Please trying again :)',
                                'errorType' => 'updateUser',// Type of error used to give the right link back
                                'nav' => $_SESSION["role"]
                            ];

                            $templateName = 'error';
                            return $app['twig']->render($templateName . '.html.twig', $argsArray);
                        }
                    } else {
                        $argsArray = [
                        'message' => "Error - Role must be a number",// Error message
                        'message2' => 'Please trying again :)',
                        'errorType' => 'updateUser',// Type of error used to give the right link back
                        'nav' => $_SESSION["role"]
                    ];

                        $templateName = 'error';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
                    }
                } else {
                    $argsArray = [
                        'message' => "Error - Username not filled in",// Error message
                        'message2' => 'Please trying again :)',
                        'errorType' => 'updateUser',// Type of error used to give the right link back
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            } else {
                $argsArray = [
                    'message' => "Error - Passwords don't match",// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'updateUser',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Id not filled in",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'updateUser',// Type of error used to give the right link back
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }
}
