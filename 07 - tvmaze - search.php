<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'https://api.tvmaze.com'
]);

$response = $client->get('/search/shows', [
    'query' => [
        'q' => $_POST['search']
    ]
]);

$data = json_decode($response->getBody());
?>

<!doctype html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>TV Shows List</title>
</head>

<body>
    <h1>TV Shows List</h1>
    <a href="index.php">< Retour</a>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-12">

                <?php foreach($data as $d) : ?>

                <div class="card">
                    <div class="card-header">
                        <?= $d->show->name ?>
                    </div>

                    <div class="card-body">
                        <?= $d->show->summary ?>
                    </div>

                    <div class="card-footer">
                        <a href="add.php?tvmaze_id=<?=$d->show->id?>" class="btn btn-xs btn-success">
                            Ajouter le film
                        </a>
                    </div>
                </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html> 
