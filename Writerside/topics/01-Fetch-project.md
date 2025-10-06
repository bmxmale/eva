# Fetch project

EVA project is stored in a Git repository. To work on an existing project, you need to fetch it from the remote repository.

<a href="https://github.com/bmxmale/eva">EVA GitHub repository</a>

## Requirements
Before you begin, ensure that you have the following prerequisites installed on your machine:
- Git
- SSH Key (optional but recommended): If you plan to use SSH
- Composer: PHP dependency manager [https://getcomposer.org/](https://getcomposer.org/)

## Create a Directory
Create a directory where you want to clone the repository. Open your terminal and run the following commands:
<code-block lang="Shell">
mkdir Sites
cd Sites
</code-block>

## Cloning the Repository

<tabs>
    <tab title="SSH">
        <code-block lang="Shell">git clone git@github.com:bmxmale/eva.git eva-project</code-block>
    </tab>
    <tab title="HTTPS">
        <code-block lang="Shell">git clone https://github.com/bmxmale/eva.git eva-project</code-block>
    </tab>
</tabs>
