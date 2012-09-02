<h1>Как узнать, откуда была установлена Windows?</h1>
<div class="date">01.01.2007</div>


<pre>
uses Registry;
 
procedure TForm1.Button1Click(Sender: TObject);
var
        reg: TRegistry;
begin
        reg := TRegistry.Create;
        reg.RootKey := HKEY_LOCAL_MACHINE;
        reg.OpenKey('Software\Microsoft\Windows\CurrentVersion\SETUP',false);
        ShowMessage(reg.ReadString('SourcePath'));
        reg.CloseKey;
        reg.free;
end;
</pre>

<p>Взято из </p>
DELPHI VCL FAQ Перевод с английского &nbsp; &nbsp; &nbsp; 
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>

