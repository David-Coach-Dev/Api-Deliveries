## **Get.**

### **Link:**

```json
{{url}}/users
```

### **Headers:**

|  Variable    |  Descripción.                                                             |
|-------------|---------------------------------------------------------|
|   apiKey      |  Codigo de autorización para el uso de la app.        |

```json
"headers": [
  {
    "name": "Authorization",
    "value": apiKe
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
    {...}
  ]
}
```

### **400:**

```json
{
  "status": 400,
  "method": "Router",
  "error": "You are not authorized to make this request..."
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