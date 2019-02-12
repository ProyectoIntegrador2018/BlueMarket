# BlueMarket

Descripción del proyecto

## Table of contents

* [Environment URLS](#environment-urls)
* [Client Details](#client-details)
* [Da Team](#da-team)
* [Management tools](#management-tools)
* [Setup your dev environment](#setup-dev-environment)
* [Setup the project](#setup-the-project)
* [Running the app](#running-the-app)
* [Additional configuration](#config)
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

### Management tools

You should ask for access to this tools if you don't have it already:

* [Github repo](https://github.com/hecerinc/BlueMarket)
* [Heroku](https://sheltered-hamlet-63420.herokuapp.com)
* [Documentation](https://drive.google.com/drive/folders/1SHiWZ7gc5goa6OwubEEn4jsSo00Yploz?usp=sharing)


## Setup


### Setup dev environment

See the [install instructions](install_instructions.md) to set up your dev environment.

### Setup the project


After setting up your dev environment you can follow this simple steps:

1. Clone this repository into your local machine

```bash
$  git clone git@github.com:hecerinc/BlueMarket.git && cd BlueMarket
```

2. Fire up a terminal and run:

```bash
$  composer install
```

3. Install assets dependencies:

```bash
$  yarn install
```

3. Make your `.env.` file

```bash
$  cp .env.example .env # copy the env example file to a .env file
```

4. Generate your `APP_KEY` (this is a special, personal key that is used to encrypt traffic)

```bash
$  php artisan key:generate # this will save it automatically to your .env file
```


### Running the app

5. Run the project!

```bash
$  php artisan serve
```

By default `artisan` (the Laravel toolkit) runs a server at port `8000`. So you can go in your browser to `localhost:8000`, and you should see the app running.


### Getting started

Check out some useful tools and links over at the [docs/get_started.md](docs/get_started.md)


## Config

TBD

## License

TBD
