# BlueMarket

Descripción del proyecto

## Table of contents

* [Client Details](#client-details)
* [Environment URLS](#environment-urls)
* [Da Team](#da-team)
* [Management resources](#management-resources)
* [Setup your dev environment](#setup-dev-environment)
* [Setup the project](#setup-the-project)
* [Running the stack for development](#running-the-stack-for-development)
* [Stop the project](#stop-the-project)
* [Restoring the database](#restoring-the-database)
* [Debugging](#debugging)
* [Running specs](#running-specs)
* [Checking code for potential issues](#checking-code-for-potential-issues)



## Running the app

## Config

https://github.com/php-censor/php-censor

### Client Details

| Name               | Email             | Role |
| ------------------ | ----------------- | ---- |
| Lorena Martínez | lorenamtze at tec | Initiative leader  |
| Raquel Landa | rlanda at tec | Initiative leader  |
| Cristina González | cristina.gonzalez.cordova at tec | Initiative leader  |


### Environment URLS

* **Production** - [TBD](TBD)
* **Staging** - [Heroku](https://sheltered-hamlet-63420.herokuapp.com)


### Da team

| Name           | Email             | Role        |
| -------------- | ----------------- | ----------- |
| Katie Arriaga | A01192508 at tec | Development - Frontend |
| Ana Karen Beltr&aacute;n | A01192508 at tec | Development - Backend |
| Marcela Garza | A00815888 at tec | Development - Frontend |
| H&eacute;ctor Rinc&oacute;n | A01088760 at tec | Development - Backend |

### Management tools

You should ask for access to this tools if you don't have it already:

* [Github repo](https://github.com/hecerinc/BlueMarket)
* [Heroku](https://sheltered-hamlet-63420.herokuapp.com)
* [Documentation](https://drive.google.com/drive/folders/1SHiWZ7gc5goa6OwubEEn4jsSo00Yploz?usp=sharing)

## Development

## Setup



### Setup dev environment

See the [install instructions](install_instructions.md) to set up your dev environment.

### Setup the project


After installing please you can follow this simple steps:

1. Clone this repository into your local machine

```bash
$ git clone git@github.com:hecerinc/BlueMarket.git
```

2. Fire up a terminal and run:

```bash
$ plis run web bash
```

3. Inside the container you need to migrate the database:

```
% rails db:migrate
```

### Getting started

Check out some useful tools and links over at the [docs/get_started.md](docs/get_started.md)


### Running the stack for Development

1. Fire up a terminal and run: 

```
plis start
```

That command will lift every service crowdfront needs, such as the `rails server`, `postgres`, and `redis`.


It may take a while before you see anything, you can follow the logs of the containers with:

```
$ docker-compose logs
```

Once you see an output like this:

```
web_1   | => Booting Puma
web_1   | => Rails 5.1.3 application starting in development on http://0.0.0.0:3000
web_1   | => Run `rails server -h` for more startup options
web_1   | => Ctrl-C to shutdown server
web_1   | Listening on 0.0.0.0:3000, CTRL+C to stop
```

This means the project is up and running.

### Stop the project

In order to stop crowdfront as a whole you can run:

```
% plis stop
```

This will stop every container, but if you need to stop one in particular, you can specify it like:

```
% plis stop web
```

`web` is the service name located on the `docker-compose.yml` file, there you can see the services name and stop each of them if you need to.

### Restoring the database

You probably won't be working with a blank database, so once you are able to run crowdfront you can restore the database, to do it, first stop all services:

```
% plis stop
```

Then just lift up the `db` service:

```
% plis start db
```

The next step is to login to the database container:

```
% docker exec -ti crowdfront_db_1 bash
```

This will open up a bash session in to the database container.

Up to this point we just need to download a database dump and copy under `crowdfront/backups/`, this directory is mounted on the container, so you will be able to restore it with:

```
root@a3f695b39869:/# bin/restoredb crowdfront_dev db/backups/<databaseDump>
```

If you want to see how this script works, you can find it under `bin/restoredb`

Once the script finishes its execution you can just exit the session from the container and lift the other services:

```
% plis start
```
