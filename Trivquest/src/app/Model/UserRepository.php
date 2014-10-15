<?php

require_once("Repository.php");

class UserRepository extends Repository
{
    private $db;
    private static $username = "username";
    private static $password = "password";
    private static $token = "token";
    private static $expire = "expire";
    private static $gold = "gold";
    private static $skip = "skip";
    private static $removeTwo = "removetwo";
    private static $exp = "exp";
    private static $expToNextLevel = "exp";
    private static $level = "level";


    public function __construct()
    {
        $this->dbTable = "user";
        $this->db = $this->connectionUser();
    }

    //Insert new user into database
    public function addUser(User $user)
    {
        try
        {
            $sql = "INSERT INTO $this->dbTable (". self::$username . ", " . self::$password . ") VALUES (?, ?)";
            $params = array($user->getUsername(), $user->getPassword());

            $query = $this->db->prepare($sql);
            $query->execute($params);
        }
        catch(PDOException $e)
        {
            die("An error has occurred. Error code 222");
        }
    }

    public function getUserByName($username)
    {
        try
        {
            $sql = "SELECT * FROM $this->dbTable WHERE " . self::$username . "= ?";
            $params = array($username);

            $query = $this->db->prepare($sql);
            $query->execute($params);

            $result = $query->fetch();

            if($result)
            {
                $user = new User($result[self::$username],
                                        $result[self::$password],
                                        $result[self::$token],
                                        $result[self::$expire],
                                        $result[self::$gold],
                                        $result[self::$skip],
                                        $result[self::$removeTwo],
                                        $result[self::$exp],
                                        $result[self::$expToNextLevel],
                                        $result[self::$level]);

                return $user;
            }

            return null;
        }
        catch(PDOException $e)
        {
            die("An error has occurred. Error code 123");
        }
    }

    public function updateUserRemoveTwo($username, $value)
    {

    }

    public function updateUserSkip($username, $value)
    {

    }

    public function updateUserGold($username, $value)
    {

    }

    public function updateUserExp($username, $value)
    {

    }

    public function updateUserLevel($username, $value)
    {

    }

    public function updateUserExpToNextLevel($username, $value)
    {

    }

    //Updates the stored token and cookie expire time in database
    public function updateUserIdentifier($token, $expire, $username)
    {
        try
        {
            $sql = "UPDATE $this->dbTable SET ". self::$token . "= ?, " . self::$expire . "= ? WHERE " . self::$username . "= ?";
            $params = array($token, $expire, $username);

            $query = $this->db->prepare($sql);
            $query->execute($params);
        }
        catch(PDOException $e)
        {
            die("An error has occurred. Error code 355");
        }
    }
}