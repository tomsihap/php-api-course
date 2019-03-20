# Exercices Client API

> cURL est un CLI qui nous permet de créer des requêtes HTTP. Une librairie, libcurl, est incluse dans PHP, nous allons l'utiliser !

## cURL: GET sans paramètres

### 1. Instanciez une requête cURL grâce à `curl_init();`
Exemple :

```
$curl = curl_init();
```


### 2. Mettez les options de transmissions nécessaires dans votre requête cURL grâce à `curl_setopt_array($curl, $array)`
Commencez par celles-ci :
```php
$array = [
    CURLOPT_URL => "https://swapi.co/api/people/3/",
    CURLOPT_CUSTOMREQUEST => "GET"
];
curl_setopt_array($curl, $array);
```

### 3. Executez, débuguez et fermez la requête

Nous allons exécuter la requête puis la fermer. Entre temps, nous allons traquer les erreurs générées par la requête: 

Exemple :
```php
curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
}
```

### 4. Utilisez d'autres options de transmissions :
En voici plusieurs utiles. Documentez-vous et gardez celles nécessaires : https://secure.php.net/manual/fr/function.curl-setopt.php.

Nous voulons les options pour configurer :
- l'URL de la requête (`"https://swapi.co/api/people/3/"`)
- forcer l'usage de GET
- le maximum de redirections HTTP (`10`)
- le temps maximum d'exécution (`30`)
- la version de HTTP (`CURL_HTTP_VERSION_1_1`)

### 5. Utiliser une variable
Trouvez l'option pour retourner les données dans une variable plutôt que de les afficher directement. Une fois l'option précisée, vous pourrez utiliser le résultat ainsi :
```php
$result = curl_exec($curl);
```

### 6. Ajouter des headers HTTP
Nous avons vu comment ajouter des options de transmissions (le paramétrage de la requête). Nous allons également pouvoir ajouter des headers à la requête HTTP.

- Trouvez l'option qui nous permet d'ajouter des headers HTTP.
- Ajoutez les headers suivants :

|  Header | Value |
|---|---|
|  Content-Type |  application/x-www-form-urlencoded |
|  cache-control |  no-cache |
|  Accept |  application/json |

- Quelle est la différence entre `x-www-form-url-encoded`et `form-data` pour la valeur de `Content-Type` ?

## cURL : GET avec paramètres

### Créer la requête

Nous allons cette fois faire une requête GET avec des paramètres dans l'URL, voici la requête :
```
GET https://omdbapi.com HTTP/1.1

'apikey'    'VOTRE_API_KEY'
's'         'batman'

```

- Configurez l'URL dans CURLOPT_URL, sans les paramètres.
- Ajoutez grâce à `sprintf()` votre array de paramètres. Rappelez vous que le format de l'URL est url.com`?`paramètres. Regardez la documentation de sprintf en cas de doute !

```php
sprintf("partieA?partieB", $partieA, $partieB);
```

- Pour construire la partie B, qui est la liste des paramètres au format : `key=value&key=value&key=value`, vous pouvez vous servir de la fonction http_build_query().

## cURL : POST

Pour une requête POST, vous aurez besoin de deux options :
- Une pour activer le mode POST
- Une pour passer des paramètres en POST
