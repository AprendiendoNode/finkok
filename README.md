# Finkok / Laravel

## EN DESARROLLO
**IMPORTANTE**  este componente se encuentra en desarrollo y probablemente tenga cambios severos. 


>Nota: Te puedes apoyar de [https://github.com/gmlo89/CFDI] para generar los CFDIs 3.3

### Registrar cliente
```php
\Finkok::registerClient('TCM970625MB1');
```
### Timbrar y guardar el CFDI

```php
// \DOMDocument $xml 
$xml = \Finkok::stamp($xml);
$xml->save(storage_path('cfdis/cfdi.xml'));
```


### Development By [@gmlo_89]

 [@gmlo_89]: <https://twitter.com/gmlo_89>
 [https://github.com/gmlo89/CFDI]: <https://github.com/gmlo89/CFDI>