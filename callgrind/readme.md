
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

# Análise visual implementada



---



Continuar na parte 2: Compilação e execução implementada, arquivo callgrind ja gerado, entrar na interface gráfica e continuar tutorial.
