# Backend

## Installation
Run install script.
```sh
composer install
```
then copy and set .env variables

```sh
cp .env.example .env
```
## Usage
### Run
```sh
composer run-script dev
``` 
Will start to server project on localhost:3300
### Lint
According to [PSR 12](https://www.php-fig.org/psr/psr-12/) standards.
```sh 
composer run-script lint
```
### Format
Format and auto-fix some PS12 standards violations.
```sh
composer run-script beautify
```