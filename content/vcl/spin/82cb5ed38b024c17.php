<h1>Как сделать так, чтобы в компонент TEdit можно было вводить текст только на английской раскладке?</h1>
<div class="date">01.01.2007</div>


<p>когда TEdit получает фокус надо вызвать:</p>
<pre>
ActivateKeyboardLayout($409, 0);
</pre>
<p>если этого мало тогда почитай про WM_INPUTLANGCHANGE</p>
<div class="author">Автор: cully</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
