<h1>Olá {{ $pre_pedido['nome'] }}</h1>
<p>Seu pedido foi confirmado com sucesso!</p>
<p>Total: R$ {{ number_format($pre_pedido['total'], 2, ',', '.') }}</p>


<a href="{{ $pre_pedido['link'] }}">Link do Pedido</a>
