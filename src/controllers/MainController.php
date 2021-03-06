<?php
/**
 * User: Darren Cosgrave
 */

namespace Itb\Controller;

use Itb\Model;
use Itb\model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * The MainController will look after login, logout, register, list actions and showing the user profile
 * Class MainController
 * @package Itb\Controller
 */
class MainController
{
    /**
     * This method will print out the home page, for users to login
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function indexAction(Request $request, Application $app)
    {
        $argsArray = [];

        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * When a new user wants to register to the page it will load in the form
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function register(Request $request, Application $app)
    {
        $argsArray = [];

        $templateName = 'register';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * This method will process the new users info and will, by default set all new users to role of 1.
     * Unless the admin changes there status
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processRegister(Request $request, Application $app)
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $retypePassword = filter_input(INPUT_POST, 'retypePassword', FILTER_SANITIZE_STRING);
        $role = 1;

        if ($username != null) {
            if ($password == $retypePassword) {
                $isNotInDatabase = Model\User::getOneByUsername($username);
                if ($isNotInDatabase != true) {
                    $user = new Model\User();
                    $user->setUsername($username);
                    $user->setPassword($password);
                    $user->setRole(Model\User::ROLE_USER);
                    Model\User::insert($user);

                    $_SESSION["role"] = 1;

                    $argsArray = [
                        'username' => $username,
                        'message' => "New users are automatically set to user. Please contact an admin to change your role",
                        'nav' => $_SESSION["role"]
                    ];

                    $templateName = 'login';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                } else {
                    $argsArray = [
                        'message' => "Error - Username is taking",// Error message
                        'message2' => 'Please trying again :)',
                        'errorType' => 'register'// Type of error used to give the right link back
                    ];

                    $templateName = 'error';
                    return $app['twig']->render($templateName . '.html.twig', $argsArray);
                }
            } else {
                $argsArray = [
                    'message' => "Error - Passwords don't match!",// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'register'// Type of error used to give the right link back
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Username not filled in!",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'register'// Type of error used to give the right link back
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * Used to print out list of users
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function listUsers(Request $request, Application $app)
    {
        $role = 0;
        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];
        }

        $users = Model\User::getAll();
        $argsArray = [
            'users' =>$users,
            'nav' =>$role
        ];

        $templateName = 'listUsers';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Used to print out list of projects
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function listActions(Request $request, Application $app)
    {
        $role = 0;
        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];
        }

        $actions = Model\Action::getAll();
        $argsArray = [
            'actions' =>$actions,
            'nav' =>$role
        ];

        $templateName = 'listActions';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Used to print out list of publications
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function listPublications(Request $request, Application $app)
    {
        $role = 0;
        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];
        }

        $publications = Model\Publication::getAll();
        $argsArray = [
            'publications' =>$publications,
            'nav' =>$role
        ];

        $templateName = 'listPublications';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Used to print out list of projects
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function listProjects(Request $request, Application $app)
    {
        $role = 0;
        if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];
        }

        $projects = Model\Project::getAll();
        $argsArray = [
            'projects' =>$projects,
            'nav' =>$role
        ];

        $templateName = 'listProjects';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * This method is used to kill the session and to bring the user back to login scren
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function killSession(Request $request, Application $app)
    {
        $_SESSION = [];
        session_destroy();

        $argsArray = [
            'logout' => "You have been logout :D"
        ];

        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * This method will process the users details and see if they are on the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processLoginAction(Request $request, Application $app)
    {
        // default is bad login
        $isLoggedIn = false;

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // search for user with username and password in database
        // then get role - used for nav bar
        $user = new Model\User();
        $isLoggedIn = $user->canFindMatchingUsernameAndPassword($username, $password);
        $isRole = $user->canFindMatchingUsernameAndRole($username);

        // action depending on login success
        if ($isLoggedIn) {
            $_SESSION["username"]=$username;
            $_SESSION["password"]=$password;
            $_SESSION["isLoggedIn"]=$isLoggedIn;
            $_SESSION["role"]=$isRole;
            $_SESSION['hasLoggedIn']="yes";

            // success - found a matching username and password
            $argsArray = [
                'username' => $username,
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'login';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        } else {
            // if username not found or password is wrong
            $argsArray = [
                'message' => 'Error - Username or Password is wrong',// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'login'// Type of error used to give the right link back
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * Used to print out the selected user by passing in the users id
     * @param Request $request
     * @param Application $app
     * @param $username
     * @return mixed
     */
    public function showUserProfile(Request $request, Application $app, $username)
    {
        $user = Model\User::getOneByUsername($username);
        $role=0;
        $currentUser = "not logged in";
        if (isset($_SESSION['role'])) {
            $role=$_SESSION['role'];
        }
        if (isset($_SESSION['username'])) {
            $currentUser = $_SESSION['username'];
        }

        $argsArray = [
            'nav' => $role,
            'user' => $user,
            'currentUser' => $currentUser
        ];

        $templateName = 'profile';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }


//**********************************************************************************************


    /**
     * Used to print out a form for a user to change there details on there homepage
     * @param Request $request
     * @param Application $app
     * @param $username
     * @return mixed
     */
    public function showUserProfileEdit(Request $request, Application $app, $username)
    {
        $user = Model\User::getOneByUsername($username);

        $argsArray = [
            'nav' => $_SESSION['role'],
            'user' => $user
        ];

        $templateName = 'profileEdit';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Used to process user changes to there homepage
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processUserEdit(Request $request, Application $app)
    {
        $user = Model\User::getOneByUsername($_SESSION['username']);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING);

/*
        $user = new User();
        $user->setId($id);
        $user->setUsername($_SESSION["username"]);
        $user->setPassword($_SESSION["password"]);
        $user->setRole($_SESSION["role"]);
        $user->setDescription($description);
        User::update($user);
*/

/*
        $image=$_FILES['image']['name'];

        $file_name = $_SESSION['username']; // New unique file name

        if (move_uploaded_file($_FILES['image']['name'], "NewImages/{$file_name}.jpg"))
        {
            echo "The file " . basename($_FILES['image']['name']) .
                " has been uploaded";
        }
        else
        {
            echo "There was an error uploading the file, please try again!";
        }
*/

        $argsArray = [
            'nav' => $_SESSION['role'],
            'user' => $user
        ];

        $templateName = 'profile';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Used to print out the current user logged in homepage
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function userProfile(Request $request, Application $app)
    {
        if (isset($_SESSION['username'])) {
            $user = Model\User::getOneByUsername($_SESSION['username']);

            $currentUser = "not logged in";
            if (isset($_SESSION['username'])) {
                $currentUser = $_SESSION['username'];
            }

            $argsArray = [
                'nav' => $_SESSION['role'],
                'user' => $user,
                'currentUser' => $currentUser
            ];

            $templateName = 'profile';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
        $argsArray = [
            'message' => "Error - Not logged in",// Error message
            'message2' => 'Please trying again :)',
            'errorType' => 'notLoggedIn',// Type of error used to give the right link back
        ];

        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}
