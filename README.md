-------------------------------------------------------FRANCAIS | FRENCH--------------------------------------------------------
# My_E_TimeSheet

### Nom projet : My E-TimeSheet<br />
### Equipe : <br />
- Mélanie GALVAN<br />
- Yann BOURGUES

### Environnement de développement :
* **FrameWork :** Symfony 2 (https://symfony.com/)
* **Base de données :** MySQL (inclu dans EasyPHP)
* **SGBDR :** PhpMyAdmin (inclu dans EasyPHP)
* **IDE :** PhpStorm
* **ORM :** Doctrine
* **Gestion de dépendances :** Composer
* **Gestion de logs :** Monolog 
* **Gestion des tests :** PhpUnit

## Ojectif
1. Dématérialiser la feuille de présence
2. Optimiser et automatiser le processus "présence" pour gagner en efficacité et en temps, être éfficient.
3. Réduire les coûts en papier (archivage, gestion des dossiers, ...)
4. Centraliser toutes les informations pour qu'elles soient accessibles par tous

## Fonctionnalités principales
**Partie Administrateur**
* Gestion des promotions
* Gestion du personnel
* Gestion des étudiants
* Gestion des conventions
* Gestion des matières

**Partie Utilisateur**
* Créer une feuille de présence (délégué)
* Signaler sa présence (étudiant)
* Signaler enseignant absent (délégué)
* Valider le cours (enseignant)
* Voir détails des heures effectuées (responsable)
* Editer une facture pour le CFA (responsable)

## Installation 
1. Clone du répository
```
$ git clone https://github.com/MikeYankee/My_E_TimeSheet
```
2. Créer la base de données "my_ets"
 Se placer à la racine du projet et exécuter la commande suivante :
```
php app/console doctrine:schema:update --force
```
3. Modifier le fichier app/config/parameters.yml en indiquant les différentes informations de connexion à la base de données.
```
...
database_host: 127.0.0.1
database_port: 3306
database_name: my_ets
database_user: root
database_password: null
...
```
Des fonctionnalités sont à venir !
---------------------------------------------------------ANGLAIS | ENGLISH------------------------------------------------------
# My_E_TimeSheet

### Project Name : My E-TimeSheet<br />
### Team : <br />
- Mélanie GALVAN<br />
- Yann BOURGUES

### Development Environment :
* **FrameWork :** Symfony 2 (https://symfony.com/)
* **Database :** MySQL (inclu dans EasyPHP)
* **SGBDR :** PhpMyAdmin (inclu dans EasyPHP)
* **IDE :** PhpStorm
* **ORM :** Doctrine
* **Dependency Management :** Composer
* **Logs Management :** Monolog 
* **Tests Management :** PhpUnit

## Goal
1. Dematerialize timesheet
2. Optimize et computerize process "Presence" to increase efficiency, save time, be efficient.
3. Reduce paper costs (archiving, file management, ...)
4. Centralize information for them to be accessible for anyone.

## Primary Features
**Admin Features**
* class Management
* Staff Management
* Student Management
* Covenant Management
* Subject Management

**User Features**
* Create E-TimeSheet (Class representative)
* Reports its presence (student)
* Reports teacher absence (Class representative)
* Validate the course (teacher)
* See details of hours worked (responsable)
* Edit an invoice for CFA(responsable)

## Setup 
1. clone the repository
```
$ git clone https://github.com/MikeYankee/My_E_TimeSheet
```
2. Create database "my_ets"
 Go to the of the project and run the following command :
```
php app/console doctrine:schema:update --force
```
3. Update and complete file app/config/parameters.yml with information of connection to database.
```
...
database_host: 127.0.0.1
database_port: 3306
database_name: my_ets
database_user: root
database_password: null
...
```
Some new features coming soon !
