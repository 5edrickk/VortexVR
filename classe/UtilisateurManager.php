<?php

class UtilisateurManager
{
    private PDO $db;

    public function __construct()
    {
        $this->db = PDOFactory::getMySQLConnection();
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    public function getSolde(int $idUtilisateur): float
    {
        $sql = "SELECT solde
                FROM utilisateurs
                WHERE id_utilisateur = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idUtilisateur]);
        $row = $stmt->fetch();

        if ($row === false) {
            return 0.0;
        }

        return $row['solde'];
    }

    public function setSolde(int $idUtilisateur, float $nouveauSolde): void
    {
        $sql = "UPDATE utilisateurs
                SET solde = :solde
                WHERE id_utilisateur = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':solde' => $nouveauSolde,
            ':id'    => $idUtilisateur
        ]);
    }

    public function debiterSolde(int $idUtilisateur, float $montant): void
    {
        $sql = "UPDATE utilisateurs
                SET solde = solde - :montant
                WHERE id_utilisateur = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':montant' => $montant,
            ':id'      => $idUtilisateur
        ]);
    }

    public function crediterSolde(int $idUtilisateur, float $montant): void
    {
        $sql = "UPDATE utilisateurs
                SET solde = solde + :montant
                WHERE id_utilisateur = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':montant' => $montant,
            ':id'      => $idUtilisateur
        ]);
    }
}
?>