# Locale Bundle

## Install
```sh
composer install kumulo/locale-bundle
```
## Configuration
Set the default locale :
```yaml
# config/packages/locale_bundle.yaml
locale_bundle:
  default_locale: en
```
Link it the Symfony default locale to the bundle :
```yaml
# config/packages/locale_bundle.yaml
locale_bundle:
  default_locale: '%kernel.default_locale%'
```
Manage the list of available locales :
```yaml
# config/packages/locale_bundle.yaml
locale_bundle:
  available_locales: ['en', 'fr']
```
## Locale Helpers :
Locale helpers will automatically set the locale.
There is 1 (to upgrade) kind of manager :

**Header Manager**

This manager will set the locale with `Accept-Language` headers.
It's quite useful when you want to make a translation for an API.

**To come**
- `UserLocaleHelper` to set locale with user preferences
- `RouteLocaleHelper` to set locale with route `_locale` parameter
## Add a new locale helper
If you want to create your own locale helper, just create a new class and extend the `AbstractLocaleHelper`.
```php
<?php
// src/Helper/MyLocaleHelper.php
namespace App\Helper;

use Kumulo\Bundle\LocaleBundle\LocaleHelper\AbstractLocaleHelper;
use Symfony\Component\HttpFoundation\Request;

class MyLocaleHelper extends AbstractLocaleHelper {
    public function getLocale(Request $request): ?string
    {
        $locale = "YOUR OWN LOGIC";
        // ...
        return $locale;
    }
}
```