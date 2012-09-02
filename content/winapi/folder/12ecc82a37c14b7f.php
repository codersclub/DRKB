<h1>Как найти каталог Windows?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetWindowsFolder:string;

 
var p:PChar;
begin
  GetMem(p, MAX_PATH);
  result:='';
  if GetWindowsDirectory(p, MAX_PATH)&gt;0 then
    result:=string(p);
  FreeMem(p);
end;
</pre>
<p class="author">Автор: Vit</p>
<hr />
<pre>
public
  { Public declarations }
  Windir: string;
  WindirP: PChar;
  Res: Cardinal;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  WinDirP := StrAlloc(MAX_PATH);
  Res := GetWindowsDirectory(WinDirP, MAX_PATH);
  if Res &gt; 0 then
    WinDir := StrPas(WinDirP);
  Label1.Caption := WinDir;
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

