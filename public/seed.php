<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Itb\Model\User;
use Itb\Model\Project;
use Itb\Model\Action;
use Itb\Model\Publication;

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'ffdeadbeaf');
define('DB_NAME', 'graphicsgaminggroup');

$matt = new User();
$matt->setUsername('matt');
$matt->setPassword('smith');
$matt->setRole(User::ROLE_USER);

$joe = new User();
$joe->setUsername('joe');
$joe->setPassword('bloggs');
$joe->setRole(User::ROLE_USER);

$kieron = new User();
$kieron->setUsername('kieron');
$kieron->setPassword('fionn');
$kieron->setRole(User::ROLE_SUPERVISOR);

$admin = new User();
$admin->setUsername('admin');
$admin->setPassword('admin');
$admin->setRole(User::ROLE_ADMIN);

User::insert($matt);
User::insert($joe);
User::insert($kieron);
User::insert($admin);

$users = User::getAll();

var_dump($users);


$project_1 = new Project();
$project_1->setTitle("Batman returns!!");
$project_1->setDescription("The next chapter for the batman series. Following after the events of the Joker.");
$project_1->setMembers("Matt Smith - Joe Blogges");
$project_1->setSupervisor("Kieron Fionn");
$project_1->setDeadline("2016-06-30");

$project_2 = new Project();
$project_2->setTitle("007");
$project_2->setDescription("James Bond is now marked a traitor and a killer. Being hunted by corrupted agents who framed him for killing Q");
$project_2->setMembers("Matt Smith - Joe Dunne");
$project_2->setSupervisor("Kieron Fionn");
$project_2->setDeadline("2016-10-30");

Project::insert($project_1);
Project::insert($project_2);

$projects = Project::getAll();

var_dump($projects);


$publication_1 = new Publication();
$publication_1->setTitle("PDO objects");
$publication_1->setAuthorId(2);
$publication_1->setUrl("/downloads/pdo_smith_2015.pdf");

$publication_2 = new Publication();
$publication_2->setTitle("Php for the win");
$publication_2->setAuthorId(1);
$publication_2->setUrl("/downloads/for_the_win_2016.pdf");


Publication::insert($publication_1);
Publication::insert($publication_2);

$publications = Publication::getAll();
var_dump($publications);
