    <?php
    $servername = "localhost";
    $username = "root";
    $password = "kanken";

    try{
        $bdd = new PDO("mysql:host=$servername;dbname=utilisateurs", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        echo $email. '-'. $password;
        if($email != "" && $password != "") {
            $req = $bdd->prepare("SELECT * FROM users WHERE email = '$email' AND motDePasse = '$password'");
            $rep = $req->fetch();
            if(($rep['id'] != false)){
                setcookie("email", $email, time() + (86400 * 30), "/");
                setcookie("password", $password, time() + (86400 * 30), "/");
                header("Location: index.php");
                exit();
            }
            else{
                $error_msg = "Email ou mot de passe incorrect.";
            }
        }
    }
?>