<h1>FindKey для нескольких полей</h1>
<div class="date">01.01.2007</div>


<pre>
with Table1 do
  begin
    SetKey;
    FieldByName('State').AsString := 'CA';
    FieldByName('City').AsString := 'Scotts Valley';
    GotoKey;
  end;
</pre>

<p>Вы не можете использовать Findkey с файлами DBase более чем для одного поля.</p>
<pre>
oEmetb.indexName:='PrimaryKey';
if oEmeTb.findkey([prCLient,prDiv,prEme])then 
</pre>

<p>где findkey передаются параметры для Primary Keyfields.</p>

<p>Я обращаю ваше внимание на то, что имя индекса (Index) чувствительно к регистру, так что будьте внимательны.</p>

<p>Вы можете также воспользоваться oEmeTb.indexfieldnames, но убедитесь в том, что ваш список ключевых полей в точности соответствуют ключевым полям, которые вы ищете.</p>

<pre>
oEmetb.indexfieldNames:='EmeClient;EmeDiv;EmeNo';
if oEmeTb.findkey([123,'A',96])then
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
