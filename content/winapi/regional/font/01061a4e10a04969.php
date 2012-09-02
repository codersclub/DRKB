<h1>Как приложению воспользоваться своими шрифтами?</h1>
<div class="date">01.01.2007</div>


<p>Может ли кто-нибудь подсказать или решить такую проблему: мне нужно убедиться, что мое приложение использует доступные, а не ближайшие шрифты, установленные пользователем в системе? Я пробовал копировать файл #.ttf в директорию пользователя windows\system, но мое приложение так и не смогло их увидеть и выбрать для дальнейшего использования. </p>

<p>Ниже приведен код для Delphi, который динамически устанавливает шрифты, загружаемые только во время работы приложения. Вы можете расположить файл(ы) шрифтов в каталоге приложения. Они будут инсталлированы при загрузке формы и выгружены при ее разрушении. Вам возможно придется модифицировать код для работы с Delphi 2, поскольку он использует вызовы Windows API, которые могут как измениться, так и нет. Если в коде вы видите "...", то значит в этом месте может располагаться какой-либо код, не относящийся к существу вопроса. </p>

<p>Ну и, конечно, вы должны заменить "MYFONT" на реальное имя файла вашего шрифта.</p>

<pre>
type
  TForm1 = class(TForm)
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
    ...
    private
    { Private declarations }
    bLoadedFont: boolean;
  public
    { Public declarations }
  end;
 
procedure TForm1.FormCreate(Sender: TObject);
var
  sAppDir: string;
  sFontRes: string;
begin
  sAppDir := Application.ExeName;
  sAppDir := copy(sAppDir, 1, rpos('\', sAppDir));
 
  sFontRes := sAppDir + 'MYFONT.FOT';
  if not FileExists(sFontRes) then
  begin
    sFontRes := sFontRes + #0;
    sFont := sAppDir + 'MYFONT.TTF' + #0;
    CreateScalableFontResource(0, @sFontRes[1], @sFont[1], nil);
  end;
 
  sFontRes := sAppDir + 'MYFONT.FOT';
  if FileExists(sFontRes) then
  begin
    sFontRes := sFontRes + #0;
    if AddFontResource(@sFontRes[1]) = 0 then
      bLoadedFont := false
    else
    begin
      bLoadedFont := true;
      SendMessage(HWND_BROADCAST, WM_FONTCHANGE, 0, 0);
    end;
  end;
  ...
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
var
  sFontRes: string;
begin
  if bLoadedFont then
  begin
    sFontRes := sAppDir + 'MYFONT.FOT' + #0;
    RemoveFontResource(@sFontRes[1]);
    SendMessage(HWND_BROADCAST, WM_FONTCHANGE, 0, 0);
  end;
end;
</pre>



<p>Я поработал с данным кодом и внес некоторые поправки для корректной работы на Delphi 2.0. На Delphi 3.0 не испытано. </p>

<p>Электронная справка по продукту InstallShield показывает, что в системах Win95 и WinNT FOT-файл не нужен. Вам нужен только TTF-файл. </p>

<p>В результате процедура FormCreate стала выглядеть так:</p>

<pre>
var
  sAppDir, sFontRes: string;
begin
  {...другой код...}
  sAppDir := extractfilepath(Application.ExeName);
 
  sFontRes := sAppDir + 'MYFONT.TTF';
  if FileExists(sFontRes) then
  begin
    sFontRes := sFontRes + #0;
    if AddFontResource(@sFontRes[1]) = 0 then
      bLoadedFont := false
    else
    begin
      bLoadedFont := true;
      SendMessage(HWND_BROADCAST, WM_FONTCHANGE, 0, 0);
    end;
  end;
  {...}
end; {FormCreate}
</pre>



<p>А FormDestroy так: </p>

<pre>
var
  sFontRes, sAppDir: string;
begin
  {...другой код...}
 
  if bLoadedFont then
  begin
    sAppDir := extractfilepath(Application.ExeName);
    sFontRes := sAppDir + 'MYFONT.TTF' + #0;
    RemoveFontResource(@sFontRes[1]);
    SendMessage(HWND_BROADCAST, WM_FONTCHANGE, 0, 0);
  end;
 
  {...другой код...}
end; {FormDestroy}
</pre>


<p>Для упрощения этого я сделал простую функцию, совмещающую обе этих задачи. Она возвращает логическое значение, говорящая об успехе, или наоборот, о неудаче операции загрузки или выгрузки шрифта.</p>

<pre>
 
{1998-01-16 Функция загрузки и выгрузки шрифта.}
 
function LoadFont(sFontFileName: string; bLoadIt: boolean): boolean;
var
  sFont, sAppDir, sFontRes: string;
begin
  result := TRUE;
 
  if bLoadIt then
  begin
    {Загрузка шрифта.}
    if FileExists(sFontFileName) then
    begin
      sFontRes := sFontFileName + #0;
      if AddFontResource(@sFontRes[1]) = 0 then
        result := FALSE
      else
        SendMessage(HWND_BROADCAST, WM_FONTCHANGE, 0, 0);
    end;
  end
  else
  begin
    {Выгрузка шрифта.}
    sFontRes := sFontFileName + #0;
    result := RemoveFontResource(@sFontRes[1]);
    SendMessage(HWND_BROADCAST, WM_FONTCHANGE, 0, 0);
  end;
end; {LoadFont}
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
