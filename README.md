# partiel_php

## Table des matières

CREATE TABLE `escape_game_db`.`questions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question` VARCHAR(255) NULL,
  `reponse_attendue` VARCHAR(255) NULL,
  `message_succes` VARCHAR(255) NULL,
  `message_mauvaise_reponse` VARCHAR(255) NULL,
  `taux_reussite` VARCHAR(45) NULL,
  `tentatives_totales` INT NOT NULL DEFAULT 0,
  `tentatives_reussies` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);
## Installation

1. Cloner le dépôt : `git clone https://github.com/votre-utilisateur/votre-projet.git`
2. Aller dans le répertoire du projet : `cd votre-projet`
3. Installer les dépendances : `composer install` (ou tout autre commande d'installation des dépendances)
4. Configurer le fichier `config.php` avec les informations appropriées.

## Utilisation

1. Assurez-vous que votre serveur web est configuré correctement.
2. Accédez au projet via votre navigateur.
3. Suivez les instructions sur la page pour répondre aux questions.

## Utilisation du Site

1. **Répondre à une question :** Lorsque vous arrivez sur la page, aucune question n'est affichée initialement. Cliquez sur le bouton "Nouvelle Question" pour charger une question aléatoire.

2. **Formulaire de réponse :** Une fois la question affichée, un formulaire avec un champ de réponse sera visible. Entrez votre réponse dans le champ et cliquez sur le bouton "Valider" pour soumettre votre réponse.

3. **Affichage du Résultat :** Après avoir soumis votre réponse, le résultat de votre réponse sera affiché. Si la réponse est correcte, un message de succès sera affiché. Sinon, un message d'erreur sera affiché.

4. **Changer de Question :** Si vous souhaitez changer la question actuelle, cliquez sur le bouton "Nouvelle Question" pour en charger une autre aléatoirement.

5. **Pourcentage de Réussite :** Le pourcentage de réussite actuel est affiché en bas de la page.

6. **Quitter :** Vous pouvez quitter la session en cliquant sur le bouton "Quitter", cela vous redirigera vers une autre page.

Note : Assurez-vous d'activer les cookies dans votre navigateur pour une expérience utilisateur optimale.
