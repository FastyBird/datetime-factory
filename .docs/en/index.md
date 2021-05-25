# Quick start

This extension adds support for creating date&time immutable objects.

## Installation

The best way to install **fastybird/datetime-factory** is using [Composer](http://getcomposer.org/):

```sh
composer require fastybird/datetime-factory
```

After that, you have to register extension in *config.neon*.

```neon
extensions:
    fbDateTimeFactory: FastyBird\DateTimeFactory\DI\DateTimeFactoryExtension
```

## Configuration

This extension has some configuration options:

```neon
fbDateTimeFactory:
    timezone: Europe/Prague
```

Where:

- `timezone` is string representation you custom time zone. Default value is `UTC`

## Use DateTimeFactory

This extension register DateTimeFactory to you container. This service could be used in your presenters, controllers, models, etc.

```php
use FastyBird\DateTimeFactory;

class YourCustomPresenter
{

    /** @var DateTimeFactory\DateTimeFactory */
    private DateTimeFactory\DateTimeFactory $dateTimeFactory;
    
    public function __construct(
        DateTimeFactory\DateTimeFactory $dateTimeFactory
    ) {
        $this->dateTimeFactory = $dateTimeFactory;
    }

    public function actionSomethingToDo()
    {
        // your cool code here...

        $now = $this->dateTimeFactory->getNow();

        $article->setCreatedAt($now);

        // your cool code here...
    }
}
```

The only one method of factory: `$dateTimeFactory->getNow()` is returning immutable DateTime object.

***
Homepage [http://www.fastybird.com](http://www.fastybird.com) and repository [https://github.com/FastyBird/datetime-factory](https://github.com/FastyBird/datetime-factory).
