<body>
  <h1>Projet Blog Symfony VueJs</h1>
  <p>Ce projet est une application de blog développée avec Symfony et Vue.js. Il offre les fonctionnalités suivantes :</p>
  <ul>
    <li>Création, édition, suppression et affichage d'articles de blog</li>
    <li>Gestion des utilisateurs avec authentification et autorisation</li>
    <li>Utilisation de composants Vue.js pour une expérience utilisateur dynamique</li>
    <li>Intégration d'un éditeur de texte riche (CKEditor) pour la rédaction des articles</li>
    <li>Utilisation du routeur Vue.js pour la navigation entre les pages</li>
    <li>Gestion de l'état de l'application avec Pinia</li>
    <li>Intégration de l'API Symfony pour la récupération dynamique des données</li>
  </ul>

  <h2>Installation</h2>
  <ol>
    <li>Cloner le dépôt Git : git clone https://github.com/Narodk1/Naro-Blog.git</li>
    <li>Installer les dépendances Symfony : <code>composer install</code></li>
    <li>Installer les dépendances Vue.js : <code>npm install</code></li>
    <li>Configurer la base de données dans le fichier <code>.env</code></li>
    <li>Créer la base de données : <code>php bin/console doctrine:database:create</code></li>
    <li>Exécuter les migrations : <code>php bin/console doctrine:migrations:migrate</code></li>
    <li>Lancer le serveur de développement Symfony : <code>symfony server:start</code></li>
    <li>Lancer le serveur de développement Vue.js : <code>npm run serve</code></li>
    <li>Accéder à l'application dans votre navigateur : <code>http://localhost:8080</code></li>
  </ol>

  <h2>Utilisation</h2>
  <p>Pour commencer à utiliser l'application, vous devez créer un compte utilisateur ou vous connecter avec un compte existant. Ensuite, vous pouvez créer de nouveaux articles de blog, les éditer, les supprimer et parcourir les articles existants.</p>

  <h2>Contributions</h2>
  <p>Les contributions à ce projet sont les bienvenues. Pour contribuer, veuillez suivre ces étapes :</p>
  <ol>
    <li>Forker le dépôt</li>
    <li>Créer une branche pour votre fonctionnalité : <code>git checkout -b feature/NOM_DE_LA_FONCTIONNALITÉ</code></li>
    <li>Commiter vos modifications : <code>git commit -m "Ajout de la nouvelle fonctionnalité"</code></li>
    <li>Pousser vos modifications vers votre fork : <code>git push origin feature/NOM_DE_LA_FONCTIONNALITÉ</code></li>
    <li>Créer une pull request sur le dépôt d'origine</li>
  </ol>

  <h2>Auteurs</h2>
  <p>Ce projet a été développé par YNARO.</p>

  <h2>Licence</h2>
  <p>Ce projet est sous licence MIT. Voir le fichier <code>LICENCE</code> pour plus de détails.</p>
</body>

