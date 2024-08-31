# BanguBank

BanguBank is a simple banking application with features for both 'Admin' and 'Customer' users.


### Admin Features

- See all transactions made by all users.
- Search and view transactions by a specific user using their email.
- View a list of all registered customers.

### Customer Features

- Customers can register using their `name`, `email`, and `password`.
- Customers can log in using their registered email and password.
- See a list of all their transactions.
- Deposit money to their account.
- Withdraw money from their account.
- Transfer money to another customer's account by specifying their email address.
- See the current balance of their account.


### Storage Configuration

- change storage configuration for file
```bash
php change_storage.php file
```

- change storage configuration for database
```bash
php change_storage.php database
```

### Admin Credentials

- create admin using this command
```bash
php create_admin.php
```



