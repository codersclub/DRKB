<h1>Почему MDI Child форма при закрывании просто минимизируется?</h1>
<div class="date">01.01.2007</div>


<p>Обрабатывайте событие OnClose для формы и выставляйте в нем параметр Action в caFree. Дело в том, что его значение по умолчанию для MDI Child форм caMinimize. Кстати, если сделать Action := caNone, то форму нельзя будет закрыть</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
