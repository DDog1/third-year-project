<?php
/**
 * Created by PhpStorm.
 * User: Darren Cosgrave
 * Date: 30/04/2016
 * Time: 22:20
 */

namespace Itb\Controller;

use Itb\Model\Project;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProjectCRUD
 * @package Itb\Controller
 */
class ProjectCRUD
{
    /**
     * This method will return an array of projects from the database
     * @return array
     */
    public function displayProjects()
    {
        $projects = Project::getAll();

        return $projects;
    }

    /**
     * This method will display the add project function,
     * will give error if not logged in as admin
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addProject(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            $projects = $this->displayProjects();
            $argsArray = [
                'projects' => $projects,
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'addProject';
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

    /**
     * Lets the users add a new project to the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processAddProject(Request $request, Application $app)
    {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $members = filter_input(INPUT_POST, 'members', FILTER_SANITIZE_STRING);
        $supervisor = filter_input(INPUT_POST, 'supervisor', FILTER_SANITIZE_STRING);
        $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);

        $project = new Project();
        $project->setTitle($title);
        $project->setDescription($description);
        $project->setMembers($members);
        $project->setSupervisor($supervisor);
        $project->setDeadline($deadline);
        Project::insert($project);

        $argsArray = [
            'message' => "project has been added to the database :)",// Success message
            'nav' => $_SESSION["role"],
            'successType' => "add Project"
        ];

        $templateName = 'process';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * This method will display the remove project function,
     * will give error if not logged in as admin
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function removeProject(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            $projects = $this->displayProjects();
            $argsArray = [
                'projects' => $projects,
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'removeProject';
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

    /**
     * Lets the users remove a project to the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processRemoveProject(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        if ($id!=null) {
            $isOnDatabase = Project::getOneById($id);
            if ($isOnDatabase!=null) {
                $project = new Project();
                $project->setId($id);
                Project::delete($id);

                $argsArray = [
                    'message' => "Project has been removed form the database",// Success message
                    'nav' => $_SESSION["role"],
                    'successType' => "remove Project"
                ];

                $templateName = 'process';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            } else {
                $argsArray = [
                    'message' => "Error - There was no project with Id : ".$id,// Error message
                    'message2' => 'Please trying again :)',
                    'errorType' => 'removeProject',// Type of error used to give the right link back
                    'nav' => $_SESSION["role"]
                ];

                $templateName = 'error';
                return $app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        } else {
            $argsArray = [
                'message' => "Error - Id not filled in",// Error message
                'message2' => 'Please trying again :)',
                'errorType' => 'removeProject',// Type of error used to give the right link back
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    /**
     * This method will display the update project function,
     * will give error if not logged in as admin
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function updateProject(Request $request, Application $app)
    {
        if (isset($_SESSION['role'])) {
            $projects = $this->displayProjects();
            $argsArray = [
                'projects' => $projects,
                'nav' => $_SESSION["role"]
            ];

            $templateName = 'updateProjects';
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

    /**
     * Lets the users update a project to the database
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function processUpdateProject(Request $request, Application $app)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $members = filter_input(INPUT_POST, 'members', FILTER_SANITIZE_STRING);
        $supervisor = filter_input(INPUT_POST, 'supervisor', FILTER_SANITIZE_STRING);
        $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);

        $isOnDatabase = Project::getOneById($id);
        if ($isOnDatabase != null) {
            $project = new Project();
            $project->setId($id);
            $project->setTitle($title);
            $project->setDescription($description);
            $project->setMembers($members);
            $project->setSupervisor($supervisor);
            $project->setDeadline($deadline);
            Project::update($project);

            $argsArray = [
                'message' => "Project has been updated",// Success message
                'nav' => $_SESSION["role"],
                'successType' => "update Project"
            ];

            $templateName = 'process';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        } else {
            $argsArray = [
            'message' => "Error - There was no project with Id : " . $id,// Error message
            'message2' => 'Please trying again :)',
            'errorType' => 'updateProject',// Type of error used to give the right link back
            'nav' => $_SESSION["role"]
        ];

            $templateName = 'error';
            return $app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }
}
