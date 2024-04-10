# Pokedex

Ce projet est un Pokedex développé en PHP. Il permet aux utilisateurs de rechercher des informations sur différents Pokémon de la première génération, y compris leurs types et leurs capacités (uniquement les 18 premiers pokémons de la liste). Les utilisateurs connectés peuvent se confectionner leur propre pokedex. Ce projet suit un TP de BDD-IHM avec une base de donnée imposé ce qui explique le manque d'information. 

## Fonctionnalités

- Affichage des pokémons de la première génération
- Affichage des détails d'un Pokémon spécifique
- Affichage des types et des capacités d'un Pokémon
- Affichage des pokémons attrapé/vu par le dresseur(utilisateur)
- Interface utilisateur simple

## Prérequis

- [XAMPP](https://www.apachefriends.org/index.html) doit être installé.
- Ou tout type de base de donné

## Installation

1. Clonez ce dépôt dans le répertoire de votre serveur web : 'https://github.com/FlorianCliquet/Pokedex"
2. Assurez-vous que XAMPP est démarré. Vous pouvez démarrer Apache et MySQL en exécutant `/opt/lampp/lampp start` dans votre terminal.
3. Ouvrez votre navigateur web et accédez à l'URL `http://localhost/pokedex` pour accéder au Pokedex.
4. 
## Utilisation - Non connecté
  - Index.php
Affichage de tous les pokémons de la base de donné (1ère génération)
![Index.php Non connecté](assets/Images/README/GLOBALINDEX.png)

  - Pokemon.php
Si l'on clique sur une image d'un pokémon d'Index.php nous pouvons avoir accès à ses caractéristiques
![Pokemon.php Non connecté](assets/Images/README/GLOBALPOKEMON.png)

## Utilisation - connecté
  - Index.php
Affichage tous les pokémons de la base de donné (1ère génération) , le header change en Pokedex de [nom_dresseur] et on peut voir si le pokémon est attrapé(pokeball rouge) / vu(pokeball noir et blanche) / non vu(image opaque) par le dresseur
![Index.php Connecté](assets/Images/README/INDEX.png)
![Index.php blurred Pokemon](assets/Images/README/INDEXCHANGED.png)

  - Pokemon.php
Si l'on clique sur une image d'un pokémon d'Index.php, nous pouvons toujours avoir accès à ses caractéristiques mais aussi aux statistiques liés au pokedex du dresseur, nombre de fois que l'on l'a vu / attrapé , et si il n'est pas vu nous pouvons l'ajouter directement à notre pokedex
![Pokemon.php Connecté](assets/Images/README/POKEMON.png)

  - Pokedex.php
On peut aussi changer les valeurs liés à un pokémon dans pokedex.php,
![Pokedex.php Connecté](assets/Images/README/POKEDEX.png)

## Login-Register
  - Login.php
On peut se connecter grâce à l'email renseigné ou le nom de dresseur
![Login.php](assets/Images/README/LOGIN.png)

  - Register.php
Pour s'inscrire, il faut donner l'email / nom de dresseur / mot de passe. Le mot de passe est hashé quand il est conservé dans la base de donné pour sécuriser le mot de passe de l'utilisateur
![Register.php](assets/Images/README/REGISTER.png)

  - forgot-password.php
Si jamais l'utilisateur à oublié son mot de passe, il peut le réinitialiser grâce à un email envoyé par le serveur SMTP gmail
![Forgot-password.php](assets/Images/README/FORGOTPASSWORD.php)

## Contribuer

Les contributions sont les bienvenues ! Si vous souhaitez améliorer ce projet, veuillez suivre les étapes suivantes :

1. Fork ce dépôt.
2. Créez une branche pour vos fonctionnalités : `git checkout -b feature/NouvelleFonctionnalite`.
3. Commitez vos changements : `git commit -am 'Ajouter une nouvelle fonctionnalité'`.
4. Poussez la branche : `git push origin feature/NouvelleFonctionnalite`.
5. Créez une Pull Request.

## Auteur

Ce projet a été développé par [Florian Cliquet].

## Licence

Ce projet est sous licence MIT. Consultez le fichier LICENSE.md pour plus de détails.
