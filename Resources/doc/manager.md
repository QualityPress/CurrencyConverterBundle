Gerenciador
===========

O gerenciador é a classe com intuito de efetuar o gerenciamento das
solicitações de conversão e armazenamento junto ao banco de dados.

As informações de consulta são armazenadas no banco de dados para que
não haja um trânsito muito grande de consultas.

O tempo de consultas para uma nova informação de moeda poderá ser gerenciado
através do parâmetro time_to_live no arquivo de configuração.



### Utilização

O gerenciador poderá ser facilmente utilizado. Segue abaixo exemplo:

``` php
<?php
// src/Bundle/Controller/fooController.php

class fooController extends Controller
{
    public function barAction()
        $manager = $this->get('currency_converter.manager');
        $value = $manager->convert('BRL', 'USD', 1, 'foo_provider');

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