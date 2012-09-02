<h1>Почему не всегда верно обновляются IndexDefs по Update?</h1>
<div class="date">01.01.2007</div>


<p>Ошибка в VCL.</p>
<p>А помогает добавление fUpdated:=false; в теле процедуры TIndexDefs.Update.</p>
<p>Или убиением владельца через Free, и пересозданием.</p>
<p class="author">Автор: <a href="mailto:Nomadic@newmail.ru" target="_blank">Nomadic</a></p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
