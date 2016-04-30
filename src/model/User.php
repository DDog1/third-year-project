<?php
/**
 * User: Darren Cosgrave
*/

namespace Itb\model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

/**
 * Class User
 * @package Itb\model
 */
class User extends DatabaseTable
{
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;
    const ROLE_SUPERVISOR = 3;

    /**
     * The id of the user
     * @var int
     */
    private $id;
    /**
     * The username of the user
     * @var string
     */
    private $username;
    /**
     * The password of the user
     * @var mixed
     */
    private $password;
    /**
     * The role of the user
     * @var int
     */
    private $role;

    /**
     * Return the id of the user
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id of the user
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Return the name of the user
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the name of the user
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Return the password for the user
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Return the role of the user
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the role of the user
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * hash the password before storing ...
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->password = $hashedPassword;
    }

    /**
     * return success (or not) of attempting to find matching username/password in the repo
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public static function canFindMatchingUsernameAndPassword($username, $password)
    {
        $user = User::getOneByUsername($username);

        // if no record has this username, return FALSE
        if (null == $user) {
            return false;
        }

        // hashed correct password
        $hashedStoredPassword = $user->getPassword();

        // return whether or not hash of input password matches stored hash
        return password_verify($password, $hashedStoredPassword);
    }
//**************************************************************************************************************
    /**
     * looks for the users role
     * @param $username
     */
    public static function canFindMatchingUsernameAndRole($username)
    {
        $user = User::getOneByUsername($username);
        if ($user != null) {
            return $user -> getRole();
        } else {
            return null;
        }
    }
//***************************************************************************************************************
    /**
     * if record exists with $username, return User object for that record
     * otherwise return 'null'
     *
     * @param $username
     *
     * @return mixed|null
     */
    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return false;
        }
    }
}
