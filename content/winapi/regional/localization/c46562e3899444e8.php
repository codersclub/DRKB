<h1>Как добавить нужный язык в систему</h1>
<div class="date">01.01.2007</div>

Автор: Mekan Gara </p>
<p>Для этого необходимо изменить некоторые ключи в реестре. Например, необходимо добавить Туркменский язык. Конечно, Вам необходимо иметь файл KBD с раскладкой клавиатуры (Turkmen.kbd). </p>
<pre>
procedure TTMKBD.OkClick(Sender: TObject);
var
  reg: TRegistry;
  srs, dst: string;
begin
  Reg := TRegistry.Create;
  with Reg do
  try
    RootKey := HKEY_LOCAL_MACHINE;
    OpenKey('\System\CurrentControlSet\Control\keyboard layouts\00000405', True);
    WriteString('layout file', 'Turkmen.kbd');
    WriteString('layout text', 'Turkmen');
    OpenKey('\System\CurrentControlSet\Control\Nls\Locale', True);
    WriteString('00000405', 'Turkmen');
    CloseKey;
  finally
    Free;
  end;
  srs := 'Turkmen.kbd';
  dst := 'c:\windows\system\Turkmen.kbd';
  Filecopy(srs, dst);
  showmessage('Well Done it all');
  close;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

