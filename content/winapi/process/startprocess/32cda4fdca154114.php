<h1>Как сделать, чтобы запускалась только одна копия приложения?</h1>
<div class="date">01.01.2007</div>


<pre>
var AtomText: array[0..31] of Char; 
 
 
procedure LookForPreviousInstance; 
var 
  PreviousInstanceWindow : hWnd; 
  AppName : array[0..30] of char; 
  FoundAtom : TAtom; 
begin 
  // помещаем имя приложения в AtomText 
  StrFmt(AtomText, 'OnlyOne%s', [Copy(Application.Title,1,20)]); 
  // Проверяем, не создано ли уже атома с таким именем приложения
  FoundAtom := GlobalFindAtom(AtomText); 
  if FoundAtom &lt;&gt; 0 then      // эта копия приложения уже запущена
  begin 
    StrFmt(AppName,'%s', [Application.Title]); 
    // изменяем текущий заголовок, чтобы FindWindow не видела его
    Application.ShowMainForm := false; 
    Application.Title := 'destroy me'; 
    // ищем предыдущую копию приложения
    PreviousInstanceWindow := FindWindow(nil,AppName); 
    // Передаём фокус на предыдущую копию приложения
    // завершаем текущую копию
    Application.Terminate; 
 
    if PreviousInstanceWindow &lt;&gt; 0 then 
      if IsIconic(PreviousInstanceWindow) then 
           ShowWindow(PreviousInstanceWindow,SW_RESTORE) 
      else SetForegroundWindow(PreviousInstanceWindow); 
  end; 
  // создаём глобальный атом, чтобы предотвратить запуск другой копии приложения
  FoundAtom := GlobalAddAtom(AtomText); 
end; 
 
 
 
 
constructor TForm.Create(AOwner: TComponent); 
begin 
  inherited; 
 
  LookForPreviousInstance; 
  ... 
end; 
 
 
destructor TForm.Destroy; 
var 
  FoundAtom : TAtom; 
  ValueReturned : word; 
begin 
  // не забудьте удалить глобальный атом
  FoundAtom := GlobalFindAtom(AtomText); 
  if FoundAtom &lt;&gt; 0 then ValueReturned := GlobalDeleteAtom(FoundAtom); 
 
  inherited Destroy; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<p>В блоке begin..end модуля .dpr:</p>

<pre>
begin
  if HPrevInst &lt;&gt; 0 then
    begin
      ActivatePreviousInstance;
      Halt;
    end;
end;
</pre>

<p>Реализация:</p>

<pre>
unit PrevInst;
 
interface
 
uses
 
  WinProcs,
  WinTypes,
  SysUtils;
 
type
  PHWnd = ^HWnd;
 
function EnumApps(Wnd: HWnd; TargetWindow: PHWnd): bool; export;
 
procedure ActivatePreviousInstance;
 
implementation
 
function EnumApps(Wnd: HWnd; TargetWindow: PHWnd): bool;
var
 
  ClassName: array[0..30] of char;
begin
 
  Result := true;
  if GetWindowWord(Wnd, GWW_HINSTANCE) = HPrevInst then
    begin
      GetClassName(Wnd, ClassName, 30);
      if STRIComp(ClassName, 'TApplication') = 0 then
        begin
          TargetWindow^ := Wnd;
          Result := false;
        end;
    end;
end;
 
procedure ActivatePreviousInstance;
var
 
  PrevInstWnd: HWnd;
begin
 
  PrevInstWnd := 0;
  EnumWindows(@EnumApps, LongInt(@PrevInstWnd));
  if PrevInstWnd &lt;&gt; 0 then
    if IsIconic(PrevInstWnd) then
      ShowWindow(PrevInstWnd, SW_Restore)
    else
      BringWindowToTop(PrevInstWnd);
end;
 
end.
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

