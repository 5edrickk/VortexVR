<?php
class PanierManager {

    private $db;

    public function __construct() {
        $this->db = PDOFactory::getMySQLConnection();
    }

    /**
     * Retourne le panier de l'utilisateur (ou null si aucun).
     * Résultat : tableau associatif ou null.
     */
    public function getPanierActifPourUtilisateur(int $idUtilisateur): ?array {
        $sql = "SELECT id_panier, id_utilisateur
                FROM paniers
                WHERE id_utilisateur = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUtilisateur]);
        $panier = $stmt->fetch();

        if ($panier === false) {
            return null;
        }

        return $panier;
    }

    /**
     * Retourne la liste des articles d'un panier donné.
     * Chaque article contient : nom_casque, image_fichier, quantite, prix_unitaire, sous_total.
     */
    public function getArticlesDuPanier(int $idPanier): array {

        $sql = "SELECT 
                ap.id_panier,
                ap.id_casque,
                ap.quantite,
                ap.prix_unitaire,
                c.nom_casque,
                c.image_fichier
            FROM articles_panier ap
            JOIN casques c ON c.id_casque = ap.id_casque
            WHERE ap.id_panier = :id_panier";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_panier' => $idPanier]);
        $articles = $stmt->fetchAll();

        return $articles;
    }

    /**
     * Calcule le total à partir de la liste d'articles (avec 'sous_total').
     */
    public function calculerTotal(array &$articles): float {
        $total = 0.0;

        foreach ($articles as &$article) {
            $article['sous_total'] = $article['quantite'] * $article['prix_unitaire'];
            $total += $article['sous_total'];
        }
        unset($article); 
        return $total;
    }

    /**
     * Crée une nouvelle commande pour un utilisateur et un panier donnés.
     * Retourne l'id de la commande créée.
     */
    public function creerCommande(int $idUtilisateur, int $idPanier, float $montantTotal): int {

        $sql = 
        "INSERT INTO commandes (id_utilisateur, id_panier, montant_total)
            VALUES (:id_utilisateur, :id_panier, :montant_total)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_utilisateur' => $idUtilisateur,
            ':id_panier'      => $idPanier,
            ':montant_total'  => $montantTotal
        ]);

        return $this->db->lastInsertId();
    }

    /**
     *  Vide les articles d'un panier après une commande.
     */
    public function viderPanier(int $idPanier): void {
        $sql = "DELETE FROM articles_panier WHERE id_panier = :id_panier";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_panier' => $idPanier]);
    }
}
