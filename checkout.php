<?php require_once "inc/header.php"; 

$_SESSION['id_utilisateur'] = 2;

$idUtilisateur = $_SESSION['id_utilisateur'];

$panierManager = new PanierManager();

$panier = $panierManager->getPanierActifPourUtilisateur($idUtilisateur);

$articles = [];
$nombreArticles = 0;
$montantArticles = 0.0;
$livraison = 9.99;        
$tps = 0.0;
$tvq = 0.0;
$totalFinal = 0.0;

if ($panier !== null) {

    $articles = $panierManager->getArticlesDuPanier( $panier['id_panier']);

    if (!empty($articles)) {
        $montantArticles = $panierManager->calculerTotal($articles);

        foreach ($articles as $article) {
            $nombreArticles += $article['quantite'];
        }

        $tps = $montantArticles * 0.05;        
        $tvq = $montantArticles * 0.09975;     

        $totalFinal = $montantArticles + $livraison + $tps + $tvq;

    } else {
        $livraison = 0.0;
        $totalFinal = 0.0;
    }

} else {
    $livraison = 0.0;
    $totalFinal = 0.0;
}

function fmt($montant) {
    return number_format($montant, 2, ',', ' ');
}
?>

<section class="checkout">
    <div class="checkout-container">

        <section class="checkout-header-strip">
            <h2 class="checkout-header-title">Passer la commande</h2>
        </section>

        <section class="checkout-summary-row">

            <div class="checkout-breakdown-box">

                <div class="breakdown-row">
                    <span class="breakdown-label">Nombre d'articles :</span>
                    <span class="breakdown-value"><?= $nombreArticles ?></span>
                </div>

                <div class="breakdown-row">
                    <span class="breakdown-label">Montant des articles :</span>
                    <span class="breakdown-value"> <?= fmt($montantArticles) ?> $</span>
                </div>

                <div class="breakdown-row">
                    <span class="breakdown-label">Frais de livraison :</span>
                    <span class="breakdown-value"><?= fmt($livraison) ?> $</span>
                </div>

                <div class="breakdown-row">
                    <span class="breakdown-label">TPS (5 %) :</span>
                    <span class="breakdown-value"><?= fmt($tps) ?> $</span>
                </div>

                <div class="breakdown-row">
                    <span class="breakdown-label">TVQ (9,975 %) :</span>
                    <span class="breakdown-value"> <?= fmt($tvq) ?> $</span>
                </div>

                <div class="breakdown-row breakdown-total">
                    <span class="breakdown-label">Montant total :</span>
                    <span class="breakdown-value"><?= fmt($totalFinal) ?> $</span>
                </div>

            </div>

        </section>

        <section class="checkout-products-section">

            <?php if (empty($articles)): ?>
                    <p class="checkout-empty-message">
                        Votre panier est vide pour le moment.
                    </p>

                <?php else: ?>

                <div class="checkout-products-grid">

                    <?php foreach ($articles as $article): ?>
                            <?php
                                $image = 'images/' . $article['image_fichier'];
                            ?>

                        <article class="checkout-product-card">
                            <h3 class="product-name"><?= htmlspecialchars($article['nom_casque']) ?></h3>

                            <div class="product-image-box">
                                <img  src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($article['nom_casque']) ?>">
                            </div>

                            <div class="product-bottom-row">

                                <div class="product-qty-controls">
                                    <button type="button" class="qty-btn">- 1</button>
                                    <button type="button" class="qty-btn">+ 1</button>
                                </div>

                                <span class="product-price"><?= fmt($article['prix_unitaire']) ?> $</span>
                            </div>
                        </article>
                    <?php endforeach; ?>

                </div>
            <?php endif; ?>

        </section>

    </div>

</section>
<?php require_once "inc/footer.php"; ?>
