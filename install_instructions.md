# Set-up your dev environment

### Table of Contents

1. [Si tienes Mac picale aqu&iacute;](#mac-os)
1. [Si tienes Windows picale aqu&iacute;](#windows)

## Requirements


- [Composer](https://getcomposer.org/): PHP package manager
- [Laravel](https://laravel.com): Back-end framework
	- Laravel has its own [server requirements](https://laravel.com/docs/5.7#installation) (check them out!)
- [MySQL](https://mariadb.org/): Database manager


### Front-end tools

Click on the links to learn how to install them on your operating system:

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
3. The most recent version of XAMPP on MacOS installs a virtual machine, so a few things have to be set up.

## Windows

#### 1. Install PHP

The first thing you need is PHP installed (this is the language the server will run in). The easiest option to install this is to use pre-packaged binaries (somebody already compiled all of this for you!).

- Recommendation: [XAMPP](https://www.apachefriends.org/index.html)
- Click on the download button for Windows (first from the right)
- **If you already have PHP installed you can skip this step**

#### 2. Install XAMPP

Follow the prompts to install XAMPP. **XAMPP will install several tools:**:

- **PHP (language)**
- **MySQL (database manager)**
- **Apache (web server)**
- **Perl (another language)**

#### 2.1 Enable extensions

Laravel (the framework we will use) needs several PHP extensions enabled. Most of these are already installed with XAMPP, they just have to be enabled in the php config file (`php.ini`).

To check if you have them:

1. Open a terminal (`cmd.exe`) and run:

```cmd
> php -m
```

This will give you a list of enabled extensions. Check that the following extensions are enabled:

- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath

If all of them are enabled, you're good. Skip to [step 3](#3-install-composer).


##### What if I don't have them enabled?

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

### 3. Install Composer

Composer is a package manager for PHP. It's fairly straightforward to install.

1. Go to [getcomposer.org](https://getcomposer.org/download/) and download the Windows installer.
2. Run it and check that you can run `composer -v` in your terminal.

You're done! Check out how to [run the app](./README.md#running-the-app).

---

### Check environment variables

If you can't run some command in your terminal (e.g. `composer` or `php`), this probably means that you **do** have it installed, your terminal just can't find it (i.e. it's not in your `PATH`).

The `PATH` system variable tells the O.S. where to look for binaries (executables).

If you can't run PHP or Composer or Node (or some or every tool described in this file), then check if the binary is in your PATH variable (or the folder where it was installed).

For **Windows**:

```
> echo %PATH%
```

For **MacOS**:

```bash
> echo $PATH
```

These commands will print your current path variable, which is just a set of directories where your terminal looks for binaries (separated by either a `;` or a `:`).

Here are some instructions on how to modify this `PATH` variable:

- **Windows**: https://www.architectryan.com/2018/03/17/add-to-the-path-on-windows-10/
- **MacOS**: https://www.architectryan.com/2012/10/02/add-to-the-path-on-mac-os-x-mountain-lion/
