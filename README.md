# PHP End Of Life

[![CircleCI](https://circleci.com/gh/cyrosy/php-end-of-life.svg?style=svg)](https://circleci.com/gh/cyrosy/php-end-of-life)

Expose PHP end of life date, allowing you to check if your version is supported.

## Installation

```bash
composer require cyrosy/php-end-of-life
```

## Usage

```php
<?php
use \Cyrosy\PhpEndOfLife\PhpEndOfLife;

$currentVersion = (float) phpversion();

if (!PhpEndOfLife::isSupported($currentVersion)) {
    user_error(sprintf('Your current PHP version %s is not supported ! You should upgrade to prevent security exploits.', $currentVersion), E_USER_WARNING);
}
```
