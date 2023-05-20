# Product list project
A basic project list and add web app.

## Table of contents
- ### [Features](#features)
- ### [Installation](#installation)
- ### [CI/CD Pipelines](#pipelines)

## Features
&nbsp;&nbsp;&nbsp;&nbsp;`✔️` Linting according to modern standards.

&nbsp;&nbsp;&nbsp;&nbsp;`✔️` CI/CD pipelines.

&nbsp;&nbsp;&nbsp;&nbsp;`✔️` Applying OOP concepts and principles.

## Installation
### [Frontend](./frontend/README.md)
### [Backend](./backend/README.md)

## Pipelines
Using [Bitbucket pipelines](https://bitbucket.org/product/features/pipelines), the CI/CD steps are:
- Auto linting the backend and frontend code. The pipeline will stop will fail if the code does not comply with the standard.
- Auto deploy the code to a Linux server.
- Auto migrate DB changes.
