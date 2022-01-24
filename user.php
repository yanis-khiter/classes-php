<?php

class User
{
    private $id;
    public $login;
    public $email;
    public $fname;
    public $lname;
    public $bdd;
    public $users;

    
    public function __construct() {
        
        $this->bdd = mysqli_connect("localhost", "root", "", "classes");
        $req = mysqli_query($this->bdd, "SELECT * FROM utilisateurs");
        $this->users = mysqli_fetch_all($req);
    }

    public function register ($login, $password, $email, $fname, $lname) {

        foreach($this->users as $user)
        {
            if($login == $user[1])
            {
                echo "error login";
            }

            elseif($login != $user[1])
            {
                $ruser = mysqli_query($this->bdd, "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$fname', '$lname')");
                return "
                <table style='text-align:center'>
                    <theader>
                        <th>login</th>
                        <th>password</th>
                        <th>email</th>
                        <th>firstname</th>
                        <th>lastname</th>
                    </theader>
                    <tbody>
                        <td> $login </td>
                        <td> $password </td>
                        <td> $email </td>
                        <td> $fname </td>
                        <td> $lname </td>
                    </tbody>
                </table>";    
            }
        }
        

    }

    public function connect ($login, $password) {

        foreach($this->users as $user)
        {
            if($login == $user[1] && $password = $user[2])
            {
                $_SESSION["login"] = $login;
                

                
                $this->login = $login;
                $this->email = $user[3];
                $this->fname = $user[4];
                $this->lname = $user[5];
                echo "vous êtes connecté  ".$this->login;
            }
        }
    }

    public function disconnect () {
        session_destroy();
        echo "vous êtes déconnecté";
    }

    public function delete () {
        $login = $this->login;
        $dlt = mysqli_query($this->bdd, "DELETE FROM utilisateurs WHERE login = '$login'");
        session_destroy();
        $this->login = NULL;
        return $login." delete";
    }

    public function update($login, $password, $email, $fname, $lname) {
        if(isset($_SESSION["login"]))
        {
            $loginn = $_SESSION["login"];
            $updt = mysqli_query($this->bdd, "UPDATE utilisateurs SET login='$login', password='$password', email='$email', firstname='$fname', lastname='$lname' WHERE login = '$loginn'");
            return "Information a jour";
        }
    }

    public function isConnected () {
        return isset($_SESSION["login"]);
    }

    public function getAllInfos () {
        return "
        <table style='text-align:center'>
            <theader>
                <th>login</th>
                <th>email</th>
                <th>firstname</th>
                <th>lastname</th>
            </theader>
            <tbody>
                <td> $this->login </td>
                <td> $this->email </td>
                <td> $this->fname </td>
                <td> $this->lname </td>
            </tbody>
        </table>";
    }

    public function getLogin() {
        return $this->login;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFirstname() {
        return $this->fname;
    }

    public function getLastname() {
        return $this->lname;
    }
}
?>