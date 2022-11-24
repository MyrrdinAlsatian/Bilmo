# Documentation API BilMo

- [Documentation API BilMo](#documentation-api-bilmo)
  - [Description](#description)
  - [L'inscription](#linscription)
  - [L'authentification](#lauthentification)
      - [Demande de token:](#demande-de-token)
      - [Retour attendu](#retour-attendu)
  - [Récupérer les articles](#récupérer-les-articles)
    - [Récupérer tous les articles](#récupérer-tous-les-articles)
      - [Exemple avec javascript:](#exemple-avec-javascript)
      - [Schémas de retour](#schémas-de-retour)
    - [Récupérer un articles](#récupérer-un-articles)
      - [Exemple avec javascript:](#exemple-avec-javascript-1)
      - [Retour attendu](#retour-attendu-1)
    - [Récupérer l'ensemble des products d'une marque](#récupérer-lensemble-des-products-dune-marque)
      - [Exemple avec javascript:](#exemple-avec-javascript-2)
      - [Retour attendu](#retour-attendu-2)
  - [Gestion des clients](#gestion-des-clients)
    - [Ajouter un client](#ajouter-un-client)
      - [Exemple avec javascript:](#exemple-avec-javascript-3)
      - [Retour attendu](#retour-attendu-3)
    - [Supprimer un utilisateur](#supprimer-un-utilisateur)
      - [Exemple avec javascript:](#exemple-avec-javascript-4)
    - [Récupérer l'ensemble des clients d'un utilisateur](#récupérer-lensemble-des-clients-dun-utilisateur)
      - [Exemple avec javascript:](#exemple-avec-javascript-5)
      - [Retour attendu](#retour-attendu-4)
    - [Récupérer les détails d'un clients d'un utilisateur](#récupérer-les-détails-dun-clients-dun-utilisateur)
      - [Exemple avec javascript:](#exemple-avec-javascript-6)
      - [Retour attendu](#retour-attendu-5)

## Description
Documentation technique de relative à l’accès au catalogue via l'**API** (Application Programming Interface) B2B (business to business) **BilMo**.

## L'inscription
Lors de l'inscription au service de catalogue **Bilmo** par le service commercial, vous recevrait un identifiant unique (```@id```, ```id```) à conserver qui vous permettra de récupérer vos informations :
```json
{
    "@context": "/api/contexts/User",
    "@id": "/api/users/11",
    "@type": "User",
    "id": 11,
    "email": "SomeName@SomeEmail.xyz"
}
``` 
## L'authentification
Pour vous identifier sur **l'API BilMo** vous devez envoyer  dans le **header** de vos requêtes un Bearer Token de type JWT. Pour récupérer ce token d'accès vous devrez envoyer via la méthode **```POST```** vos identifiant : email et mot de passe créé lors de votre inscription, sur la route **```/api/login_check ```**
#### Demande de token:
```json
 // À mettre dans le Body de votre requête

    {
        "username": "SomeName@SomeEmail.xyz",
        "password":"password"
    }

```
#### Retour attendu
```json
 // retour de l'API 

    {
        "token": "SomeTokenOfTypeJWTToken"
    }

```
> ⚠️ Ce token est à mettre **obligatoirement** dans le Header de vos requêtes

## Récupérer les articles
Liste de l'ensemble des endpoints liés aux produits utilisable par un client de BilMo
### Récupérer tous les articles
La route **```/api/products```** permet de recevoir l'ensemble des produits BilMo.
⚠️ les résultats sont paginés
#### Exemple avec javascript:
```js
var myHeaders = new Headers();
myHeaders.append("Authorization", "Bearer SomeTokenOfTypeJWTToken");

var requestOptions = {
  method: 'GET',
  headers: myHeaders,
  redirect: 'follow'
};

fetch("localhost:8001/api/products", requestOptions)
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.log('error', error));
```

> 🟢 **Cette route d'api peut prendre différents paramètre telle que** : 
> `page=1` permet de récupérer la page 1 
> `itemsPerPage=` définis le nombre de résultat par page
> `order%5Bquantity%5D` permet de définir la façon dont les résultats sont ordonner en fonction des quantités, elle prend deux valeur `asc`(croissant) et `desc` ( décroissant)
> 
> Exemple : `/api/products?page=1&itemsPerPage=3&order%5Bquantity%5D=asc`.
> *Permet de récupérer la page 1 avec 3 résultats ordonner de façon croissante en fonction de la quantité*
>

#### Schémas de retour
```json
{
  "hydra:member": [
    {
      "@context": "string",
      "@id": "string",
      "@type": "string",
      "name": "string",
      "description": "string",
      "price": "string",
      "quantity": 0,
      "createdAt": "2022-11-24T13:10:27.696Z",
      "brand": {
        "@context": "string",
        "@id": "string",
        "@type": "string",
        "name": "string",
        "description": "string"
      }
    }
  ],
  "hydra:totalItems": 0,
  "hydra:view": {
    "@id": "string",
    "type": "string",
    "hydra:first": "string",
    "hydra:last": "string",
    "hydra:previous": "string",
    "hydra:next": "string"
  },
  "hydra:search": {
    "@type": "string",
    "hydra:template": "string",
    "hydra:variableRepresentation": "string",
    "hydra:mapping": [
      {
        "@type": "string",
        "variable": "string",
        "property": "string",
        "required": true
      }
    ]
  }
}
```
### Récupérer un articles
La route **```/api/products/idDeLArticle```** permet de recevoir les détails d'un produits BilMo.

idDeLArticle est à remplacer par l'`id` (int) d'un produit.
#### Exemple avec javascript:
```js
var myHeaders = new Headers();
myHeaders.append("Authorization", "Bearer SomeTokenOfTypeJWTToken");

var requestOptions = {
  method: 'GET',
  headers: myHeaders,
  redirect: 'follow'
};

fetch("localhost:8001/api/products/1", requestOptions)
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.log('error', error));
```
#### Retour attendu
```json
{
  "@context": "string",
  "@id": "string",
  "@type": "string",
  "name": "string",
  "description": "string",
  "price": "string",
  "quantity": 0,
  "createdAt": "2022-11-24T13:09:51.500Z",
  "brand": {
    "@context": "string",
    "@id": "string",
    "@type": "string",
    "name": "string",
    "description": "string"
  }
}
```

### Récupérer l'ensemble des products d'une marque

La route **```/api/brands/ID/products```** permet de recevoir l'ensemble des produits d'une marque du catalogue BilMo.
⚠️ les résultats sont paginés
#### Exemple avec javascript:
```js
var myHeaders = new Headers();
myHeaders.append("Authorization", "Bearer SomeTokenOfTypeJWTToken");

var requestOptions = {
  method: 'GET',
  headers: myHeaders,
  redirect: 'follow'
};

fetch("localhost:8001/api/brands/4/products", requestOptions)
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.log('error', error));
```

> 🟢 **Cette route d'api peut prendre différents paramètre telle que** : 
> `page=1` permet de récupérer la page 1 
> `itemsPerPage=` définis le nombre de résultat par page
> `order%5Bquantity%5D` permet de définir la façon dont les résultats sont ordonner en fonction des quantités, elle prend deux valeur `asc`(croissant) et `desc` ( décroissant)
> 
> Exemple : `/api/brands/4/products?page=1&itemsPerPage=3&order%5Bquantity%5D=asc`.
> *Permet de récupérer la page 1 avec 3 résultats ordonner de façon croissante en fonction de la quantité*
>

#### Retour attendu
```json
{
  "@context": "string",
  "@id": "string",
  "@type": "string",
  "name": "string",
  "description": "string",
  "price": "string",
  "quantity": 0,
  "createdAt": "2022-11-24T13:09:51.500Z",
}
```
## Gestion des clients
Liste de l'ensemble des endpoints liés au clients d'un utilisateur de Bilmo.
>:warning:  **C'est ici l'importance de bien conserver votre identifiant unique.**

### Ajouter un client
La route `/api/users` avec la méthode `POST` permet l'ajout d'un utilisateur

> ⚠️ **Pour permettre de faire la liaisons entre le clients et l'utilisateur BilMo l'identifiant unique de l'utilisateur doit être ajouter dans la requêtes d'ajout.**

#### Exemple avec javascript:
```js
var myHeaders = new Headers();
myHeaders.append("Authorization", "Bearer SomeTokenOfTypeJWTToken");
myHeaders.append("Content-Type", "application/json");

var raw = JSON.stringify({
  "name": "Gaylord",
  "forname": "Fidel",
  "email": "Tomas.Von@hotmail.com",
  "adress": "34490 Hessel Ways",
  "city": "Harrisfort",
  "country": "Bahamas",
  "zipcode": "CV",
  "user": [
    "/api/users/11"
  ]
});

var requestOptions = {
  method: 'POST',
  headers: myHeaders,
  body: raw,
  redirect: 'follow'
};

fetch("localhost:8001/api/customers", requestOptions)
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.log('error', error));
```

> ⚠️ **Le tableau user doit contenir votre unique `id` qui permettra de faire la liaison sous la forme `/api/users/idDeUser`**

#### Retour attendu
```json
{
  "id": 0,
  "name": "string",
  "forname": "string",
  "email": "string",
  "adress": "string",
  "city": "string",
  "country": "string",
  "zipcode": "string",
  "user": [
    "string"
  ]
}
```

> 🚧 En cas d'erreur : l'API peut vous renvoyer un **code erreur 400 en cas d'érreur dans les champs** ou un **code erreur 422 si l'API ne peut réaliser cette opération** 

### Supprimer un utilisateur

La route `/api/users` avec la méthode `DELETE` permet l'ajout d'un utilisateur

> ⚠️ **Pour permettre de faire la liaisons entre le clients et l'utilisateur BilMo l'identifiant unique de l'utilisateur doit être ajouter dans la requêtes d'ajout.**

#### Exemple avec javascript:
```js
var myHeaders = new Headers();
myHeaders.append("Content-Type", "application/merge-patch+json");
myHeaders.append("Authorization", "Bearer SomeTokenOfTypeJWTToken");

var raw = "";

var requestOptions = {
  method: 'DELETE',
  headers: myHeaders,
  body: raw,
  redirect: 'follow'
};

fetch("localhost:8001/api/customers/6", requestOptions)
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.log('error', error));
```

> 🚧 En cas d'erreur : l'API peut vous renvoyer un **code erreur 400 en cas d'érreur dans les champs**, un **code erreur 422 si l'API ne peut réaliser cette opération**, un **code erreur 404 si le client n'existe pas** 

### Récupérer l'ensemble des clients d'un utilisateur
La route `/api/users/usersID/customers` permet de lister l'ensemble des clients d'un utilisateur.

#### Exemple avec javascript:
```js
var myHeaders = new Headers();
myHeaders.append("Authorization", "Bearer SomeTokenOfTypeJWTToken");

var requestOptions = {
  method: 'GET',
  headers: myHeaders,
  redirect: 'follow'
};

fetch("localhost:8001/api/users/4/customers", requestOptions)
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.log('error', error));
```

#### Retour attendu
```json
[
  {
    "id": 0,
    "name": "string",
    "forname": "string",
    "email": "string",
    "adress": "string",
    "city": "string",
    "country": "string",
    "zipcode": "string",
    "user": [
      "string"
    ]
  }
]
```


### Récupérer les détails d'un clients d'un utilisateur
La route `/api/users/usersID/customers/id` permet de récupére les détails d'un clients d'un utilisateur.

#### Exemple avec javascript:
```js
var myHeaders = new Headers();
myHeaders.append("Authorization", "Bearer SomeTokenOfTypeJWTToken");

var requestOptions = {
  method: 'GET',
  headers: myHeaders,
  redirect: 'follow'
};

fetch("localhost:8001/api/users/4/customers/4", requestOptions)
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.log('error', error));
```

#### Retour attendu
```json

  {
    "id": 0,
    "name": "string",
    "forname": "string",
    "email": "string",
    "adress": "string",
    "city": "string",
    "country": "string",
    "zipcode": "string",
  }

```
