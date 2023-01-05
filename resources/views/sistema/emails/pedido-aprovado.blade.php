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
  O pagamento do seu <b>pedido #{{ $pedido->id }}</b> no Guitarpedia foi APROVADO! 
  <br>
  Agradecemos a confiança em nosso trabalho e a possibilidade de trabalharmos juntos rumo ao seu objetivo!
  <br>
  Acesse o link abaixo e faça seu login, para agendar as suas aulas, entrando no menu "Ao Vivo -> Agendar aulas pagas".
  <br>
  <br>
  <a href="" class="btn btn-primary">Agendar aulas!</a>
  <br>
  <br>
  Att;
  <br>
  Equipe Guitarpedia

</body>
</html>