Armazenamento
=============

A moeda poderá ser armazenada em sessão, utilizado principalmente:
- Quando o usuário de um país quiser ver o valor em outra moeda.



Segue abaixo uma forma de utilização:

``` php
<?php
// src/Bundle/Controller/fooController.php

class fooController extends Controller
{
    public function barAction()
    {
        $storage = $this->get('currency_converter.storage');

        // Armazenar uma nova moeda como principal na sessão
        $storage->setCurrentCurrency('BRL');

        // Localizar a moeda armazenada na sessão
        $storage->getCurrentCurrency();

        // Limpar moeda da sessão
        $storage->resetCurrentCurrency();
    }
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