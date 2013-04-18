Installation
============

São somente 4 passos para habilitar o bundle:

1. [Configuração via composer](#enable-in-composer)
2. [Habilitar o Bundle](#enable-bundle)
3. [Configuração](#enable-configuration)
4. [Atualizar banco de dados](#enable-database)

### <a id="enable-in-composer" name="enable-in-composer"></a>
### Passo 1: Configuração via composer

Adicionar no seu arquivo composer.json:

```js
{
    "require": {
        "quality-press/currency-converter-bundle": "*"
    }
}
```

Após adicionar o bundle em seu composer, executar o comando para instalação.

``` bash
$ php composer.phar update quality-press/currency-converter-bundle
```

O Composer irá instalar o bundle no diretório: `vendor/quality-press`.



### <a id="enable-bundle" name="enable-bundle"></a>
### Passo 2: Habilitar o Bundle

Habilitar o Bundle no kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new new Quality\Bundle\CurrencyConverterBundle\QualityCurrencyConverterBundle(),
    );
}
```



### <a id="enable-configuration" name="enable-configuration"></a>
### Passo 3: Configuração

Seguem algumas configurações base para funcionamento do bundle:

``` yaml
# app/config.yml

### Conversor de moedas
quality_currency_converter:
    connection    : "default"
        
    ### Provedores de serviço
    providers:
        - "Quality\\Bundle\\CurrencyConverterBundle\\Extra\\Providers\\GoogleProvider"
        - "Quality\\Bundle\\CurrencyConverterBundle\\Extra\\Providers\\XRateProvider"
        - "Quality\\Bundle\\CurrencyConverterBundle\\Extra\\Providers\\YahooProvider"
        
    ### TwigExtension
    twig_extension:
        default_provider  : "google_provider"
        
    ### Transformador i18n
    intl:
        default_currency: "BRL"
        transformers:
            - {locale: "pt", currency: "BRL"}
            - {locale: "es", currency: "EUR"}
            - {locale: "en", currency: "USD"}
```



### <a id="enable-database" name="enable-database"></a>
### Passo 4: Atualizar banco de dados

Agora falta somente executar o comando para atualizarmos nosso banco de dados:

``` bash
$ php app/console doctrine:schema:update --em=default --force
```



### Árvore da documentação

Para facilitar sua visita na documentação, abaixo seguem informações
dos títulos de cada passo referente a documentação.

- [1. Instalação](installation.md)
- [2. Provedores](providers.md)
- [3. Gerenciador](manager.md)
- [4. Formatação](formatter.md)
- [5. Armazenamento](storage.md)
- [6. Twig Helper](helper.md)
- [7. Configuração de referência](configuration_reference.md)