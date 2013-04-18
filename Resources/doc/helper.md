Twig Helper
-----------

Segue abaixo alguns comandos auxiliares para utilização junto ao TWIG.

## Localizar currency definido como padrão

O comando abaixo irá verificar se há alguma moeda definida por sessão, caso não
haja localizará a moeda definida na configuração yml.

Segue comando:

```jinja
    {{ qp_get_defined_currency }}
```



## Conversão de moeda

A conversão de moeda poderá ser realizada diretamente pelo Twig.
Os parâmetros: 
- valor
- de moeda
- para moeda
- formatar (opcional) ?
- provedor (opcional) ?

Segue comando:

```jinja
    {{ qp_convert_currency("1", "BRL", defaultCurrency, true, 'google_provider') }}
```



## Filtros

Alguns filtros poderão ser realizados via atalhos twig.
- qp_format_currency (parâmetro opcional) | Formata valor de acordo com moeda.
- qp_filter_symbol | Exibe somente símbolo monetário
- qp_filter_amount | Exibe somente o valor

Seguem exemplos:

```jinja
    {{ "2.5"|qp_format_currency('BRL') }}
    {# result R$2.50 #}

    {{ "R$ 2.5"|qp_filter_symbol }}
    {# result R$ #}

    {{ "R$ 2.5"|qp_filter_amount }}
    {# result 2.50 #}
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