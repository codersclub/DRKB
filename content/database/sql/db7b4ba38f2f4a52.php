<h1>Как создать таблицу через SQL?</h1>
<div class="date">01.01.2007</div>


<p>Следующая функция полностью совместима с Paradox:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  Q: TQuery;
begin
  Q := TQuery.Create(Application)
    try
    Q.DatabaseName := 'SF';
 
    with Q.SQL do
      begin
        Add('Create Table Funcionarios');
        Add('( ID      AutoInc,       ');
        Add('  Name    Char(30),      ');
        Add('  Salary  Money,         ');
        Add('  Depno    SmallInt,     ');
        Add('  Primary Key ( ID ) )   ');
      end;
 
    Q.ExecSQL;
  finally
    Q.Free;
  end;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

