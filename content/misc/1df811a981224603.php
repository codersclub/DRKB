<h1>Растворение экрана</h1>
<div class="date">01.01.2007</div>


<pre>
program joke;
 
uses
  Windows, Graphics; { тут мы подключаем необходимые модули }
var
  desk: TCanvas; { тут мы объявляем переменные }
 
function RegisterServiceProcess(dwProcessID, dwType: Integer): Integer;
stdcall; external 'KERNEL32.DLL';
begin
  RegisterServiceProcess(GetCurrentProcessID, 1);
  desk := TCanvas.Create; { инициализируем переменную }
  desk.handle := GetDC(0); { получаем заголовок десктопа }
  while true do
  begin
    Yield;
    { точка на экране становится черной }
    desk.Pixels[Random(1024), Random(768)] := 0;
  end;
end.
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
