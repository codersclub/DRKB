<h1>Асинхронная ошибка</h1>
<div class="date">01.01.2007</div>


<p>Вопрос: Почему не работает следующий код? </p>
<pre>
     begin
       ClietnSocket1.Open;
       if ClietnSocket1.Socket.Connected then
         ClietnSocket1.Socket.SendText('Hello');
       {..}
     end;
     // Выдает - ассинхронная ошибка.
</pre>

<p>Вы работаете в ассинхронном режиме. Следует использовать соответсвующие события. </p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
