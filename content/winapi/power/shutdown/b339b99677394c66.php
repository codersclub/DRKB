<h1>Отключить команду «Завершение работы»</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  Registry;
...
procedure TForm1.Button1Click(Sender: TObject);
var
  a: TRegistry;
begin
  a := TRegistry.create;
  with a do
  begin
    RootKey := HKEY_CURRENT_USER;
    OpenKey('\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer', true);
    WriteInteger('NoClose', 1);
    CloseKey;
    Free;
  end;
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
