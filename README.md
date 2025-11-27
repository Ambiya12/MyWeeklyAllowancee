# Test Unitaire TDD

## Groupe : Dupuis Anatole, TU Antoine, Galystan Ambiya Dimas

## Installation

### Prérequis

- PHP 8.4+
- Composer
- Xdebug (pour la couverture de code)

### Étapes d'installation

1. Cloner le projet :

```bash
git clone https://github.com/Ambiya12/MyWeeklyAllowancee.git
cd MyWeeklyAllowancee
```

2. Installer les dépendances :

```bash
composer install
```

## Lancer les tests

Exécuter tous les tests unitaires :

```bash
./vendor/bin/phpunit
```

## Couverture de code

Les tests génèrent automatiquement un rapport de couverture HTML dans le dossier `coverage/`.

Pour visualiser le rapport de couverture :

```bash
php -S localhost:8080 -t coverage
```

Puis ouvrir http://localhost:8080 dans votre navigateur.

## Projet MyWeeklyAllowance

Vous allez concevoir un module de gestion d’argent de poche pour adolescents, selon la méthode TDD (Test Driven Development).
Votre mission : commencer par les tests unitaires, puis développer le code étape par étape jusqu’à ce que tous les tests passent.

## Contexte du projet : MyWeeklyAllowance

L’application MyWeeklyAllowance permet aux parents de gérer un “porte-monnaie virtuel” pour leurs ados.
Chaque adolescent a un compte d’argent de poche, et chaque parent peut :

- créer un compte pour un ado,
- déposer de l’argent,
- enregistrer des dépenses,
- fixer une allocation hebdomadaire automatique.

## Organisation

- Phase 1 – Rédaction des tests unitaires (RED)
- Phase 2 – Implémentation du code (BLUE)
- Phase 3 – Refactoring (GREEN)
- Phase 4 – Vérification de la couverture
