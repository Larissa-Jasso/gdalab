----------------------------------------------------------------------------Especificaciones-----------------------------------------------------------------------------------

Instalar vendor: Correr el comando de 'composer install' para generar el vendor
Levantar servidor (para correr en modo local): php artisan serve --host=localhost --port=8000
El env ya se encuentra en modo de produccion

############################################################################################################################

POST api/login?email=''
params:{
    email:string,
}
headers:{
    Accept: application/json
}
response:
{
        "token": "72e23b21ddde35361347d407188dfb885762d9b0",
        "message": "Token retornado correctamente",
        "success": true
}

-   token: Token de acceso generado (dicho que se utilizara en todas las apis, debera enviarse por headers con "Bearer").
-   message: Mensaje de respuesta, en caso de success o error.
-   success: Indicador.

############################################################################################################################

POST api/customer?commune=''&region=''&dni=''&email=''&name=''&last_name=''

params:{
        region:string,
        commune:string,
        dni:string,
        email:email,
        name:string,
        last_name:string,
        address:string,
}
headers:{
        Authorization: Bearer $token
        Accept: application/json
}
response:
{
        "message": "Registro exitoso",
        "customer": {
        "region_id": 1,
        "commune_id": 1,
        "dni": "FRSF1256RFS9ES5789",
        "email": "nueva.prueba@gmail.com",
        "name": "Nueva2",
        "last_name": "Prueba2",
        "address": null,
        "updated_at": "2022-11-10T00:16:22.000000Z",
        "created_at": "2022-11-10T00:16:22.000000Z"
        },
        "success": true
}

-   customer: Informacion del usuario insertado.
-   message: Mensaje de respuesta, en caso de success o error.
-   success: Indicador.

############################################################################################################################

GET api/customer

headers:{
        Authorization: Bearer $token
        Accept: application/json
}
response:
    {
        "message": "Registro exitoso",
        "customer": {
        "dni": "FRSF1256RFS9ES5789",
        "region_id": 1,
        "commune_id": 1,
        "email": "nueva.prueba@gmail.com",
        "name": "Nueva2",
        "last_name": "Prueba2",
        "address": null,
        "status": "A",
        "created_at": "2022-11-10T00:19:20.000000Z",
        "updated_at": "2022-11-10T00:19:20.000000Z",
        "region": {
        "id": 1,
        "description": "Europa",
        "status": "A",
        "created_at": "2022-11-09T21:31:33.000000Z",
        "updated_at": "2022-11-09T21:31:33.000000Z"
        },
        "commune": {
        "id": 1,
        "region_id": 1,
        "description": "Ecovillage",
        "status": "A",
        "created_at": "2022-11-09T21:31:33.000000Z",
        "updated_at": "2022-11-09T21:31:33.000000Z"
        }
        },
        "success": true
}

-   customer: Informacion del usuario loggeado.
-   region: Region a la que pertenece el usuario.
-   commune: Comuna a la que pertenece el usuario.
-   message: Mensaje de respuesta, en caso de success o error.
-   success: Indicador.
    ############################################################################################################################
    DELETE api/customer

headers:{
        Authorization: Bearer $token
        Accept: application/json
}
response:
{
        "message": "Registro eliminado correctamente",
        "success": true
}

-   message: Mensaje de respuesta, en caso de success o error.
-   success: Indicador.
