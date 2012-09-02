<h1>Как поместить окно програмы поверх всех?</h1>
<div class="date">01.01.2007</div>


<p>Если навсегда - то поставить у формы FormStyle свойство в fsStayonTop,</p>
<p>если надо чтобы просто программа была установлена в активное состояние (как будто кликнули на ней на таскбаре) - Application.BringtoFront</p>
<p>Кроме того можно играться API функцией ShowWindow передавая ей Form1.Handle, или Application.Handle и один из кучи параметров - посмотри на нее Help - там много вариантов. </p>
<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

