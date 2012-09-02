<h1>Зарегистрировать новый тип файлов</h1>
<div class="date">01.01.2007</div>

Не хуже M$ получается! У них свои типы файлов, и у нас будут свои! Всё, что для этого нужно - точно выполнять последовательность действий и научиться копировать в буфер, чтобы не писать все те коды, что будут тут изложены :)) </p>
<p>Сначала, естественно, объявляем в uses модуль Registry. </p>
<pre>
uses
  Registry;
</pre>
<p>Затем в публичных объявлениях объявляем процедуру регистрации нового типа файлов: </p>
<pre>
public
  { Public declarations }
  procedure RegisterFileType(ext: string; FileName: string);
</pre>
<p>Описываем её так: </p>
<pre>
procedure TForm1.RegisterFileType(ext: string; FileName: string);
var
  reg: TRegistry;
begin
  reg:=TRegistry.Create;
  with reg do
  begin
    RootKey:=HKEY_CLASSES_ROOT;
    OpenKey('.'+ext,True);
    WriteString('',ext+'file');
    CloseKey;
    CreateKey(ext+'file');
    OpenKey(ext+'file\DefaultIcon',True);
    WriteString('',FileName+',0');
    CloseKey;
    OpenKey(ext+'file\shell\open\command',True);
    WriteString('',FileName+' "%1"');
    CloseKey;
    Free;
  end;
end;
</pre>
<p>Ну а по нажатию какого-нибудь батона регистрируем! </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  RegisterFileType('DelphiWorld', Application.ExeName);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
