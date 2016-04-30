<?php
require_once __DIR__ . '/../app/setup.php';
require_once __DIR__ . '/../app/configDatabase.php';
session_start();

$app->get('/', 'Itb\Controller\MainController::indexAction');
$app->post('/login', 'Itb\Controller\MainController::processLoginAction');
$app->get('/killSession', 'Itb\Controller\MainController::killSession');
$app->get('/register', 'Itb\Controller\MainController::register');
$app->post('/processRegister', 'Itb\Controller\MainController::ProcessRegister');
$app->get('/user/{username}', 'Itb\Controller\MainController::showUserProfile');
$app->get('/user/{username}/edit', 'Itb\Controller\MainController::showUserProfileEdit');
$app->post('/processUserEdit', 'Itb\Controller\MainController::processUserEdit');
$app->get('/homepage', 'Itb\Controller\MainController::userProfile');

// View lists
$app->get('/listUsers', 'Itb\Controller\MainController::listUsers');
$app->get('/listActions', 'Itb\Controller\MainController::listActions');
$app->get('/listPublications', 'Itb\Controller\MainController::listPublications');
$app->get('/listProjects', 'Itb\Controller\MainController::listProjects');

// Admin CRUD
// Admin add user
$app->get('/addUser', 'Itb\Controller\AdminController::addUser');
$app->post('/processAddUser', 'Itb\Controller\AdminController::processAddUser');
// Admin remove user
$app->get('/removeUser', 'Itb\Controller\AdminController::removeUser');
$app->post('/processRemoveUser', 'Itb\Controller\AdminController::processRemoveUser');
// Admin update user
$app->get('/updateUser', 'Itb\Controller\AdminController::updateUser');
$app->post('/processUpdateUser', 'Itb\Controller\AdminController::processUpdateUser');

// Admin CRUD
// Admin add list
$app->get('/addAction', 'Itb\Controller\ListCRUD::addAction');
$app->post('/processAddAction', 'Itb\Controller\ListCRUD::processAddAction');
// Admin remove list
$app->get('/removeAction', 'Itb\Controller\ListCRUD::removeAction');
$app->post('/processRemoveAction', 'Itb\Controller\ListCRUD::processRemoveAction');
// Admin update list
$app->get('/updateAction', 'Itb\Controller\ListCRUD::updateAction');
$app->post('/processUpdateAction', 'Itb\Controller\ListCRUD::processUpdateAction');

// Admin CRUD
// Admin add publication
$app->get('/addPublication', 'Itb\Controller\PublicationCRUD::addPublication');
$app->post('/processAddPublication', 'Itb\Controller\PublicationCRUD::processAddPublication');
// Admin remove publication
$app->get('/removePublication', 'Itb\Controller\PublicationCRUD::removePublication');
$app->post('/processRemovePublication', 'Itb\Controller\PublicationCRUD::processRemovePublication');
// Admin update publication
$app->get('/updatePublication', 'Itb\Controller\PublicationCRUD::updatePublication');
$app->post('/processUpdatePublication', 'Itb\Controller\PublicationCRUD::processUpdatePublication');

// Admin CRUD
// Admin add project
$app->get('/addProject', 'Itb\Controller\ProjectCRUD::addProject');
$app->post('/processAddProject', 'Itb\Controller\ProjectCRUD::processAddProject');
// Admin remove project
$app->get('/removeProject', 'Itb\Controller\ProjectCRUD::removeProject');
$app->post('/processRemoveProject', 'Itb\Controller\ProjectCRUD::processRemoveProject');
// Admin update project
$app->get('/updateProject', 'Itb\Controller\ProjectCRUD::updateProject');
$app->post('/processUpdateProject', 'Itb\Controller\ProjectCRUD::processUpdateProject');


$app->error(function (\Exception $e, $code) use ($app) {
    $errorController = new Itb\Controller\ErrorController();
    return $errorController->errorAction($app, $code);
});

$app->run();
