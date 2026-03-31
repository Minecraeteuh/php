//* traitement_connexion.php */
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "kanken";
    $dbname = "utilisateurs";

    try{
        $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) && !empty($password)) {
        $req = $bdd->prepare("SELECT * FROM users WHERE email = :email AND motDePasse = :password");
        $req->execute([
            'email' => $email,
            'password' => $password
        ]);
        $rep = $req->fetch();

        if($rep) { 
            $token = bin2hex(random_bytes(32));
            
            $upd = $bdd->prepare("UPDATE users SET token = :token WHERE id = :id");
            $upd->execute(['token' => $token, 'id' => $rep['id']]);

            setcookie("token", $token, time() + (86400 * 30), "/");
            setcookie("email", $email, time() + (86400 * 30), "/");
            
            header("Location: index.php");
            exit();
        } else {
            header("Location: connexion.php?error=1");
            exit();
        }
    }
}