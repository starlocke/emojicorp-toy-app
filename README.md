# Emojicorp: A study in encoding/decoding

This "app" should be simple to launch.

It requires simply these things, conveniently wrapped up as a Docker-based
project:

- PHP;
- PHP mysqli extension;
- MySQL server;
  - Exposes port 3306 on localhost; make sure that is available,
    or edit the docker-compose.yml file as appropriate.

The requirements for launching this are:

- Docker
- Docker-Compose
- `/bin/bash` (non-issue for most macOS and Linux users)

Hardware:

- Anything roughly requivalent to a MacBook Pro from 2015.
- That is to say: SSD drive, fast CPU, ample memory.

**HARDWARE SPEED NOTICE**

- If your hardware is slow, then, `./tldr.sh` may fail to create a database.
- In that case, there's a line in its output that will help get the database
  setup. It tells you to run:

`docker-compose exec db /schema/reset.sh`

Windows Users:

- Windows users should be running Windows 10 with the "Linux Subsystem"
  installed to have BASH available. Alternatively, it'll be up to you to step
  through the contents of the `tldr.sh` and `test.sh` files.

## Configuration? Security?

None. You're on your own. This is a "toy" appliance, after all.

## Pre-requisites

Install Docker and Docker-Compose as appropriate for your platform.

**Common workstations:**

"Docker for Mac" and "Docker for Windows" already include Docker-Compose.

macOS: https://docs.docker.com/docker-for-mac/install/

Windows: https://docs.docker.com/docker-for-windows/install/

**Linux, Servers, Etc:**

Docker: https://docs.docker.com/install/

Docker-Compose: https://docs.docker.com/compose/install/

## Quick Start

Download the project, best using `git`.

```
git clone git@github.com:starlocke/emojicorp-toy-app.git

cd emojicorp-toy-app
```

Perform "Quick Start" in a single command, once you have Docker and
Docker-compose installed.

This will:

- Initialize the system.
- Launch a browser on http://localhost:8816/ (if you're lucky)

```
./tldr.sh
```

## Remarks

### MySQL

UUID requires MySQL 8. Currently in Release Candidate status.

Making use of utf8mb4 will hopefully take care of all i18n/l10n issues, but,
since the message is encrypted anyway, it's likely moot.

Time was sunk running into a new issue recently introduced to MySQL+PHP around
`default_authentication_plugin=mysql_native_password`.

### PHP Architecture and Operation of Processor

Most of it starts at `index.php` and work horse utility functions are found in
`lib`.

`api.php` (badly named) is just a "POST" processor.

`read.php` is just a "GET" processor.

I did not want any framework dependencies in doing this for the sake of
minimizing the bytes needed for the project. Under normal cirumstances, I would
have used some MVC system. CakePHP, Silex+Doctrine, etc.

### MySQL Connectivity

This system exposes MySQL on `localhost:3306`. It's possible to connect directly
to its database using "MySQL Workbench" and other tools.

The credentials are:

- User: `emojiuser`
- Pass: `emojipass`
- Schema/Database: `emojicorp`

Inspection will give you very little useful data.

### Test Suite

None. It would have been nice to have created tests for validating the emoji
constraints. I'm going on a "blind faith" approach here that all Emoji 11.0
sequences will "just work", but can't be sure without comprehensive tests in
place. Life calls, and I must cut my efforts short for the time being.
