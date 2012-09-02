<h1>Создание индекса</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: OAmiry (Borland) </p>

<p>Ниже приведен код обработчика кнопки OnClick, с помощью которого строится индекс:</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  bActive, bExclusive: Boolean;
begin
  bActive := Table1.Active;
  bExclusive := Table1.Exclusive;
  Table1.IndexDefs.Update;
  with Table1 do
  begin
    Close;
    {таблица dBASE должна быть открыта в монопольном (exclusive) режиме}
    Exclusive := TRUE;
    Open;
    if Table1.IndexDefs.IndexOf('FNAME') &lt;&gt; 0 then
      Table1.AddIndex('FNAME', 'FNAME', []);
    Close;
    Exclusive := bExclusive;
    Active := bActive;
  end;
end;
</pre>

<p>Если вы собираетесь запускать проект из Delphi, пожалуйста убедитесь в том, что свойство таблицы Active в режиме проектирования установлено в False. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
