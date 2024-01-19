# partiel_php

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






### Ajouter une question :
1. Accédez à la page `add_question.php`.
2. Remplissez le formulaire avec les détails de votre question, y compris la question elle-même, la réponse attendue, le message de succès et le message de mauvaise réponse.
3. Soumettez le formulaire.

Après avoir soumis le formulaire, une nouvelle question est ajoutée à la base de données, et le site générera un lien unique pour cette question. Vous pouvez copier et partager ce lien pour permettre à d'autres personnes de répondre à la question.

### Répondre à une question :
1. Utilisez le lien généré après avoir ajouté une question ou accédez à la page `answer_question.php`.
2. Sur cette page, vous verrez la question, un champ de texte pour saisir la réponse et un bouton "Valider".
3. Saisissez la réponse dans le champ de texte et cliquez sur "Valider".
4. Le site vous montrera le pourcentage de réussite de la question ainsi que le message correspondant à votre réponse.

### Lister les questions :
1. Accédez à la page `list_questions.php`.
2. Vous verrez une liste de toutes les questions existantes avec leur taux de réussite associé.
3. Utilisez l'option de tri pour organiser les questions par pourcentage de réussite (croissant ou décroissant).

### Supprimer une question :
1. Sur la page `list_questions.php`, vous verrez une liste de questions avec un bouton "Supprimer" à côté de chaque question.
2. Cliquez sur le bouton "Supprimer" de la question que vous souhaitez supprimer.
3. La question sera supprimée de la base de données, et la page sera automatiquement actualisée.

**Note :** Les actions de suppression sont effectuées directement, sans confirmation, comme spécifié dans les consignes. Soyez prudent lorsque vous supprimez une question, car cela ne peut pas être annulé.

Cela devrait vous aider à naviguer et utiliser les fonctionnalités du site. Si vous avez des questions spécifiques ou rencontrez des problèmes, n'hésitez pas à les partager pour que je puisse vous aider davantage.