naoP5
=====

A Symfony project created on December 14, 2017, 12:41 pm.

Brief client
=============
Michel Dujardin est le fondateur de l’association NAO (Nos Amis les Oiseaux), regroupant les passionnés d’ornithologie. Il souhaite créer une application participative dans laquelle les particuliers pourraient indiquer où ils ont observé des oiseaux au cours de leurs promenades.‌

Les participants prendront part à un programme de recherche visant à étudier les effets du climat, de l’urbanisation et de l’agriculture sur la biodiversité.

Les utilisateurs principaux de l’application sont les particuliers et les naturalistes (professionnels) qui valident notamment les saisies sur l’application. Ces derniers ont exprimé leur intérêt pour pouvoir effectuer de la saisie sur le terrain et ouvrir les observations aux particuliers, grâce aux smartphones. Néanmoins, tout le monde n’étant pas équipé de smartphones, cela ne peut pas être l’unique méthode de saisie : une interface web sera aussi nécessaire. 

L’application doit permettre :

De rechercher les différentes espèces d’oiseaux parmi la base de données (téléchargement via la base de données TAXREF du Muséum National d’Histoire Naturelle, classe « Aves »)

De les afficher sur une carte (après filtre par espèce)

De saisir une « observation » d’un oiseau sur le terrain, avec nom, date, coordonnées GPS et photo facultative.

De valider les observations des particuliers (uniquement avec un compte naturaliste).

Les observations effectuées par les particuliers doivent être validées par les naturalistes pour être ensuite affichées à tous. Chaque compte utilisateur appartient soit au groupe « particulier » soit au groupe « naturaliste » afin de leur donner des droits d’accès différents sur l’application. Les naturalistes peuvent eux aussi effectuer des saisies, qui ne nécessitent pas de validation.

Le Projet
==========
Ce projet entre dans le cadre de la formation "Chef de Projet Multimédia" sur OpenClassRooms.

Comment puis-je obtenir le code source du projet?
==================================================
Cloner le repository sur votre machine depuis le lien : https://5Legends@bitbucket.org/5-Legends/nao.git

Installation du projet :
=======================
Avant tout vous deverez installer composer si cela n'est pas encore fait, 
suivez la documentation pour installer composer selon votre système d'exploitation : https://getcomposer.org/doc/00-intro.md

**1- Installer Symfony3 :**
Dans le dossier du projet ouvrez une console (linux click droit / ouvrez dans le terminal, et sur windows Shift+click droit / ouvrez une console ici)
dans la console taper la commande suivante :
composer install  // Si composer et installer en global
Ou
php composer.phar install  // Si composer est installé en local
à la fin de l'installation Symfony vous demande de configurer le fichier parameters.yml
les paramètres de la base de données et du serveur SMTP 

**2- Créer votre Base de Données :**
Méthode 1 :
Toujours sur la console taper les trois commandes suivantes
- php bin/console doctrine:database:create
- php bin/console doctrine:schema:update --dump-sql
- php bin/console doctrine:schema:update --force

Méthode 2 :
Sur la console taper la commande suivante
- php bin/console doctrine:database:create
Connectez- vous sur votre Base de données avec PhpMyAdmin
dans le menu Import choisissez le fichier nao.sql situé dans le dossier web/fichiers du projet.
Voila si tout se passe bien le site et prét et vous pouvez le consulter.

Utilisation du site :
======================
**1- Faire une Recherche**
La Recherche avec auto complétion : sur la page d'accueil, commencer à taper les trois premières lettres de votre Recherche, une liste s'affiche avec les resultats trouvés à partir des trois premières lettres.
Vous pouvez choisir l'oiseau que vous cherchez s'il apparait sur la liste, s'il n'existe pas continuer à taper plus de caractères pour affiner le resultat de la recherche.
une fois l' oiseau trouvé clicker dessus une page s'affichera avec une Mapp avec des Marques, si cet oiseau à déjà des observations, sinon la Mapp sera vide.
vous pouvez cliquer sur les Marques de la Mapp pour visualiser les observations.
Si aucun oiseau n'est trouvé un message "Aucune espèce trouvée" s'affichera.

 **2- Ajouter une observation** 
 Pour ajouter des observations vous devez vous connecter sur votre espace personnel, si vous n'êtes pas encore inscrit créer un compte utilisateur.
 pendant l'inscription deux options sont disponibles soit vous créez votre compte sur le site soit vous pouvez vous inscrire avec votre compte Facebook, Google ou Twitter.
 une fois connecté dans le menu déroulant "Votre compte" choisissez Ajouter une observation.
 une fois sur la page "Faire une observation" le navigateur vous demandera d'accepter la géolocalisation pour une géolocalisation automatique.
 Si vous refusez la géolocalisation automatique vous pouvez introduire vos cordonnées gps manuellement en cochant "Localisation manuelle".
 pour le nom de l'oiseau une fois de plus le système d'auto complétion et utilisez la comme la partie Recherche.
 une fois que vous validez votre observation ;elle sera en attente de validation par un naturaliste qui sera directement informé par l'ajout de votre observation.
 
 **3- Validation des observations**
 Seuls les naturalistes auront accés à cette fonctionnalité depuis leur compte utilisateur dans le bloc "Observation en attente".
 le naturaliste aura le droit de vérifier les observations, les valider ou les supprimer définitivement.
 