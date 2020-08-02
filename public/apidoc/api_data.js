define({ "api": [
  {
    "type": "get",
    "url": "/checkCode",
    "title": "Сверка указанного кода с тем, что был ранее отправлен на указанный email.",
    "name": "CheckCode",
    "version": "0.1.0",
    "group": "Email",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email, который необходимо провалидировать.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "code",
            "description": "<p>Код для проверки.</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost:8080/checkCode?email=test@example.com&code=1793",
        "type": "curl"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Полученный статус.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": \"success\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BadRequest",
            "description": "<p>Error message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 400 Bad Request\n{\n  \"email\": \"error\",\n  \"message\": \"Error message\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/EmailController.php",
    "groupTitle": "Email"
  },
  {
    "type": "get",
    "url": "/sendCode",
    "title": "Генерация и отправка секретного кода на указанный email",
    "name": "SendCode",
    "version": "0.1.0",
    "group": "Email",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email для отпрвки сгенерированного кода.</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i http://localhost:8080/sendCode?email=test@example.com",
        "type": "curl"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Полученный статус.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": \"success\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BadRequest",
            "description": "<p>Error message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 400 Bad Request\n{\n  \"email\": \"error\",\n  \"message\": \"Error message\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/EmailController.php",
    "groupTitle": "Email"
  }
] });
