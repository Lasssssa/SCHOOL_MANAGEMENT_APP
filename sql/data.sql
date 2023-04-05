
DELETE FROM Commande;
DELETE FROM client;
DELETE FROM Produit;
DELETE FROM Est_Constitue;

-- --- Populate auteur table ------------
INSERT INTO client (nom, prenom, email, passwordUser, adresse_ville, code_postale) VALUES
('Porodo', 'Theo','theoporodo@gmail.com','$2y$10$HG4aZMy3lk0nSWweFN.UKOv4XkTfNDs0VfFKzhba3/CIFfx6oz2m2','16 rue de la Métairie',44700);

-- --- Populate siecle table ------------
INSERT INTO Produit (reference,prix,designatiion,quantite_stock,tva) VALUES
(123456,100,'Jambon Beurre',150,0.25),
(789456,4,'Tomate Oignons',200,0.25),
(147852,6,'Rosette Cornichons',250,0.25),
(369852,10000,'Jambon Ketchup',10,0.25),
(123789,5,'Poulet fri',20,0.25);

