# Type microservice

Frontend

## Technologies Utilisées [composer.json]

- Docker

## Installation PRE-PROD

- git clone https://gitlab.com/cab-ceipi/client/congo/pointe-noire/servtech/satisfaction-client1/infra.git

- docker login registry.gitlab.com

- docker compose pull

- docker compose down

- docker compose up -d

- Ouvrir VSCODE

- Sur le côté gauche, cliquer sur ouvrir les contenaires en cours puis selectionner " appfrontend ".

- Installer GITLENS Extension

- Supprimer l'ancienne connexion à GITLAB

- Installer : git remote add gitlab https://gitlab.com/cab-ceipi/client/congo/pointe-noire/servtech/satisfaction-client1/backend.git

- Installer votre branche 

# Gestion de tâche

Le triage d'une tâche est un processus en plusieurs étapes qui est exécuté en collaboration par les chef de projets et les développeurs. L'objectif du triage est de vous fournir une compréhension claire de ce qui arrivera à votre problème. Par exemple, une fois que votre demande de fonctionnalité a été triée, vous savez si nous prévoyons de résoudre le problème / fonctionnalités ou si nous attendrons de savoir ce que l'équipe élargie pense de cette demande.

## Notre flux de triage

Vous trouverez ci-dessous le flux de base de votre tâche. À n'importe quelle étape du flux, nous pouvons également fermer la tâche ou demander plus d'informations. 

Le graphique utilise six états principaux. Ils sont facilement identifiables :

|État|À quoi ressemble votre tâche|
|---|---|
|Discussion|Nous discutons sur la pertinence de la tâche `Discussion`|
|Wait|A l'attente d'un milestone ou un sprint `Wait`|
|To DO|A faire ,attribuer à un développeur , disponibilité de la branch et un merge Request `To DO`|
|Doing|En cours de traitement `Doing`|
|Done|A l'attente de validation pour un MergeRequest `Done`|

Dans le reste de ce document, nous détaillerons chacune des activités de triage et la façon dont nous prenons des décisions.

## Git Workflow
- Main
- Production
- Main-webtinix

Une nouvelle tâche prend comme source la branche Main sauf les cas urgences comme `BugFix`.

Main-webtinix est utilisé par la société de prestation WEBTINIX

## Déploiement

On peut faire le déploiement depuis main et production avec la variable d'environnement deploy=1

## Problèmes de fermeture

Nous fermons les problèmes pour les raisons suivantes :

|Raison|Libellé|
|---|---|
|Le problème est obsolète ou déjà résolu. | `Obsolete` |
|Nous n'avons pas reçu les informations dont nous avons besoin. | `Need Info` |
|C'est un doublon d'une autre tâche. | `*Dupliquer`|
|Ce qui est décrit est le comportement conçu. | `*Normal` |
|Le problème n'est pas lié aux objectifs de notre projet et/ou ne peut donc pas être résolu| `*hors-sujet`|
|Le problème ne contient aucune information valide ou utile ou n'était pas intentionnel.| `invalide` |
|Compte tenu des informations dont nous disposons, nous ne pouvons pas reproduire le problème. | `*non-reproductible`|

## Demander une information

Si un problème manque d'informations dont nous avons besoin pour comprendre le problème, nous attribuons l'étiquette "besoin de plus d'informations". Nous ajoutons généralement le commentaire `/Need Info` à la tâche.

## Catégorisation des problèmes

Chaque problème doit avoir une étiquette **type**. 

|Type|Description|
|---|---|
|`Need Info` | impossible d'attribuer une plaque signalétique en raison d'informations manquantes |
|`Bug` | l'implémentation d'une fonctionnalité n'est pas correcte |
|`feature-request`| demande de nouvelle fonctionnalité|
|`under-discussion` | pas décidé si le problème est un bogue ou une fonctionnalité |
|`Question` | nous devrions adresser les questions à StackOverflow |
|`devops` | problèmes liés à notre système d'ingénierie ou à nos processus |
|`improve` | une fonctionnalité peut être améliorée, mais pas nécessairement un bug|

Nous utilisons également les étiquettes **type** pour les languages , technologies ...

## Problèmes importants

- Nous attribuons le label `important` aux problèmes qui
  - entraîner une perte de données
  - sécurité critique, problèmes de performances
  - Problème d'interface utilisateur qui rend une fonctionnalité inutilisable
- Nous attribuons le label `BugFix` aux problèmes 
  - Bug sur la version en production

## Caractéristiques spécifiques au type / Triage

### Ne résoudra pas les bogues

Nous fermons les bogues comme `wont-fix` s'il y a un rapport coût-bénéfice négatif. Lorsque nous fermons un bogue en tant que `wont-fix`, nous expliquerons pourquoi nous le faisons.

