# Requirements

- PHP 8.0
- Apache Web Server
- Composer 2

# Dependencies

The system uses:
- [Lumen Framework](https://lumen.laravel.com) - Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax.
- [MathExecutor](https://github.com/neonxp/MathExecutor) - Simple math expresions parser and calculator.
- [Interval](https://github.com/Kirouane/interval) - This library provides some tools to handle intervals.

# Installation

Open the root folder and run the following command:
```
composer install
```

# Run Calculation

Open the root folder and run the following command:
```
php artisan calc --json="_CONFIG_FILE_"
```

Where `_CONFIG_FILE_` is a JSON config:
```
resources/calc/*/*.json
```

Example:
```
php artisan calc --json="prm/1"
```

# Troubleshooting

## Error:

> In IntervalParser.php line 139:
> round(): Argument #1 ($num) must be of type int|float, string given

## Solution:
Open the following file:
```
vendor/kirouane/interval/src/Parser/IntervalParser.php
```
And comment the line:
```
declare(strict_types=1);
```

Result:
```
// declare(strict_types=1);
```

# Base Classes & Files

- `app/Models/*` - All models are placed here
- `app/Models/MathGen/Point/*` - General classes to work with points, coordinates, deltas, etc.
- `app/Models/MathGen/Parametric/*` - Parametric identification classes
- `app/Models/MathGen/Parametric/BeeColony/Identification.php` - The Bee Colony algorithm is initialized here

- `app/Models/Math/Executor/Executor.php` - Wrapper for the MathExecutor library
- `app/Models/Math/Interval/Interval.php` - Wrapper for the Interval library

- `config/math_gen.php` - General config
