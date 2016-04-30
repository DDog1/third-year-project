<?php
/**
 * Admin controller used for doing CRUD
 */
namespace Itb\Controller;

use Itb\Model;
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
        $users = Model\User::getAll();

        return $users;
    }

    /**
     * This method will return an array of lists from the database
     * @return array
     */
    public function displayActions()
    {
        $actions = Model\Action::getAll();

        return $actions;
    }

    /**
     * This method will return an array of publications from the database
     * @return array
     */
    public function displayPublications()
    {
        $publications = Model\Publication::getAll();

        return $publications;
    }

    /**
     * This method will return an array of projects from the database
     * @return array
     */
    public function displayProjects()
    {
        $projects = Model\Project::getAll();

        return $projects;
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
                $user = new Model\User();
                $user->setPassword($password);
                $user->setUsername($username);
                $user->setRole($role);
                Model\User::insert($user);

                $argsArray = [
                    'message' => "user has been added to the database :)",// Success message
                    'nav' => $_SESSION["role"],
                    'successType' => "add User"
                ];

                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
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
            $isOnDatabase = Model\User::getOneById($id);
            if ($isOnDatabase!=null) {
                $user = new Model\User();
                $user->setId($id);
                Model\User::delete($id);

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
                        $user = new Model\User();
                        $user->setId($id);
                        $user->setUsername($username);
                        $user->setPassword($password);
                        $user->setRole($role);
                        Model\User::update($user);

                        $argsArray = [
                            'message' => "User has been updated",// Success message
                            'nav' => $_SESSION["role"],
                            'successType' => "update User"
                        ];

                        $templateName = 'process';
                        return $app['twig']->render($templateName . '.html.twig', $argsArray);
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
                        $action = new Model\Action();
                        $action->setDescription($description);
                        $action->setImplementorid($implementorid);
                        $action->setDeadline($deadline);
                        $action->setStatus($status);
                        Model\Action::insert($action);

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
            $isOnDatabase = Model\Action::getOneById($id);
            if ($isOnDatabase!=null) {
                $list = new Model\Action();
                $list->setId($id);
                Model\Action::delete($id);

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
            $isOnDatabase = Model\Action::getOneById($id);
            if ($isOnDatabase!=null) {
                $list = new Model\Action();
                $list->setId($id);
                $list->setDescription($description);
                $list->setImplementorid($implementorid);
                $list->setDeadline($deadline);
                $list->setStatus($status);
                Model\Action::update($list);

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
                    $publication = new Model\Publication();
                    $publication->setUrl($url);
                    $publication->setTitle($title);
                    $publication->setAuthorId($authorId);
                    Model\Publication::insert($publication);

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
            $isOnDatabase = Model\Publication::getOneById($id);
            if ($isOnDatabase!=null) {
                Model\Publication::delete($id);
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
                        $isOnDatabase = Model\Publication::getOneById($id);
                        if ($isOnDatabase != null) {
                            $publication = new Model\Publication();
                            $publication->setId($id);
                            $publication->setTitle($title);
                            $publication->setAuthorId($authorId);
                            $publication->setUrl($url);
                            Model\Publication::update($publication);

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
