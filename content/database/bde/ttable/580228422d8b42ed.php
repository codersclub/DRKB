<h1>Вставка новой записи через буфер</h1>
<div class="date">01.01.2007</div>


<pre>
Table2.Insert;
Move(Table1.ActiveBuffer^,Table2.ActiveBuffer^,Table1.RecordSize);
{При необходимости назначаем новый первичный ключ}
Table2.FieldByName('Primary Key').AsWhatever := whatever;
Table2.Post;
</pre>
<p>...если вы уверены в том, что нарушение ключа произойти не может, то можно вырезать это для дальнейшего использования:</p>
<pre>
DbiInsertRecord(Table2.Handle,dbiNOLOCK,Table1.ActiveBuffer);
</pre>
<p>...конечно, это "обходит" VCL, т.к., чтобы увидеть потом новую запись, необходимо сделать TTable.Refresh.</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
