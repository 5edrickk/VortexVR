<?php require_once "inc/header.php";
$erreur = null;

if (isset($_SESSION['id_utilisateur'])) {
    header("Location: catalogue.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connexion'])) {

    $courriel = trim($_POST['courriel'] ?? '');
    $motDePasse = trim($_POST['mot_de_passe'] ?? '');

    if ($courriel === '' || $motDePasse === '') {
        $erreur = "Veuillez remplir tous les champs.";
    } else {

        $utilisateurManager = new UtilisateurManager();
        $user = $utilisateurManager->verifierConnexion($courriel, $motDePasse);

        if (!$user) {
            $erreur = "Courriel ou mot de passe incorrect.";
        } else {

            $_SESSION['id_utilisateur'] = (int) $user['id_utilisateur'];
            $_SESSION['nom_utilisateur'] = $user['nom_utilisateur'];

            header("Location: checkout.php");
            exit;
        }
    }
}
?>

<section class="compte">
    <div class="compte-container">

        <section class="compte-header">
            <h2>Connexion</h2>
        </section>

        <?php if ($erreur): ?>
            <p class="compte-error"><?= $erreur ?></p>
        <?php endif; ?>

        <form method="post" class="compte-form">

            <div class="compte-group">
                <label for="courriel">Courriel</label>
                <input type="email" id="courriel" name="courriel" required>
            </div>

            <div class="compte-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <button type="submit" name="connexion" class="compte-btn">
                Se connecter
            </button>

        </form>

    </div>
</section>

<?php require_once "inc/footer.php"; ?>
