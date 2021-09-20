<!doctype html>
<html lang="fr_FR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <title>Signature PDF</title>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row">
            <div id="container-pages" class="col-lg-10 col-md-9 col-sm-8 col-xs-6 bg-light text-center"></div>
            <aside class="col-lg-2 col-md-3 col-sm-4 col-xs-6 mt-2 position-fixed end-0 bg-white">
                <h5><i class="bi bi-vector-pen"></i> Signature à main lever</h5> 
                <canvas id="signature-pad" class="border bg-light" width=200 height=150></canvas>
                <hr />
                <h5><i class="bi bi-fonts"></i> Signature texte</h5>
                <input id="input-text-signature" type="text" class="form-control" placeholder="Ma signature" style="font-family: 'Caveat', cursive; font-size: 24px;" /> 
                <hr />
                <form id="form-image-upload" action="/image2svg" method="POST" class="row g-3" enctype="multipart/form-data">
                    <h5><i class="bi bi-image"></i> Importer une image</h5> 
                    <input id="input-image-upload" class="form-control" name="image" type="file">
                </form>
                <hr />
                <p><small class="text-muted">Double-cliquez sur le PDF pour ajouter la signature</small></p>
                <form id="form_pdf" action="/<?php echo $key ?>/save" method="post">
                    <div class="position-fixed bottom-0 mb-2">
                        <button class="btn btn-primary" type="submit" id="save"><i class="bi bi-download"></i> Télécharger le PDF Signé</button>
                    </div>
                </form>
            </aside>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://mozilla.github.io/pdf.js/legacy/build/pdf.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fabric@4.4.0/dist/fabric.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@3.0.0-beta.3/dist/signature_pad.umd.min.js"></script>
    <script>
    var url = '/data/<?php echo $key ?>.pdf';
    </script>
    <script src="/js/app.js"></script>
  </body>
</html>