# The SPACEBAR

This is a demo app, trialling the functionalities of Symfony4.

## Installation

### I. Set up DB connection

Create the .env file, by duplicating the content of the .dist file.
`cp .env.dist .env`

Ensure that connection data is correct (see: `line 16`)

### II. Create DB

`bin/console doctrine:database:create`

### III. Run migrations

Create the DB tables by running the symfony migrations

`bin/console doctrine:migrations:migrate`

### IV. Add dummy data

`bin/console doctrine:fixtures:load`

