## **Get.**

### **Link:**
```json
/users
```

### **Headers:**
```json
{
  "name": "Authorization",
  "value": apiKey
}
```

### **Response:**

#### **200:**
```json
{
 "status": 200,
  "method": "getData",
  "total": 16,
  "detalle": [
    {...},{...},{...}
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