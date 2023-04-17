SELECT * FROM epreuve JOIN cours ON epreuve.id_matiere = cours.id_matiere JOIN classe cl ON cl.id_classe = cours.id_classe
WHERE epreuve.id_matiere = 5  ;