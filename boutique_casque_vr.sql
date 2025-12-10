use msdb;
CREATE DATABASE boutique_casques_vr;
USE boutique_casques_vr;

-- TABLE UTILISATEURS
CREATE TABLE utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) NOT NULL,
    courriel VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

-- TABLE MARQUES
CREATE TABLE marques (
    id_marque INT AUTO_INCREMENT PRIMARY KEY,
    nom_marque VARCHAR(100) NOT NULL
);

-- TABLE CASQUES
CREATE TABLE casques (
    id_casque INT AUTO_INCREMENT PRIMARY KEY,
    id_marque INT NOT NULL,
    id_createur INT NOT NULL,
    nom_casque VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    description TEXT,
    CONSTRAINT fk_casques_marques FOREIGN KEY (id_marque)
        REFERENCES marques(id_marque),
    CONSTRAINT fk_casques_utilisateurs FOREIGN KEY (id_createur)
        REFERENCES utilisateurs(id_utilisateur)
);

-- TABLE PANIERS
CREATE TABLE paniers (
    id_panier INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    CONSTRAINT fk_paniers_utilisateurs FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateurs(id_utilisateur)
);

-- TABLE ARTICLES PANIER
CREATE TABLE articles_panier (
    id_article_panier INT AUTO_INCREMENT PRIMARY KEY,
    id_panier INT NOT NULL,
    id_casque INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_articles_panier_paniers FOREIGN KEY (id_panier)
        REFERENCES paniers(id_panier)
        ON DELETE CASCADE,
    CONSTRAINT fk_articles_panier_casques FOREIGN KEY (id_casque)
        REFERENCES casques(id_casque)
);

-- TABLE COMMANDES
CREATE TABLE commandes (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_panier INT NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    date_commande DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_commandes_utilisateur FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateurs(id_utilisateur),
    CONSTRAINT fk_commandes_panier FOREIGN KEY (id_panier)
        REFERENCES paniers(id_panier)
);
