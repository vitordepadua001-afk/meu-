
# Códigos implementandos

```cpp
// test.cpp

#include <iostream>
#include <cmath>

#define ll long long
#define endl "\n"

using namespace std;

ll slowOperator() {
    ll count_slow = 0;
    for(int volatile i = 0; i < 100'000; i++) count_slow += sin(i) + cos(i) + sqrt(abs(tan(i)));
    return count_slow;
}

int fastOperator() {
    int count_fast = 0;
    for(int volatile i = 0; i < 100; i++) count_fast += i;
    return count_fast;
}

ll manager(int x) {
    if (x == 1) {
        ll result_slow;
        for(int i = 0; i < 100; i++) result_slow = slowOperator();
        return result_slow;
    } else if (x == 2) {
        int result_fast;
        for(int i = 0; i < 100; i++) result_fast = fastOperator();
        return result_fast;
    }
    return 1;
}

int main() {
    ll result_slow = manager(1);
    ll result_fast = manager(2);
    cout << "slow details: " << result_slow << endl;
    cout << endl << "fast details: " << result_fast << endl; 
    return 0;
}
```

O código acima basicamente cria uma função principal que chama outra função várias vezes para testar o uso de processamento em cada uma. A função `fastOperator()` serve para testar e principalmente apenas para se comparar com a função que realmente importa, como ela faz um loop leve (100) então seu objetivo principal é para gerar comparação de cálculos rápidos com cálculos pesados.

Já a função `slowOperator()` serve para gerar cálculos que vão usar muito a CPU/Processador, logo o intuito desse código é justamente comparar valores de uso **exclusivo** e **inclusivo** do *callgrind*.

# Compilação e execução implementada

Primeiro passo para compilar após terminar o código é gerar o arquivo `.out` para visualizar de forma mais clara o que está acontecendo, onde foi usado cada coisa etc.

Comando para compilar:

`valgrind --tool=callgrind my-test`.

Esse comando permite criar o analisador com *callgrind* que seria para ver histórico de chamadas, profilling, dados detalhados de desempenho etc.

Após esse comando, vai ser gerado um arquivo `callgrind.out.[numero]` que seria todos os detalhes do código, custos de cada função entre outras coisas importantes. Para ver visualmente precisa ser usado a interface `kcachegrind/qcachegrind` para ver os detalhes e manipular visualmente.

Inicialmente a interface vai abrir assim:

![[Pasted image 20261001084748.png]]

Primeiro passo é achar a função `manager(int)` que é nossa função que chama as outras duas e comparar onde parou o fluxo, onde continuo, custo de cada função que criamos etc.

Como podemos ver a função `slowOperator()` consumiu quase o mesmo da `manager(int)`. Como usamos `volatile` + cálculos pesados ele vai a cada iteração fazer o loop (*for*), ja que não vai usar otimizações para agilizar, isso aumenta muito o consumo e uso de processador.

Já a nossa `fastOperator()` em comparação com o gasto das outras, teve **0%** de custo pois fizemos um loop apenas de 100 interações + 100 interações do `manager(int)` porém mesmo assim em relação as outras funções teve custo zero, como se pode ver abaixo.

![[Pasted image 20261001090337.png]]

# Estatísticas

`manager(int)`: *40.085.768* chamadas com *99.93* de chamadas inclusivas, ou seja, todas as suas chamadas foram para outras funções. Seria chamando outras funções pesadas que estão aumentando seu custo, além de que ela por si só chamou mais vezes. Logo, ela é uma chamada que fez de "ponte" para as funções operadoras.

`slowOperator()`: *40.084.755* chamadas sendo disparado a função mais pesada ja que utilizou um loop bem grande de repetições e cálculos pesados sem otimização a cada loop.

`fastOperator()`: *1.013* chamadas apenas, ja que utiliza um loop bem pequeno e cálculo de baixo custo (incrementação).

As funções que mais chamaram a si mesmo foi todas de cálculo pesado da função `slowOperator()`. Sendo:

`__tan_fma (tangente)`: *9.999.999* chamadas exclusivas.
`__cos_fma (cosseno)`: *9.999.999* chamadas exclusivas.
`__sin_fma (seno)`: *9.999.999* chamadas esclusivas.

Então com esses resultados presentes podemos ver que o callgrind é uma ferramenta essencial e de excelência para análise do código, custo de cada função, chamadas exclusivas e inclusivas e oque ela está demandando.
