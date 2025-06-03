<h1>Olá {{ $pedido['nome'] }}</h1>
<p>Seu pedido foi confirmado com sucesso!</p>
<p>Total: R$ {{ number_format($pedido['total'], 2, ',', '.') }}</p>
