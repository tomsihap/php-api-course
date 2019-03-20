# WebServices et API REST

- [WebServices et API REST](#webservices-et-api-rest)
	- [# Généralités et théorie](#g%C3%A9n%C3%A9ralit%C3%A9s-et-th%C3%A9orie)
	- [1. Définitions et rappels](#1-d%C3%A9finitions-et-rappels)
		- [L'Internet](#linternet)
		- [Le web](#le-web)
		- [Fonctionnement du web](#fonctionnement-du-web)
		- [Ressources](#ressources)
	- [2. Les API](#2-les-api)
		- [Qu'est-ce qu'une API ?](#quest-ce-quune-api)
		- [L'architecture REST](#larchitecture-rest)
		- [Fonctionnement et contraintes d'une API REST](#fonctionnement-et-contraintes-dune-api-rest)
			- [Client/Server](#clientserver)
			- [Stateless](#stateless)
			- [Cachable](#cachable)
			- [Layered System](#layered-system)
			- [Uniform Interface](#uniform-interface)
			- [Code On Demand (facultative)](#code-on-demand-facultative)
		- [Quelques formats hypermédias: XML, JSON, DOM, SAX et Xpath](#quelques-formats-hyperm%C3%A9dias-xml-json-dom-sax-et-xpath)
			- [Représentations de données](#repr%C3%A9sentations-de-donn%C3%A9es)
			- [Des APIs XML :](#des-apis-xml)
	- [3. Le protocole HTTP](#3-le-protocole-http)
		- [Implémentation](#impl%C3%A9mentation)
			- [URI, URL](#uri-url)
			- [Méthodes](#m%C3%A9thodes)
			- [Request](#request)
			- [Response](#response)
			- [Codes de status](#codes-de-status)
				- [Typologie](#typologie)
				- [Quelques codes fréquents](#quelques-codes-fr%C3%A9quents)
			- [Documentation d'un WS REST](#documentation-dun-ws-rest)
			- [WebServices, REST et SOAP](#webservices-rest-et-soap)

# Généralités et théorie
---
## 1. Définitions et rappels

> Lien : Suite de protocoles Internet : [TCP/IP (Wikipédia)](https://fr.wikipedia.org/wiki/Suite_des_protocoles_Internet)


### L'Internet
> L'Internet est un réseau mondial associant des ressources de télécommunication et des ordinateurs serveurs et clients, destiné à l’échange de messages électroniques, d’informations multimédias et de fichiers. L’accès au réseau est ouvert à tout utilisateur ayant obtenu une adresse auprès d’un organisme accrédité. ([service-public.fr - J.O. du 16 mars 1999](https://www.service-public.fr/particuliers/actualites/A13284))

### Le web

> Lien:  [w3c : World Wide Web Consortium](https://www.w3.org/)


Le web, inventé à la fin des années 1980 par Sir Tim Berners-Lee et Robert Cailliau, est une des technologies de la couche [Application (Wikipédia)](https://fr.wikipedia.org/wiki/Couche_application) de TCP/IP, il en existe bien d'autres, ils sont distingués notamment protocoles : e-mails (SMTP, POP, IMAP...), communication et sessions distantes (Telnet, SSH...), transfert de fichiers (FTP...);

### Fonctionnement du web

Le web est donc une application d'Internet, un ensemble de technologies permettant de consulter et gérer des ressources distantes :

> Un **hôte**, le **client** accède à une **ressource** du **Web** via le protocole **HTTP** - 80 (ou HTTPS - 443, avec authentification et chiffrement), en envoyant une **requête** à une **URI** (**URL** + **URN**), pointant vers un hôte **serveur**, lequel renvoie une **réponse**.

### Ressources

Plusieurs types de ressource sont possibles :
- Constutiants d'une page web : documents HTML, images, scripts (JS, CSS), sons, vidéos ;
- Applets (binaires executés dans la page web - Java, Flash, Silverlight...)
- Documents séparés, autonomes : PDF, fichier Word, Excel, fichiers divers...
- Autres : voir les [schémas d'URI](https://fr.wikipedia.org/wiki/Sch%C3%A9ma_d%27URI)

---
## 2. Les API

### Qu'est-ce qu'une API ?

> "APIs are like User Interfaces -- Just with different users in mind" - [ProgrammableWeb (What are APIs and how do they work)](https://www.programmableweb.com/api-university/what-are-apis-and-how-do-they-work)


> "Une API (Application Programming Interface) est un ensemble de classes, méthodes et fonctions qui sert de façade par laquelle un logiciel offre des services à d'autres logiciels." [API - Wikipédia](https://fr.wikipedia.org/wiki/Interface_de_programmation)

En pratique, il s'agit d'une série d'outils propres à une application nous permettant de communiquer avec elle : une API de météo comme [OpenWeatherMap](https://openweathermap.org/api) nous permettrait d'accéder à la météo d'une ville donnée à une date donnée via des fonctions définies et documentées. L'[API de Métromibilité](https://www.metromobilite.fr/pages/opendata/OpenDataApi.html) nous permet d'accéder aux horaires des transports grenoblois.

Nous pouvons ainsi utiliser des outils déjà développés (que ce soit pour du calcul, du traitement ou de la consultation de données par exemple, les usages sont virtuellement infinis [(ProgrammableWeb - API Directory)](https://www.programmableweb.com/apis/directory) : et cela via un fonctionnement documenté, et idéalement standardisé, dans nos propres applications, sans avoir à réinventer la roue.

Une API n'est pas forcément externe : nous pouvons aussi en créer au sein de notre propre application afin de standardiser l'utilisation des ressources : on parle d'architecture microservices ou Service Oriented Architecture :
- créer des utilisateurs
- ajouter des produits à un panier
- modifier une fiche produit
- supprimer un article
- ajouter une catégorie à un post...


### L'architecture REST

REST (Representational State Transfer) est une architecture : ce n'est donc pas un protocole mais une manière d'organiser et de créer une API. Cette architecture est souvent associée à l'architecture microservices.

Le fait d'organiser son API en REST permet de la rendre prévisible : les autres utilisateurs (développeurs) s'attendent ainsi à un comportement attendu de votre API !

### Fonctionnement et contraintes d'une API REST

#### Client/Server
Les responsabilités sont séparées entre le client et le serveur : concrètement, il s'agit d'avoir un client (le navigateur, la partie front du site web) qui envoie une requête à un serveur (une base de données, la partie back de l'application web), laquelle retourne une réponse. Le serveur doit également être capable de gérer des requêtes venant de plusieurs clients à la fois.

#### Stateless
Le serveur ne doit pas conserver en mémoire ce qui s'est passé à une précédente requête (pas de conservation de l'état de session). Par exemple, lors d'une requête authentifiée, le serveur ne doit pas mettre en cache l'authentification du client (bien que cette exception soit usuelle), c'est au client de gérer cette mise en cache (le front-end par exemple).
Cela oblige à des requêtes complètes et et des réponses identiques.

#### Cachable
Les réponses à une requête identique doivent mettre à profit le cache HTTP afin de réduire le temps de génération d'une réponse et la performance du système: un même traitement pour une même réponse HTTP ne devrait pas être généré deux fois. La mise en cache peut être définie afin d'éviter au client de recevoir des données obsolètes.

#### Layered System
Le client ne doit pas se soucier de s'il est sur le serveur final ou sur un serveur intermédiaire, ni du fonctionnement interne de l'API.

#### Uniform Interface
Cette contrainte oblige l'architecture à avoir des ressources qui puissent évoluer indépendamment :

- **Identification des ressources dans les requêtes** : concrètement, pour accéder l'utilisateur #1, nous pourrons aller à l'URI `/users/1`. Cette URI ne doit nous retourner qu'une seule ressource, unique.

- **Représentation de la ressource** : les données retournées sont des représentations de la donnée réelle (la réponse peut être en JSON, XML, HTML... elle est différente de la donnée en base de données), néanmoins ces représentations doivent être suffisamment complète pour manipuler la donnée (update, delete...).

- ** Auto-description de la ressource** : la réponse doit indiquer le format de la réponse (header HTTP: Content-Type (application/json par exemple)).

#### Code On Demand (facultative)
L'idée est de demander à l'API un morceau de code pour que celui-ci soit exécuté par le client. Cela réduit le nombre de fonctionnalités à implémenter au client par défaut mais réduit la visibilité de l'organisation des ressources.

### Quelques formats hypermédias: XML, JSON, DOM, SAX et Xpath


#### Représentations de données
> **XML** : L'Extensible Markup Language, généralement appelé XMLnote 1, « langage de balisage extensible1 » en français, est un métalangage informatique de balisage générique qui est un sous-ensemble du Standard Generalized Markup Language (SGML). Sa syntaxe est dite « extensible » car elle permet de définir différents langages avec chacun leur vocabulaire et leur grammaire, comme XHTML, XSLT, RSS, SVG… Elle est reconnaissable par son usage des chevrons (<, >) encadrant les noms des balises. L'objectif initial de XML est de faciliter l'échange automatisé de contenus complexes (arbres, texte enrichi, etc.) entre systèmes d'informations hétérogènes (interopérabilité). [Wikipédia](https://fr.wikipedia.org/wiki/Extensible_Markup_Language)

> **JSON**: JavaScript Object Notation (JSON) est un format de données textuelles dérivé de la notation des objets du langage JavaScript. Il permet de représenter de l’information structurée comme le permet XML par exemple. Créé par Douglas Crockford entre 2002 et 2005, il est actuellement décrit par deux normes en concurrence: RFC 8259 de l’IETF et ECMA-404 de l'ECMA. [Wikipédia](https://fr.wikipedia.org/wiki/JavaScript_Object_Notation)


#### Des APIs XML :


> **DOM**: Le Document Object Model (DOM) est une interface de programmation normalisée par le W3C, qui permet à des scripts d'examiner et de modifier le contenu du navigateur web. Par le DOM, la composition d'un document HTML ou XML est représentée sous forme d'un jeu d'objets – lesquels peuvent représenter une fenêtre, une phrase ou un style, par exemple – reliés selon une structure en arbre. À l'aide du DOM, un script peut modifier le document présent dans le navigateur en ajoutant ou en supprimant des nœuds de l'arbre. [Wikipédia](https://fr.wikipedia.org/wiki/Document_Object_Model)

> **XPath** : XPath est un langage de requête pour localiser une portion d'un document XML. Initialement créé pour fournir une syntaxe et une sémantique aux fonctions communes à XPointer et XSL, XPath a rapidement été adopté par les développeurs comme langage d'interrogation simple d'emploi. [Wikipédia](https://fr.wikipedia.org/wiki/XPath)

> **SAX** : Simple API for XML ou SAX est une interface de programmation pour de nombreux langages permettant de lire et de traiter des documents XML. [Wikipédia](https://fr.wikipedia.org/wiki/Simple_API_for_XML)

---
## 3. Le protocole HTTP

HTTP est un protocole entre deux machines. Une API est en fait une application de ce protocole, gérant la récéption d'une *Request* HTTP et l'envoi d'une *Response* HTTP.

### Implémentation

#### URI, URL

> URI : Uniform Ressource Identifier, identifie une ressource : `/users/54`

> URL : Uniform Resource Locator, localise une ressource : `http://www.example.com/users/54`

#### Méthodes

Une méthode HTTP est une commande qui spécifie le type de la requête, c'est à dire quelle action est demandée au serveur sur l'URI requêtée.

Par exemple, nous demandons au serveur `www.example.com` la ressource `/user/1` en GET, la méthode pour demander une ressource :

```
GET /user/1 HTTP/1.1
Host: www.example.com
```

Les méthodes les plus courantes sont :

| Méthode  | Description  |
|---|---|
| GET | Demander une ressource  |
| POST | Transmettre des données en vue d'un traitement (à l'issue d'un formulaire HTML par exemple) |
| PUT | Remplacer et ajouter une ressource sur le serveur (une mise à jour *complète* d'une ressource par exemple)  |
| PATCH | Modifier *partiellement* une ressource |
| DELETE | Supprimer une ressource  |

D'autres tout aussi utiles :

| Méthode  | Description  |
|---|---|
| HEAD | Demander des informations sur la ressource, sans demander la ressource elle-même (métadonnées)  |
| OPTIONS | Obetenir les options de communication d'une ressource ou du serveur en général  |
| TRACE | Demander au serveur de retourner ce qu'il a reçu, dans des buts de débug ou diagnostic |

#### Request
Une requête émane d'un client, et est constituée ainsi :
1. Première ligne: méthode HTTP, URI, version du protocole
2. Les entêtes (headers) : un en-tête par ligne
3. Le contenu de la requête (body)

```
POST /users HTTP/1.1
Content-Type: application/x-www-form-urlencoded
Accept: application/json

name=Luke Skywalker&job=jedi
```

#### Response
Une réponse émane d'un serveur, et est constituée ainsi :
1. Première ligne: version du protocole, code status, équivalent texte du status
2. Les entêtes (headers) : un en-tête par ligne
3. Le contenu de la réponse (body)

```
HTTP/1.1 200 OK
Date:Tue, 24 Mar 2019 14:23:43 GMT
Content-Type: application/json

{
	"id" : 45,
	"name" : "Luke Skywalker",
	"job" : "jedi"
}
```

#### Codes de status

Les codes HTTP permettent de déterminer le résultat d'une reqête et d'indiquer éventuellement une erreur au client [Wikipédia](https://fr.wikipedia.org/wiki/Liste_des_codes_HTTP).

##### Typologie

| Code  | Type  |
|---|---|
|1xx | Information  |
|2xx | Succès  |
|3xx | Redirection  |
|4xx | Erreur du client  |
|5xx | Erreur du serveur  |

##### Quelques codes fréquents

| Code | Message | Commentaire |
|---|---|---|
| 200 | OK |
| 201 | Created |
| 301 | Moved Permanently | Redirection
| 302 | Found | Redirection
| 310 | Too Many Redirects | Sans doute une boucle infinie !
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 405 | Method Not Allowed |
| 500 | Internal Server Error |
| 503 | Service Unavailable |
| 504 | Gateway Timeout |


#### Documentation d'un WS REST

Une API REST est en fait une liste d'URI à adresser à un serveur, associée à une méthode HTTP. Par exemple, voici un extrait de la documentation de l'[API Twitter](https://developer.twitter.com/en/docs/api-reference-index) :

- GET followers/ids
- POST users/report_spam
- POST collections/create
- GET collections/list

Chaque route (méthode + URI) est documentée de sorte à ce que l'utilisateur ( = le développeur) sache quels paramètres indiquer dans ces requêtes : des headers d'authentification, des données dans le body...

Une URI peut être associée à plusieurs méthodes en même temps ! Par exemple :

- GET /users/54
- PATCH /users/54
- DELETE /users/54


#### WebServices, REST et SOAP

Un Web Service est un protocole d'interface web permettant la communication et l'échange de données entre applications et systèmes hétérogènes.

Là où REST est une architecture, SOAP est un protocole d'API : le serveur est fortement lié à l'utilisation d'une API SOAP là où REST est surtout une représentation et une organisation du code, et est indépendant d'un protocole.


> REST et SOAP sont tous les deux des architectures utilisées pour fournir des services web. Contrairement à ce que l’acronyme SOAP laisse entendre (Simple Object Access Protocol), REST est souvent utilisé lorsque la simplicité de mise en oeuvre est recherchée.
> REST est lisible (pas d’enveloppe XML superflue) et facile à tester (un navigateur suffit) tout en étant facile de mise en oeuvre (un script PHP classique peut souvent être considéré comme RESTful).
> SOAP reste toutefois intégré dans de nombreux outils de développements (possibilité d’export de classes en webservices, possibilité de génération automatique de clients à partir des WSDL) et permet des contrôles forts sur les types de données attendus. [(source)](https://www.croes.org/gerald/blog/qu-est-ce-que-rest/447/)
