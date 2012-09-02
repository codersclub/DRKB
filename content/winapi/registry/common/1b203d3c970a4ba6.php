<h1>Записать в реестр данные бинарного вида</h1>
<div class="date">01.01.2007</div>


<pre>
var
  Reg: TRegistry;
  buf : array [0..4] of byte;
  i: Integer;
begin
  Reg := TRegistry.Create;
  try
    Reg.RootKey := HKEY_CURRENT_USER;
    if Reg.OpenKey('\Software', True) then begin
      for i:=1 to 4 do buf[i]:=0;
      buf[0]:=1;
      Reg.WriteBinnaryData('Value', buf, sizeof(buf));
      Reg.CloseKey;
    end;
  finally
    Reg.Free;
    inherited;
  end;
  {...}
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
