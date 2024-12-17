# Laravel Authentication with Email Verification

## Overview
This project demonstrates how to implement an authentication system in Laravel with email verification. It includes the following features:

1. **Email Verification:** A verification link is sent to the user's email upon registration.
2. **Queued Email Sending:** Emails are sent via a `Job` to ensure non-blocking operations.
3. **Automatic User Deletion:** A `Command` is implemented to delete users who have not verified their email within 3 days of registration.

---

## Features

1. **Mail Configuration:**
   - The system sends a verification email to newly registered users.
   - Emails are sent using Laravel's `Mail` facade.

2. **Job Implementation:**
   - The email sending process is handled by a `Job` to optimize performance.

3. **Command to Clean Up Users:**
   - Users who fail to verify their email within 3 days of registration are automatically deleted by a scheduled command.

---

## Installation Steps

### Prerequisites
Ensure you have the following installed:
- PHP 8.1+
- Composer
- MySQL or any other supported database
- Laravel 10+

### Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd <project-directory>
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up environment variables:
   ```bash
   cp .env.example .env
   ```
   Configure the `.env` file with your database and mail credentials.

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Generate an application key:
   ```bash
   php artisan key:generate
   ```

6. Set up the queue system:
   ```bash
   php artisan queue:work
   ```

---

## Usage

### User Registration
1. Register a new user by sending a POST request to `/register` with the following payload:
   ```json
   {
       "name": "User Name",
       "email": "user@example.com",
       "password": "password",
       "password_confirmation": "password"
   }
   ```

2. The system will send a verification link to the provided email address.

### Email Verification
- The user clicks on the verification link in the email to verify their account.

### Command for Cleanup
- Run the command to delete unverified users manually:
  ```bash
  php artisan app:clean-unverified-users
  ```

- Schedule the command by adding the following to `app/Console/Kernel.php`:
  ```php
  protected function schedule(Schedule $schedule):
  {
      $schedule->command('users:delete-unverified')->daily();
  }
  ```

---

## Code Structure

### Email Verification Job
Located in `app/Jobs/SendEmailJob.php`:
- Handles sending the verification email to the user.

### Cleanup Command
Located in `app/Console/Commands/CleanUnverifiedUsers.php`:
- Deletes users who have not verified their email within 3 days of registration.

### Email Template
Located in `resources/views/email/send.blade.php`:
- Contains the verification email content.

---

## Additional Commands

### Queue Work
To start the queue worker:
```bash
php artisan queue:work
```

---

## Testing

### Manual Testing
- Register a user and check if the verification email is received.
- Wait for 3 days and verify that unverified users are deleted by running the cleanup command.

---

## Notes
- Ensure your mail server is correctly configured in `.env`:
  ```env
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.mailtrap.io
  MAIL_PORT=2525
  MAIL_USERNAME=your_username
  MAIL_PASSWORD=your_password
  MAIL_ENCRYPTION=tls
  MAIL_FROM_ADDRESS=no-reply@example.com
  MAIL_FROM_NAME="App Name"
  ```

## Documentation

- My project's [api documentation](https://documenter.getpostman.com/view/39432331/2sAYJ1j2H3)
