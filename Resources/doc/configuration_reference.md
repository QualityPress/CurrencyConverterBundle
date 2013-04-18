Configurações de Referência
===========================

Segue abaixo as configurações possíveis para utilização do Bundle.

O que é requerido:
-> connection
-> providers
-> intl > transformers > locale && currency
-> twig_extension > default_provider

``` yaml
# app/config/config.yml

### Conversor de moedas
quality_currency_converter:
    connection    : "default"
    time_to_live  : "3600"
    
    ### Classes
    classes:
        conversion        : "Quality\\Bundle\\CurrencyConverterBundle\\Entity\\Conversion"
        formatter         : "Quality\\Bundle\\CurrencyConverterBundle\\Helper\\CurrencyFormatter"
        manager           : "Quality\\Bundle\\CurrencyConverterBundle\\Manager\\ConversionManager"
        provider_manager  : "Quality\\Bundle\\CurrencyConverterBundle\\Provider\Manager\\ProviderManager"
        
    ### Provedores de serviço
    providers:
        - "Quality\\Bundle\\CurrencyConverterBundle\\Extra\\Providers\\GoogleProvider"
        - "Quality\\Bundle\\CurrencyConverterBundle\\Extra\\Providers\\XRateProvider"
        - "Quality\\Bundle\\CurrencyConverterBundle\\Extra\\Providers\\YahooProvider"
        
    ### TwigExtension
    twig_extension:
        class             : "Quality\\Bundle\\CurrencyConverterBundle\\Twig\\Extension\\CurrencyExtension"
        default_provider  : "yahoo_provider"
        
    ### Sessão
    storage:
        class       : "Quality\\Bundle\\CurrencyConverterBundle\\Storage\\CurrencyStorage"
        session_key : "_qualitypress.current-currency"
        
    ### Transformador i18n
    intl:
        default_currency: "BRL"
          
        transformers:
            - {locale: "pt", currency: "BRL"}
            - {locale: "es", currency: "EUR"}
            - {locale: "en", currency: "USD"}
```



### Árvore da documentação

Para facilitar sua visita na documentação, abaixo seguem informações
dos títulos de cada passo referente a documentação.

- [Instalação](installation.md)
- [Provedores](providers.md)
- [Gerenciador](manager.md)
- [Formatação](formatter.md)
- [Armazenamento](storage.md)
- [Twig Helper](helper.md)