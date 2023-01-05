<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  Olá <b>{{$pedido->aluno->nome}}</b>!
  <br>  
  <br>
  O pagamento do seu <b>pedido #{{ $pedido->id }}</b> no Guitarpedia foi <b>REPROVADO</b>.
  <br>
  Por favor, verifique o que ocorreu junto ao seu banco emissor.
  <br>
  O seu pedido será cancelado em nosso sistema.
  Att;
  <br>
  Equipe Guitarpedia

</body>
</html>