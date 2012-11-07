<h1>Утечка памяти при поиске файлов</h1>
<div class="date">01.01.2007</div>

Не забывайте вызывать SysUtils.FindClose(SearchRec) после каждого вызова FindFirst, так как вызов FindFirst создаёт динамическую структуру SearchRec, которую после поиска надо освобождать.</p>

<div class="author">Автор: Vit</div>
<p> <br>
<p></p>
