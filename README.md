# BlueMarket

[![Maintainability](https://api.codeclimate.com/v1/badges/4891d04dc51996992762/maintainability)](https://codeclimate.com/github/ProyectoIntegrador2018/BlueMarket/maintainability) [![Test Coverage](https://api.codeclimate.com/v1/badges/4891d04dc51996992762/test_coverage)](https://codeclimate.com/github/ProyectoIntegrador2018/BlueMarket/test_coverage)

BlueMarket is an initiative at Tec de Monterrey for team collaboration across different classes and groups to produce unique projects that combine the strengths of multidisciplinary teams, each with their own expertise, and replicating a real-world team collaboration environment.

The initiative is under the Novus project sponsorship for 2019.

Check out the current version here: https://sheltered-hamlet-63420.herokuapp.com



## Table of contents

* [Client Details](#client-details)
* [Environment URLS](#environment-urls)
* [Da Team](#da-team)
* [Management tools](#management-tools)
* [Setup your dev environment](#setup-dev-environment)
* [Setup the project](#setup-the-project)
* [Running the app](#running-the-app)
* [Additional configuration](#configuration)
* [License](#license)


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
| Katie Arriaga | katiearriaga at live.com | Development - Frontend, Product Owner |
| Oscar Gonz&aacute;lez | oscardan.gonzalez at gmail.com | Development - Backend, Scrum Master |
| Melissa Trevi&ntilde;o | mely.trevic at gmail.com | Development - Frontend, Configuration Manager |
| Rub&eacute;n de la Pe&ntilde;a | ruben.dlpena at gmail.com | Development - Backend, Project Manager |

### Management tools

You should ask for access to this tools if you don't have it already:

* [Github repo](https://github.com/hecerinc/BlueMarket)
* [Heroku](https://sheltered-hamlet-63420.herokuapp.com)
* [Documentation](https://drive.google.com/drive/folders/1SHiWZ7gc5goa6OwubEEn4jsSo00Yploz?usp=sharing)


## Development


### Setup your dev environment

See the [install instructions](install_instructions.md) to set up your dev environment.

### Setup the project


After setting up your dev environment you can follow this simple steps:

1. Clone this repository into your local machine

```bash
$  git clone https://github.com/ProyectoIntegrador2018/BlueMarket.git && cd BlueMarket
```

2. Fire up a terminal and run:

```bash
$  composer install
```

3. Install assets dependencies:

```bash
$  yarn install
```

3. Make your `.env` file

```bash
$  cp .env.example .env # copy the env example file to a .env file
```

4. Generate your `APP_KEY` (this is a special, personal key that is used to encrypt traffic)

```bash
$  php artisan key:generate # this will save it automatically to your .env file
```

5. Generate the static resources

```bash
$  yarn run prod
```

6. Run the database migrations

```
$  php artisan migrate:fresh
```


### Running the app

Run the project!

```bash
$  php artisan serve
```

By default `artisan` (the Laravel toolkit) runs a server at port `8000`. So you can go in your browser to `localhost:8000`, and you should see the app running.


### Stopping the app

In order to stop the project, just hit `Ctrl + C` on the terminal where the `artisan` server is running.


### Deploying app to Heroku

For more information about how to deploy this app, check out [docs/deployment.md](docs/deployment.md)


## Getting started

Check out some useful tools and links over at the [docs/get_started.md](docs/get_started.md)


## Configuration

TBD

## License

TBD
