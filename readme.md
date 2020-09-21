# Component POC Templating Smarty
Some usage with smarty.

[Smarty](https://www.smarty.net) is a template engine for PHP, facilitating the separation of presentation (HTML/CSS) from application logic. This implies that PHP code is application logic, and is separated from the presentation.

## Prerequisite

* PHP 5.6 (v1.0)

## Install
`composer install`

Or you can add this poc like a dependency, in this case edit your [composer.json](https://getcomposer.org) (launch `composer update` after edit):
```json
{
  "repositories": [
    { "type": "git", "url": "git@github.com:jgauthi/poc_templating_smarty.git" }
  ],
  "require": {
    "jgauthi/poc_templating_smarty": "1.*"
  }
}
```

## Usage
You can test with php internal server and go to url http://localhost:8000 :

```shell script
php -S localhost:8000 -t public
```


## Documentation
You can look at [folder public](public).

