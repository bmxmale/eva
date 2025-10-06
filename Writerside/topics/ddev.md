# B) DDEV

You can use DDEV to set up a local development environment for your web projects. DDEV is an open-source tool that
simplifies the process of creating and managing local development environments using Docker containers.

## Prerequisites

Before you begin, ensure that you have the following prerequisites installed on your machine:
- Docker: Install Docker from [https://www.docker.com/get-started](https://www.docker.com/get-started)
- DDEV: Follow the installation instructions for your operating system from [https://docs.ddev.com/en/stable/users/install/](https://docs.ddev.com/en/stable/users/install/)

## Starting a DDEV Project

Enter your project directory in the terminal and run the following command to start the DDEV environment:

<code-block lang="shell">ddev start</code-block>

This command will create and start the necessary Docker containers for your project. You should see output similar to the following:

<code-block lang="shell">
➜  eva git:(main) ✗ ddev start
Starting eva...
Building project images....
Project images built in 2s.
 Network ddev-eva_default  Created
 Container ddev-eva-db  Created
 Container ddev-eva-web  Created
 Container ddev-eva-web  Started
 Container ddev-eva-db  Started
You have Mutagen enabled and your 'symfony' project type doesn't have `upload_dirs` set.
For faster startup and less disk usage, set upload_dirs to where your user-generated files are stored.
If this is intended you can disable this warning with `ddev config --disable-upload-dirs-warning`.
Starting Mutagen sync process...
Mutagen sync flush completed in 1s.
For details on sync status 'ddev mutagen st eva -l'
Waiting for containers to become ready: [web db]
Starting ddev-router if necessary...
 Container ddev-router  Created
 Container ddev-router  Started
Successfully started eva
Your project can be reached at https://eva.ddev.site
See 'ddev describe' for alternate URLs.
</code-block>

<warning>The first time you run <b>ddev start</b>, it may take a few minutes to download the necessary Docker images and set up the environment.</warning>

## Accessing the Project

Once the DDEV environment is up and running, you can access your project in a web browser by navigating to the URL provided in the terminal output 
[https://eva.ddev.site](https://eva.ddev.site).

## Running Commands in the DDEV Environment

This command opens a shell inside the web container, allowing you to run commands as if you were on a regular server.
<code-block lang="shell">ddev ssh</code-block>

To install PHP dependencies using Composer, run:
<code-block lang="shell">ddev composer install</code-block>

To run database migrations, use:
<code-block lang="shell">bin/console doctrine:migrations:migrate</code-block>

## Stopping the DDEV Project

<code-block lang="Shell">ddev stop</code-block>

## Removing the DDEV Project
<code-block lang="Shell">ddev delete</code-block>
