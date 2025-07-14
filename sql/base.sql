Use db_s2_ETU004027;

CREATE TABLE EMPRUNTS_membres (
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    date_de_naissance DATE,
    genre CHAR(1),
    email VARCHAR(100),
    ville VARCHAR(100),
    mdp VARCHAR(100),
    image_profil VARCHAR(255)
);

CREATE TABLE EMPRUNTS_categorie_objet (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100)
);

CREATE TABLE EMPRUNTS_objet (
    id_objet INT AUTO_INCREMENT PRIMARY KEY,
    nom_objet VARCHAR(100),
    id_categorie INT,
    id_membre INT,
    FOREIGN KEY (id_categorie) REFERENCES EMPRUNTS_categorie_objet(id_categorie),
    FOREIGN KEY (id_membre) REFERENCES EMPRUNTS_membres(id_membre)
);

CREATE TABLE EMPRUNTS_images_objet (
    id_image INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT,
    nom_image VARCHAR(255),
    FOREIGN KEY (id_objet) REFERENCES EMPRUNTS_objet(id_objet)
);

CREATE TABLE EMPRUNTS_emprunt (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT,
    id_membre INT,
    date_emprunt DATE,
    date_retour DATE,
    FOREIGN KEY (id_objet) REFERENCES EMPRUNTS_objet(id_objet),
    FOREIGN KEY (id_membre) REFERENCES EMPRUNTS_membres(id_membre)
); 


CREATE TABLE EMPRUNTS_images_objet (
    id_image INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT,
    nom_image VARCHAR(255),
    FOREIGN KEY (id_objet) REFERENCES EMPRUNTS_objet(id_objet)
);

INSERT INTO EMPRUNTS_images_objet (id_objet, nom_image) VALUES
(1, 'assets/images/img_objet/seche_cheveux.webp'),
(2, 'assets/images/img_objet/Lisseur.webp'),
(11, 'assets/images/img_objet/ponceuse.webp'),
(21, 'assets/images/img_objet/trousse_manucure.webp'),
(31, 'assets/images/img_objet/brosse_lissante.webp');


INSERT INTO EMPRUNTS_membres (nom, date_de_naissance, genre, email, ville, mdp, image_profil) VALUES
('Joshua RASAMOELY', '2006-06-18', 'H', 'joshuarasamoely@gmail.com', 'Antananarivo', 'mdp1', 'joshua.jpg'),
('Mihaja RANDRIANASOLO', '2006-07-16', 'H', 'mihajatianarivo@gmail.com', 'Antananarivo', 'mdp2', 'mihaja.jpg'),
('Soraya RAJAONARY', '2004-11-07', 'F', 'sorayara@gmail.com', 'Paris', 'mdp3', 'soraya.jpg'),
('Aymeric RAKOTO', '2006-07-25', 'H', 'aymericrakoto@gmail.com', 'Paris', 'mdp4', 'aymeric.jpg');

update EMPRUNTS_membres set genre = 'H' where id_membre = 4;

INSERT INTO EMPRUNTS_categorie_objet (nom_categorie) VALUES
('esthétique'),
('bricolage'),
('mécanique'),
('cuisine');


INSERT INTO EMPRUNTS_objet (nom_objet, id_categorie, id_membre) VALUES
('Sèche-cheveux', 1, 1),
('Lisseur', 1, 1),
('Trousse de maquillage', 1, 1),
('Perceuse', 2, 1),
('Tournevis', 2, 1),
('Clé à molette', 3, 1),
('Batteur électrique', 4, 1),
('Mixeur', 4, 1),
('Casserole', 4, 1),
('Poêle', 4, 1),

('Ponceuse', 2, 2),
('Marteau', 2, 2),
('Scie sauteuse', 2, 2),
('Cric', 3, 2),
('Pompe à vélo', 3, 2),
('Cafetière', 4, 2),
('Grille-pain', 4, 2),
('Bouilloire', 4, 2),
('Brosse à cheveux', 1, 2),
('Rasoir électrique', 1, 2),

('Trousse de manucure', 1, 3),
('Fer à friser', 1, 3),
('Pistolet à colle', 2, 3),
('Tournevis électrique', 2, 3),
('Clé dynamométrique', 3, 3),
('Pompe à air', 3, 3),
('Robot pâtissier', 4, 3),
('Moulin à café', 4, 3),
('Fouet', 4, 3),
('Spatule', 4, 3),

('Brosse lissante', 1, 4),
('Tondeuse', 1, 4),
('Perceuse-visseuse', 2, 4),
('Scie circulaire', 2, 4),
('Cric hydraulique', 3, 4),
('Compresseur', 3, 4),
('Blender', 4, 4),
('Cocotte-minute', 4, 4),
('Poêle à crêpes', 4, 4),
('Couteau de chef', 4, 4);




INSERT INTO EMPRUNTS_emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 2, '2024-05-01', '2024-05-10'),
(5, 3, '2024-05-02', '2024-05-12'),
(12, 1, '2024-05-03', '2024-05-13'),
(15, 4, '2024-05-04', '2024-05-14'),
(22, 2, '2024-05-05', '2024-05-15'),
(28, 3, '2024-05-06', '2024-05-16'),
(33, 1, '2024-05-07', '2024-05-17'),
(36, 4, '2024-05-08', '2024-05-18'),
(39, 2, '2024-05-09', '2024-05-19'),
(40, 3, '2024-05-10', '2024-05-20'); 


