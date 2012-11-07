<h1>Как можно определить доступные сервера приложений на этой машине через Registry</h1>
<div class="date">01.01.2007</div>

<p>Прочитайте ключ под HKEY_CLASSES_ROOT\CLSID\*, просматривая его насчёт ключей, которые имеют подключ "Borland DataBroker". Эти вхождения и являются серверами приложений.</p>
<p>Ниже пример, который загружает имена доступных серверов приложений в Listbox:</p>
<pre class="delphi">
uses Registry;
 
procedure TForm1.FormCreate(Sender: TObject);
var
  I: integer;
  TempList: TStringList;
begin
  TempList := TStringList.Create;
  try
    with TRegistry.Create do
    try
      RootKey := HKEY_CLASSES_ROOT;
      if OpenKey('CLSID', False) then
        GetKeyNames(TempList);
      CloseKey;
      for I := 1 to TempList.Count - 1 do
        if KeyExists('CLSID\' + TempList[I] + '\Borland DataBroker') then
        begin
          if OpenKey('CLSID\' + TempList[I] + '\ProgID', False) then
          begin
            Listbox1.Items.Add(ReadString(''));
            CloseKey;
          end;
        end;
    finally
      Free;
    end;
  finally
    TempList.Free;
  end;
end;
</pre>

<div class="author">Автор: Nomadic</div>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

