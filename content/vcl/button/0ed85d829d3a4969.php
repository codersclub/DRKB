<h1>Визуализация нажатия кнопки</h1>
<div class="date">01.01.2007</div>

Я знаю как нажать кнопку через keypress, но хотя пользователь определил действие в обработчике события OnClick, сама кнопка не отражает видимых изменений, происходящих при ее нажатии мышью. Кто-нибудь может мне помочь?</p>
<p>Вы можете сделать кнопку "нажатой" или "ненажатой", посылая ей сообщение BM_SETSTATE. Определить ее текущее состояние можно, послав ей сообщение BM_GETSTATE.</p>
<p>Для нажатия кнопки:</p>
<p>Button1.Perform( BM_SETSTATE, 1, 0 );</p>

<p>Для отжатия кнопки:</p>
<p>Button1.Perform( BM_SETSTATE, 0, 0 );</p>

<p>Чтобы обнаружить нажатие кнопки:</p>
<p>ButtonPressed := Button1.Perform( BM_GETSTATE, 0, 0 ) = 1;</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
