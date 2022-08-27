# Peticiones Get.
## Variables de entorno.

| Nombre               | Value                                                   |
|----------------------|---------------------------------------------------------|
|  url                 |  https://api-rest-full-deliveries.herokuapp.com         |
|  aiKey               |  +a#nWVm.v=zCg&C7B[pfL)ehJt*L8D                         |

---

## Get con select.
---
### Link:
```link
{{url}}/orders?select=id_order
```
---
### Headers:
```json
{
  "name": "Authorization",
  "value": "value": "{{apiKey}}"
}
```
### Params:
```json
{
  "name": "select",
  "value": "id_order"
}
```
---
### Response:

### 200
```json
{
  "status": 201,
  "method": "getData",
  "total": 3,
  "detalle": [
    {
      "id_order": 4
    },
    {
      "id_order": 14
    },
    {
      "id_order": 24
    }
  ]
}
```
### 400:
```json
{
  "status": 400,
  "method": "Router",
  "error": "You are not authorized to make this request..."
}
```
---
# Ruta Get de acceso publico solo a la tabla de roles.
## Link:
```
/rols
```
## Headers:
```
{
  "name": "Authorization",
  "value": no requerida
}
```
## Body:
```
   no requerido
```
## Response:
### 200:
```
{
  "status": 201,
  "method": "getData",
  "total": 2,
  "detalle": [
    {
      "id_rol": 4,
      "type_rol": "Admin",
      "active_rol": 1,
      "date_create_rol": "2022-07-21 22:36:07",
      "date_update_rol": "2022-07-21 22:36:07"
    },
    {
      "id_rol": 14,
      "type_rol": "User",
      "active_rol": 1,
      "date_create_rol": "2022-07-21 22:36:24",
      "date_update_rol": "2022-08-22 02:09:47"
    }
  ]
```
### 400:
```
{
  "status": 400,
  "method": "Router",
  "error": "You are not authorized to make this request..."
}
```
