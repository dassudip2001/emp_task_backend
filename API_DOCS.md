# API Documentation

## Authentication

### Login

-   **POST** `/api/v1/login`
    -   Authenticates a user.
    -   **Body:** `{ "email": "string", "password": "string" }`
    -   **Response:** User data and token.

### Register

-   **POST** `/api/v1/register`
    -   Registers a new user.
    -   **Body:** `{ "name": "string", "email": "string", "password": "string", "password_confirmation": "string" }`
    -   **Response:** User data.

### Logout

-   **POST** `/api/v1/logout`
    -   Logs out the authenticated user.
    -   **Auth required:** Yes

## Password Reset

### Request Reset Link

-   **POST** `/api/v1/forgot-password`
    -   Sends a password reset link to the user's email.
    -   **Body:** `{ "email": "string" }`

### Reset Password

-   **POST** `/api/v1/reset`
    -   Resets the user's password.
    -   **Body:** `{ "email": "string", "password": "string", "confirm_password": "string", "_token": "string" }`

## User

### Get Authenticated User

-   **GET** `/api/v1/user`
    -   Returns the authenticated user's details.
    -   **Auth required:** Yes

## Daily Updates

-   **GET** `/api/v1/daily-updates`
    -   List daily updates.
-   **POST** `/api/v1/daily-updates`
    -   Create a new daily update.
-   **GET** `/api/v1/daily-updates/{daily_update}/edit`
    -   Get a daily update for editing.
-   **PUT/PATCH** `/api/v1/daily-updates/{daily_update}`
    -   Update a daily update.
-   **DELETE** `/api/v1/daily-updates/{daily_update}`
    -   Delete a daily update.

## Organizations

-   **GET** `/api/v1/organizations`
    -   List organizations.
-   **POST** `/api/v1/organizations`
    -   Create a new organization.
-   **GET** `/api/v1/organizations/{organization}/edit`
    -   Get an organization for editing.
-   **PUT/PATCH** `/api/v1/organizations/{organization}`
    -   Update an organization.
-   **DELETE** `/api/v1/organizations/{organization}`
    -   Delete an organization.

## Sanctum

-   **GET** `/sanctum/csrf-cookie`
    -   Get CSRF cookie for SPA authentication.

## Storage

-   **GET** `/storage/{path}`
    -   Access storage files.

---

> **Note:** All `/api/v1/*` routes (except login, register, forgot-password, reset) require authentication via Bearer token.
