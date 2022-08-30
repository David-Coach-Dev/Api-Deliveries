## **Get de acceso publico.**

### **Link:**
```
{{url}}/rols
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
