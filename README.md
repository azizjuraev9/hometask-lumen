# Home task from Hedgehog

## Setup instruction

To set up application use command:
``$ docker compose up``.

After set up complete, application is running on http://localhost:8000. you can interact with it using 
[available endpoints](#available-endpoints)

You can set up your own params by editing `.env` file

To run unit tests use:
``$ docker compose exec php vendor/bin/phpunit``

## Available endpoints

### Gotify

`http://localhost:9191/`

use credentials from `.env` file

### Mailhog

`http://localhost:8025/`

### To create new verification:

```
Method: POST  
URL: http://localhost:8000/verifications
Content-type: application/json
Body: {
  "subject": {
    "identity": "<identity>",
    "type": "<subject-type>"
  }
}
```
**return:**
```
Status: 201 Created
Content-type: application/json
Body: {
    "id": "your-verification-id"
}
```
* Identity must be a valid phone number or email
* subject-type is mobile_confirmation or email_confirmation depending on identity

### To confirming verification:


```
Method: PUT  
URL: http://localhost:8000/verifications/<verification-id>/confirm
Content-type: application/json
Body: {
  "code": "<verification-code>"
}
```
**return:**
```
HTTP/1.1 204 No Content
```
* verification-id is id from previous endpoint
* verification-code is code that you receive from gotify or mailhog

**Also, you can connect to postgresql or redis using credentials and ports in `.env` file**

```
