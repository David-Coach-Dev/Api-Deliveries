## **Get con select.**

### **Link:**

```json
{{url}}/orders?select=id_order
```

### **Headers:**

```json
{
  "name": "Authorization",
  "value": {{apiKey}}
}
```

### **Params:**

```json
{
  "name": "select",
  "value": "id_order",
}
```

### **Response:**

#### **200:**

```json
{
  "status": 200,
  "method": "getData",
  "total": 3,
  "response": [
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