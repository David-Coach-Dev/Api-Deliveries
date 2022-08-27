# **Peticiones Get.**
## **Variables de entorno.**

| Nombre               | Value                                                   |
|----------------------|---------------------------------------------------------|
|  url                 |  https://api-rest-full-deliveries.herokuapp.com         |
|  aiKey               |  +a#nWVm.v=zCg&C7B[pfL)ehJt*L8D                         |
---
## [**Get.**]("https://api-rest-full-deliveries.herokuapp/doc/get.md")
---

## **Get de acceso publico.**

### **Link:**
```
/rols
```

### **Headers:**
```json
{
  "name": "Authorization",
  "value": no requerida
}
```

### **Response:**

#### **200:**
```json
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

### **400:**
```
{
  "status": 400,
  "method": "Router",
  "error": "You are not authorized to make this request..."
}
```
---