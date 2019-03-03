# Deployment

This document describes how to deploy this project to a production server.

## Requirements

The following are dependencies required by the app for the production environment.

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
- MySQL >= v5.7.7
- Composer (dependency installation)
- Git

This document describes how to deploy to [Heroku](https://heroku.com) which is a PaaS company. The process for deploying to other PaaS services (e.g. AWS, Azure) should be quite similar.

If you have traditional web hosting or a blank machine, then you will have to make sure that the individual dependencies are installed or enabled and configured. You can check the [install instructions document](install_instructions.md) for some guidance on this.

## Deploying to Heroku

Specifically for Heroku, you will need the following requirements:

- [Heroku CLI](https://devcenter.heroku.com/articles/heroku-cli).

Once the CLI is installed follow the instructions:

#### 1. Clone the repository

```bash
$ git clone https://github.com/ProyectoIntegrador2018/BlueMarket.git && cd BlueMarket
```

#### 2. You can create an app in Heroku from the command line:

```bash
$ heroku create [app_name]
```

You can optionally specify an app name (Heroku will create one for you if you don't).

#### 3. Create the buildpacks

We need several buildpacks (Node.js and PHP) to run this app. PHP is the default app language for the back-end but we use several JavaScript and Node.js scripts to build the front-end assets. Heroku will only automatically detect one by default, so we must explicitly specify both:

```bash
$ heroku buildpacks:set heroku/nodejs
$ heroku buildpacks:add heroku/php
```

#### 4. Deploy

Once the app is created you can now push the existing version to the Heroku remote that was created by the previous command:

```bash
$ git push heroku master
```

Heroku should then build (using the `Procfile`, `package.json`, and `composer.json`) files included in the repository to install all of the required dependencies.

You can check those files to see how the build pipline is executed. Heroku will also display the log output to your terminal when it's done.

#### 5. Open the app!

You can launch the app in your browser automatically using the following command:

```bash
$ heroku open
```

