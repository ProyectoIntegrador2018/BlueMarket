# Set-up your dev environment

### Table of Contents

1. [Si tienes Mac picale aqu&iacute;](#mac-os)
1. [Si tienes Windows picale aqu&iacute;](#windows)

## Requirements

- [Composer](https://getcomposer.org/): PHP package manager
- [Laravel](https://laravel.com): Back-end framework
	- Laravel tiene sus propios [server requirements](https://laravel.com/docs/5.7#installation) (check them out!)
- [MySQL](https://mariadb.org/): Database manager


### Front-end tools

- [Node.js](https://nodejs.org/en/): Javascript runtime (lots of useful packages run on top of this platform)
- [Gulp](https://gulpjs.com/): task runner built on JS

## Mac OS

1. The first thing you need is PHP installed (this is the language the server will run in). The easiest option to install this is to use pre-packaged binaries (somebody already compiled all of this for you!).
	- Recommendation: [XAMPP](https://www.apachefriends.org/index.html)
	- Click on the download button for OS X (third from the right)
	- **If you already have PHP installed you can skip this step**
2. Follow the prompts to install XAMPP. **XAMPP will install several tools:**
	- **PHP (language)**
	- **MySQL (database manager)**
	- **Apache (web server)**
	- **Perl (another language)**


## Windows

#### Install PHP

The first thing you need is PHP installed (this is the language the server will run in). The easiest option to install this is to use pre-packaged binaries (somebody already compiled all of this for you!).

- Recommendation: [XAMPP](https://www.apachefriends.org/index.html)
- Click on the download button for Windows (first from the right)
- **If you already have PHP installed you can skip this step**

#### Install XAMPP

Follow the prompts to install XAMPP. **XAMPP will install several tools:**:

- **PHP (language)**
- **MySQL (database manager)**
- **Apache (web server)**
- **Perl (another language)**

#### Enable extensions

Laravel (the framework we will use) needs several PHP extensions enabled. Most of these are already installed with XAMPP, they just have to be enabled in the php config file (`php.ini`).

This `php.ini` configuration file will probably be at `C:/xampp/php/php.ini`. (By default XAMPP will install in `C:/xampp`. If you didn't change this setting, you're good). This file is protected by default so you will have to copy it to your Documents or Desktop and open it with your favorite text editor. 

Look for these lines:

- `extension=php_pdo_mysql.dll`
- `extension=php_openssl.dll`
- `extension=php_mbstring.dll`

If they have a `;` before them (that's a comment), delete the `;` and save the file. Copy the file back to `C:/xampp/php`.

#### Check that XAMPP is successfully installed

- Open your terminal (`cmd.exe`) (Although I recommend [Cmder](https://cmder.net))
- Run: `php -v`. You should see something like this:

```
> php -v

PHP 7.1.7 (cli) (built: Jul  6 2017 17:04:27) ( ZTS MSVC14 (Visual C++ 2015) x86 )
Copyright (c) 1997-2017 The PHP Group
Zend Engine v3.1.0, Copyright (c) 1998-2017 Zend Technologies
```

If you do, you're done with PHP! Otherwise [check your environment variables](#check-environment-variables).

### Install Composer

Composer is a package manager for PHP. It's fairly straightforward to install.

Go to [getcomposer.org](https://getcomposer.org/download/) and download the Windows installer.

Run it and check that you can run `composer -v` in your terminal.

You're done!


