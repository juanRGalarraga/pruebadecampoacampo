<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container p-2">
        <div class="row justify-content-center">
            <div class="card col-md-6">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <form id="formArticle" name="formArticle">
                        <div class="row">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group col-md-6">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Precio</label>
                                <input type="number" class="form-control" id="price" name="price">
                            </div>
                            <div class="form-group justify-conten-center col-md-6">
                                <label for="">Precio dolar</label>
                                <input type="text" class="form-control" id="price_dolar" name="price_dolar">
                            </div>
                        </div>
                    </form>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" id="buttonSave">Guardar cambios</button>
                        <button type="button" class="btn btn-primary" id="buttonCreate">Crear nuevo artículo</button>
                    </div>
                </div>
            </div>
            <div class="card col-md-6">
                <h5 class="card-text pt-1">Listado de artículos</h5>
                <div id="mainlist" class="p-2"></div>
            </div>
            <div class="alert alert-primary mt-2" role="alert" id="responseAlert" hidden="true"></div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="js/app.js" type="text/javascript"></script>
</body>
</html>