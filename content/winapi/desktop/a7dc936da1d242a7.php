<h1>Как сменить обои на рабочем столе?</h1>
<div class="date">01.01.2007</div>


<p>В принципе, все настройки на фоновый рисунок хранятся в реестре. Поэтому надо сначала скопировать картинку в какое-нибудь место (лучше в каталог Виндов) на случай удаления или переноса исходного файла. Информация по обоям хранится в разделе HKEY_CURRENT_USER\Control Panel\Desktop в параметрах TileWallpaper (если 1 - рисунок размножен, 0 - в центре), Wallpaper - путь к файлу обоев (gif, bmp, jpg), WallpaperStyle - если 2, то обои будут растянуты (отсутствует в 95 винде).</p>
<p>ПОсле установки всех занчений обновляешь рабочий стои и наслаждаешься эффектом. </p>
<div class="author">Автор: Garik </div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>Смена обоев только на время текущего сеанса, после перезагрузки обои восстановятся:</p>
<pre>
var Wallpaper : string;

 
begin
  Wallpaper := 'C:\windows\ACD Wallpaper.bmp';
  SystemParametersInfo (SPI_SETDESKWALLPAPER, 0, PChar(Wallpaper), SPIF_SENDCHANGE)
end;
</pre>

<div class="author">Автор: p0s0l</div>
<hr />
<pre>
program wallpapr;
uses Registry, WinProcs;
 
procedure SetWallpaper(sWallpaperBMPPath:String;bTile:boolean);
var
  reg : TRegIniFile;
begin
// Изменяем ключи реестра
// HKEY_CURRENT_USER
//   Control Panel\Desktop
//     TileWallpaper (REG_SZ)
//     Wallpaper (REG_SZ)
  reg := TRegIniFile.Create('Control Panel\Desktop' );
  with reg do begin
    WriteString( '', 'Wallpaper',  
      sWallpaperBMPPath );
    if( bTile )then
    begin
      WriteString('', 'TileWallpaper', '1' );
    end else begin
      WriteString('', 'TileWallpaper', '0' );
    end;
  end;
  reg.Free;
// Оповещаем всех о том, что мы 
// изменили системные настройки
SystemParametersInfo(SPI_SETDESKWALLPAPER, 0, Nil, 
  {Эта строка - продолжение предыдущей}SPIF_SENDWININICHANGE );
end;
 
 // пример установки WallPaper по центру рабочего стола
 SetWallpaper('c:\winnt\winnt.bmp', False );
//Эту строчку надо написать где-то в программе.
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
var 
  Reg: TRegIniFile; 
begin 
  Reg := TRegIniFile.Create('Control Panel'); 
  Reg.WriteString('desktop', 'Wallpaper', 'c:\windows\mybmp.bmp'); 
  Reg.WriteString('desktop', 'TileWallpaper', '1'); 
  Reg.Free; 
  SystemParametersInfo(SPI_SETDESKWALLPAPER, 0, nil, SPIF_SENDWININICHANGE); 
end
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<div class="author">Автор: Владимир Рыбант </div>
<p>Другие подобные советы не изменяют обои, если в Windows работает режим Active Desktop </p>
<p>Нужно использовать следующее:</p>
<pre>
uses
  ComObj, ShlObj;
 
procedure ChangeActiveWallpaper;
const
  CLSID_ActiveDesktop: TGUID = '{75048700-EF1F-11D0-9888-006097DEACF9}';
var
  ActiveDesktop: IActiveDesktop;
begin
  ActiveDesktop := CreateComObject(CLSID_ActiveDesktop)
    as IActiveDesktop;
  ActiveDesktop.SetWallpaper('c:\windows\forest.bmp', 0);
  ActiveDesktop.ApplyChanges(AD_APPLY_ALL or AD_APPLY_FORCE);
end;
</pre>
<p>Этим способом можно также изменять обои картинками jpg и gif </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
unit Walpaper;
 
interface
 
uses
{$IFDEF WIN32}Windows, Registry, {$ELSE}WinTypes, WinProcs, IniFiles, {$ENDIF}
  Classes, Controls, SysUtils;
 
type
  TWallPaper = class(TComponent)
  private
    PC: array[0..$FF] of Char;
{$IFDEF WIN32}
    Reg: TRegistry;
{$ELSE}
    Reg: TIniFile;
    WinIniPath: string;
{$ENDIF}
 
    function GetWallpaper: string;
    procedure SetWallpaper(Value: string);
    function GetTile: Boolean;
    procedure SetTile(Value: Boolean);
    function GetStretch: Boolean;
    procedure SetStretch(Value: Boolean);
  protected
{$IFNDEF WIN32}
    constructor Create(aOwner: TComponent); override;
{$ENDIF}
  public
  published
    property Wallpaper: string read GetWallpaper write SetWallpaper;
    property Tile: Boolean read GetTile write SetTile;
    property Stretch: Boolean read GetStretch write SetStretch;
  end;
 
procedure Register;
 
implementation
 
{$IFNDEF WIN32}
 
constructor TWallpaper.Create(aOwner: TComponent);
begin
  inherited Create(aOwner);
  GetWindowsDirectory(PC, $FF);
  WinIniPath := StrPas(PC) + '\WIN.INI';
end;
{$ENDIF}
 
function TWallpaper.GetWallpaper: string;
begin
{$IFDEF WIN32}
  Reg := TRegistry.Create;
  Reg.RootKey := HKEY_CURRENT_USER;
  Reg.OpenKey('\Control Panel\desktop\', False);
  Result := Reg.ReadString('Wallpaper');
  Reg.Free;
{$ELSE}
  Reg := TIniFile.Create(WinIniPath);
  Result := Reg.ReadString('Desktop', 'Wallpaper', '');
  Reg.Free;
{$ENDIF}
end;
 
procedure TWallpaper.SetWallpaper(Value: string);
begin
  if not (csDesigning in ComponentState) and
    not (csLoading in ComponentState) and
    not (csReading in ComponentState) then
  begin
    StrPCopy(PC, Value);
    SystemParametersInfo(spi_SetDeskWallpaper, 0, @PC, spif_UpdateIniFile);
  end;
end;
 
function TWallpaper.GetTile: Boolean;
begin
{$IFDEF WIN32}
  Reg := TRegistry.Create;
  Reg.RootKey := HKEY_CURRENT_USER;
  Reg.OpenKey('\Control Panel\desktop\', False);
  Result := Boolean(StrToInt(Reg.ReadString('TileWallpaper')));
  Reg.Free;
{$ELSE}
  Reg := TIniFile.Create(WinIniPath);
  Result := Reg.ReadBool('Desktop', 'TileWallpaper', False);
  Reg.Free;
{$ENDIF}
end;
 
procedure TWallpaper.SetTile(Value: Boolean);
begin
  if not (csDesigning in ComponentState) and
    not (csLoading in ComponentState) and
    not (csReading in ComponentState) then
  begin
{$IFDEF WIN32}
    Reg := TRegistry.Create;
    Reg.RootKey := HKEY_CURRENT_USER;
    Reg.OpenKey('\Control Panel\desktop\', False);
    Reg.WriteString('TileWallpaper', IntToStr(Integer(Value)));
    Reg.Free;
{$ELSE}
    Reg := TIniFile.Create(WinIniPath);
    Reg.WriteBool('Desktop', 'TileWallpaper', Value);
    Reg.Free;
{$ENDIF}
    SetWallpaper(Wallpaper);
  end;
end;
 
function TWallpaper.GetStretch: Boolean;
var
  i: Integer;
begin
{$IFDEF WIN32}
  Reg := TRegistry.Create;
  try
    Reg.RootKey := HKEY_CURRENT_USER;
    Reg.OpenKey('\Control Panel\desktop\', False);
    i := StrToInt(Reg.ReadString('WallpaperStyle'));
  except
  end;
  Reg.Free;
{$ELSE}
  Reg := TIniFile.Create(WinIniPath);
  i := Reg.ReadInteger('Desktop', 'WallpaperStyle', 0);
  Reg.Free;
{$ENDIF}
  Result := i = 2;
end;
 
procedure TWallpaper.SetStretch(Value: Boolean);
var
  v: Integer;
begin
  if not (csDesigning in ComponentState) and
    not (csLoading in ComponentState) and
    not (csReading in ComponentState) then
  begin
    if Value then
      v := 2
    else
      v := 0;
 
{$IFDEF WIN32}
    Reg := TRegistry.Create;
    Reg.RootKey := HKEY_CURRENT_USER;
    Reg.OpenKey('\Control Panel\desktop\', False);
    Reg.WriteString('WallpaperStyle', IntToStr(v));
    Reg.Free;
{$ELSE}
    Reg := TIniFile.Create(WinIniPath);
    Reg.WriteInteger('Desktop', 'WallpaperStyle', v);
    Reg.Free;
{$ENDIF}
    SetWallpaper(Wallpaper);
  end;
end;
 
procedure Register;
begin
  RegisterComponents('JohnUtilend;'
 
end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
program change;
uses 
  windows; 
var 
  s: string; 
begin 
  s := paramStr(1); 
  SystemParametersInfo(SPI_SETDESKWALLPAPER, 0, @S[1], 
    SPIF_UPDATEINIFILE OR SPIF_SENDWININICHANGE); 
end.
 
// Запускаешь:
// change.exe "имя файла с картинкой"
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

