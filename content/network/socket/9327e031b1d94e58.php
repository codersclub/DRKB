<h1>Как передать картинку по сети через TServerSocket?</h1>
<div class="date">01.01.2007</div>


<p>Да без проблем. Звиняйте, что на сях, но, тем не менее, на Борланд сях. </p>
<p>Со стороны, откуда посылаем (у нас это клиент), пишем:</p>
<pre>
TFileStream* str = new TFileStream("M:\\MyFile.jpg",fmOpenRead);
//ИЛИ, если мы работаем без сохранения (тогда не создается файл)
TMemoryStream* str = new TMemoryStream ();
str-&gt;Position = 0;
Image1-&gt;Picture-&gt;Bitmap-&gt;SaveToStream(str);
//и, наконец, шлем на сервер битмап
str-&gt;Position = 0;
ClientSocket1-&gt;Socket-&gt;SendStream(str);
</pre>
<p>Обратите внимание, не забывайте перед каждой операцией с потоком устанавливать позицию в 0!!! Иначе получим не то, что хотелось бы </p>
<p>Ну а со стороны приема (у нас это, соответственно, серверсокет), в событии приема пишем:</p>
<pre>
int ibLen = ServerSocket1-&gt;Socket-&gt;ReceiveLength();
char* buf= new char[ibLen+1];
TMemoryStream* str = new TMemoryStream();
str-&gt;Position = 0;
ServerSocket1-&gt;Socket-&gt;ReceiveBuf((void*)buf,ibLen);
str-&gt;WriteBuffer((void*)buf,ibLen);
str-&gt;Position = 0;
Image1-&gt;Picture-&gt;Bitmap-&gt;LoadFromStream(str);
//или
str-&gt;SaveToFile("M:\\MyFile.jpg");
</pre>

<p>Ну и ессно, как говорит Bigbrother, сделал дело - вызови деструктор! То есть почистить за собой надо, не знаю как в Паскале, но в сях мне надо удалить str и buf.</p>
<p class="author">Автор: TwoK </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
