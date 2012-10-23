<h1>Получить количество вложенных ключей и значений ветви реестра</h1>
<div class="date">01.01.2007</div>


<pre>
uses Registry;
 
// Количество вложенных ключей и значений
procedure TForm1.Button1Click(Sender: TObject);
const
  sKey = '\SOFTWARE\Microsoft\Windows\CurrentVersion';
var
  rReg: TRegistry;
  ki: TRegKeyInfo;
begin
  rReg := TRegistry.Create;
  with rReg do
  begin
    RootKey := HKEY_LOCAL_MACHINE;
    if KeyExists(sKey) then
    begin
      OpenKey(sKey, false);
      GetKeyInfo(ki);
      CloseKey;
 
      lbSubkeys.Caption := IntToStr(ki.NumSubKeys);
      lbValues.Caption := IntToStr(ki.NumValues);
    end;
  end;
  rReg.Free;
end;
</pre>
<div class="author">Автор: ___Nikolay</div>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
