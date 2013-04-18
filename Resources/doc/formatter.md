Formatação
==========

Para um grande auxílio na utilização de moedas, criamos também um formatador.
Este formatador auxilia na conversão dos "formatos" de moeda, como por exemplo
exibir o símbolo monetário.



### Utilização

``` php
<?php
// src/Bundle/Controller/fooController.php

class fooController extends Controller
{
    public function barAction()
        $provider = $this->get('currency_converter.manager.provider')->get('google_provider');
        $amount = $provider->convert('BRL', 'USD', 1); // print 0.49774
        
        $formatter  = $this->get('currency_converter.formatter');
        $f1         = $formatter->format($amount, "USD"); // print $0.50
        $f2         = $formatter->autoFormat($f1); // ex: print R$0.50
        
        $f3         = $formatter->parseAmount($f1); // print 0.50
        $f4         = $formatter->parseSymbol($f1); // print $
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