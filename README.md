-----------------------------------------------------------------------------------------------------
POST api/login?email=prueba@gmail.com
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
+ token: Token de acceso generado (dicho que se utilizara en todas las apis, debera enviarse por headers con "Bearer").
+ message: Mensaje de respuesta, en caso de success o error.
+ success: Indicador.
--------------------------------------------------------------------------------------------------------


