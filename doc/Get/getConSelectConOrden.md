## **Get con select con orden.**

### **Link:**

```json
{{url}}/users?select=id_user,nick_user&orderBy=id_user&orderMode=asc
```

### **Headers:**

|  Variable    |  Descripción.                                                             |
|-------------|---------------------------------------------------------|
|   apiKey      |  Codigo de autorización para el uso de la app.        |


```json
{
  "name": "Authorization",
  "value": {{apiKey}}
}
```

### **Params:**

|  Variable               |  Descripción.                                                            |
|---------------------|--------------------------------------------------------|
|  selct                      |  Selector de culumna en DB.                                   |
|  orderBy                |  Selector de la columna a ordenar                           |
|  orderMode           | Metodo de ordemamiento :   ASC / DSC .    |
  

```json
[
  {
    "name": "select",
    "value": "id_user,nick_user",
   },
   {
     "name": "orderBy",
     "value": "id_user",
    },
   {
     "name": "orderMode",
     "value": "asc",
    }
]
```

### **Response:**

#### **200:**

```json
{
  "status": 200,
  "method": "getData",
  "total": 17,
  "response": [
    {
      "id_user": 4,
      "nick_user": "DcDev"
    },
    {
      "id_user": 14,
      "nick_user": "maya"
    },
    {
      "id_user": 24,
      "nick_user": "dcdev"
    },
    {
      "id_user": 34,
      "nick_user": "etma"
    },
    {
      "id_user": 44,
      "nick_user": "etma"
    },
    {
      "id_user": 54,
      "nick_user": "etma"
    },
    {
      "id_user": 64,
      "nick_user": "lucu"
    },
    {
      "id_user": 74,
      "nick_user": ""
    },
    {
      "id_user": 84,
      "nick_user": ""
    },
    {
      "id_user": 94,
      "nick_user": ""
    },
    {
      "id_user": 104,
      "nick_user": ""
    },
    {
      "id_user": 114,
      "nick_user": "Moderador"
    },
    {
      "id_user": 124,
      "nick_user": "Moderador2"
    },
    {
      "id_user": 134,
      "nick_user": ""
    },
    {
      "id_user": 144,
      "nick_user": ""
    },
    {
      "id_user": 154,
      "nick_user": ""
    },
    {
      "id_user": 164,
      "nick_user": ""
    }
  ]
}
```

### **400:**

```json
{
  "status": 400,
  "method": "getData",
  "total": 1,
  "response": {
    "error": "Sintaxis invalida..."
  }
}
```

### **401:**

```json
{
  "status": 401,
  "method": "Router",
  "total": 1,
  "response": {
    "error": "No está autorizado..."
  }
}
```
---