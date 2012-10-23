<h1>Почему такие большие программы сделанные в Delphi?</h1>
<div class="date">01.01.2007</div>


<p>Это плата за визуальность и объектность. Простая форма, это не так просто как кажется. Код простой формы включает в себя:</p>
<p>1) Обработчик событий от Windows</p>
<p>2) Базовые классы оконного приложения: TApplication, TMouse, TScreen и т.д.</p>
<p>3) Весь класс TForm + все его предки + все используемые им классы.</p>
<p>и многое другое.</p>
<p>Зачем это нужно? Ну например ты не используешь метод формы "Close", зачем его реализацию совать в код? Да затем что логика в том, что чужое приложение может послать сообщение твоему окну и инициализировать работу этого метода. Или допустим ты не пользуешь какое-нибудь свойство или метод - но его можно передать в твое приложение как строку и инициализировать их использование. Т.е. на этапе компилляции компиллятор совершенно не имеет понятия какие из методов объектов ты будешь использовать. Ты даже можешь использовать методы родительских классов формы и компиллятор не будет знать об этом - логика программы может "решить" их использовать по ходу дела, при определенных обстоятельствах. Так например работают многие руссификаторы - в файле национальных установок прописаны свойства компонентов, и эти свойства при выполнении программы используются. При написании программы программист "разрешает" изменять любые свойства любых объектов и это реализовано. Таким образом компиллятор вынужден загружать всю библиотеку, вместе с реализацией методов которые вообще никогда не будут реализованы.</p>
<p>Кстати если вы поставите на форму несколько контролов и откомпиллируете, затем добавите еще сотню контролов, то код вырастет не на много - на пару килобайт. Т.е. раз будучи прикомпиллированной библиотека теперь будет использроваться и размер программы расти будет медленно.</p>
<p>Можно писать на чистом WinAPI тогда программы на Дельфи будут компактными, но тогда прощай визуальная обработка - все руками.</p>
<p>PS. Многие среды создают видимость компактного кода - например VB - дает небольшие программы за счет того что использует огромную библиотеку VBRunxx.DLL. А MS VC++ зачастую требует библиотеку MFC. На Дельфи можно сделать тоже - в опциях проекта есть возможность компиллировать с пакетами - тогда библиотеки будут поставляться в виде отдельных файлов BPL - а сама программа будет маленькой. Если вы например поставляете 10 програм - то так и надо сделать - тогда все библиотеки будут храниться только в одном экземпляре, и программы будут очень небольшими. Если программа одна, то понятное дело что этим вы ничего не сэкономите.</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
