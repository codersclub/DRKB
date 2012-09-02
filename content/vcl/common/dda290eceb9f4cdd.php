<h1>Как правильно работать с прозрачными окнами?</h1>
<div class="date">01.01.2007</div>


<p>Как правильно работать с прозрачными окнами (стиль WS_EX_TRANSPARENT)?</p>

<p>Стиль окна-формы указывается в CreateParams. Только вот когда перемещаешь его, фон остается со старым куском экрана. Чтобы этого не происходило, то когда pисуешь своё окно, запоминай, что было под ним,а пpи пеpемещении восстанавливай.</p>
<p>HDC hDC = GetDC(GetDesktopWindow()) тебе поможет..</p>
<p>Andrei Bogomolov</p>
<p>https://cardy.hypermart.net</p>
<p>ICQ UIN:7329451</p>
<p>admin@cardy.hypermart.net</p>
<p>e-pager: 7329451@pager.mirabilis.com</p>
<p>(2:5013/11.3)</p>

<p class="author">Автор: StayAtHome</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

