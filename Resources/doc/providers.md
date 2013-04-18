Provedores
==========

Os provedores são os objetos no qual efetuarão a real consulta junto a
algum serviço "interno" ou "externo".

Em alguns passos você poderá registrar e utilizar seu provedor:

1. [Criar provedor](#create-provider)
2. [Registrar provedor](#register-provider)
3. [Utilização do provedor](#use-provider)

### <a id="create-provider" name="create-provider"></a>
### Passo 1: Criar provedor

Criar sua classe de provedor de conexão:

``` php
<?php

// ..

use Quality\Bundle\CurrencyConverterBundle\Provider\GatewayProvider;
use Quality\Bundle\CurrencyConverterBundle\Http\Request;

class fooProvider extends GatewayProvider
{
    
    // Efetuar a conversão
    public function convert($from, $to, $amount = 1.0)
    {
        $destiny = "http://foo.bar/?from={$from}&to={$to}&amount={$amount}";
        $request = new Request($destiny, 'GET');
        $response = $this->bind($request, false, true);
        
        return $response->getContent();
    }

    // Nome no qual o provedor será identificado
    public function getName()
    {
        return 'foo_provider';
    }

}
```



### <a id="register-provider" name="register-provider"></a>
### Passo 2: Registrar provedor

Para que seu provedor seja registrado e esteja pronto para uso:

``` yaml
# app/config.yml

### Conversor de moedas
quality_currency_converter:     
    providers:
        - "Foo\\BarBundle\\Provider\\fooProvider"
```



### <a id="use-provider" name="use-provider"></a>
### Passo 3: Utilização do provedor

Para utilizar seu provedor é fácil:

``` php
<?php
// src/Bundle/Controller/fooController.php

class fooController extends Controller
{
    public function barAction()
        $provider = $this->get('currency_converter.manager.provider')->get('foo_provider');
        $value = $provider->convert('BRL', 'USD', 1);

        // $value for example = 0.49774
    );
}
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