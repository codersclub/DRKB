<h1>Проверка наличия BDE</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
unit Findbde;
 
interface
 
implementation
uses
 
  Controls,
  SysUtils,
  WinTypes,
  WinProcs,
  Dialogs;
 
var
 
  IdapiPath: array[0..255] of Char;
  IdapiHandle: THandle;
 
initialization
 
  GetProfileString('IDAPI', 'DLLPath', 'C:\', IdapiPath, 255);
{следующие строки "изолируют" первый путь к каталогу из IdapiPath в случае, если их несколько}
  if Pos(';', StrPas(IdapiPath)) &lt;&gt; 0 then
    begin
      StrPCopy(IdapiPath, Copy(StrPas(IdapiPath), 1,
        Pred(Pos(';', StrPas(IdapiPath)))));
    end;
  IdapiHandle := LoadLibrary(StrCat(IdapiPath, '\IDAPI01.DLL'));
  if IdapiHandle &lt; HINSTANCE_ERROR then
    begin
      if MessageDlg('ОШИБКА: Borland Database Engine (IDAPI) не найдена' +
        'перед следующей попыткой ее необходимо установить....',
        mtError, [mbOK], 0) = mrOK then
        Halt
    end
{ IDAPI в системе не установлена }
  else
    begin
      FreeLibrary(IdapiHandle);
{ IDAPI Установлена в системе }
    end;
 
end.
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

<hr />

<p>Способ 1:</p>

<p>Следующая функция получает структуру SysVersion и записывает результаты в stringlist.</p>

<pre class="delphi">
uses dbierrs, DBTables; 
... 
 
function fDbiGetSysVersion(SysVerList: TStringList): SYSVersion; 
var 
  Month, Day, iHour, iMin, iSec: Word; 
  Year: SmallInt; 
begin 
  Check(DbiGetSysVersion(Result)); 
  if (SysVerList &lt;&gt; nil) then 
  begin 
    with SysVerList do 
    begin 
      Clear; 
      Add(Format('ENGINE VERSION=%d', [Result.iVersion])); 
      Add(Format('INTERFACE LEVEL=%d', [Result.iIntfLevel])); 
      Check(DbiDateDecode(Result.dateVer, Month, Day, Year)); 
      Add(Format('VERSION DATE=%s', [DateToStr(EncodeDate 
                (Year, Month, Day))])); 
      Check(DbiTimeDecode(Result.timeVer, iHour, iMin, iSec)); 
      Add(Format('VERSION TIME=%s', [TimeToStr(EncodeTime 
                (iHour, iMin, iSec div 1000, iSec div 100))])); 
    end; 
  end; 
end; 
</pre>


<p>Вызов этой функции выглядит следующим образом:</p>

<pre class="delphi">
var hStrList: TStringList; 
    Ver: SYSVersion; 
begin 
  hStrList:= TStringList.Create; 
  try Ver := fDbiGetSysVersion(hStrList); except 
    ShowMessage('BDE not installed !'); 
  end; 
  ShowMessage(IntToStr(Ver.iVersion)); 
  Memo1.Lines.Assign(hStrList); 
  hStrList.Destroy; 
end; 
</pre>

<p>Возможные результаты (отображаемые в memo-поле):</p>

<pre>
ENGINE VERSION=500
INTERFACE LEVEL=500
VERSION DATE=09.06.98
VERSION TIME=17:06:13
</pre>

<p>Способ 2:</p>

<p>Читаем ключ в реестре:</p>

<pre class="delphi">
RootKey := HKEY_LOCAL_MACHINE; 
OpenKey(`SOFTWARE\Borland\Database Engine`, False); 
try 
   s := ReadString(`CONFIGFILE01`); 
 
   //BDE установлена
finally 
   CloseKey; 
end; 
</pre>


<p>Способ 3:</p>

<p>Можно попробовать установить BDE</p>

<pre class="delphi">
  IsBDEExist := (dbiInit(nil) = 0) 
</pre>

<p>PS: Последний способ более предпочтителен, так как анинсталлер мог удалить BDE-файлы, но оставить в реестре ключ :)</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


