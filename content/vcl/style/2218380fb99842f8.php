<h1>Как определить, использует ли пользователь стили?</h1>
<div class="date">01.01.2007</div>


<pre>
function _IsThemeActive: Boolean;
// Returns True if the user uses XP style
const
  themelib = 'uxtheme.dll';
type
  TIsThemeActive = function: BOOL; stdcall;
var
  IsThemeActive: TIsThemeActive;
  huxtheme: HINST;
begin
  Result := False;
  // Check if XP or later Version
  if (Win32Platform  = VER_PLATFORM_WIN32_NT) and
     (((Win32MajorVersion = 5) and (Win32MinorVersion &gt;= 1)) or
      (Win32MajorVersion &gt; 5)) then
  begin
    huxtheme := LoadLibrary(themelib);
    if huxtheme &lt;&gt; 0 then
    begin
      try
        IsThemeActive := GetProcAddress(huxtheme, 'IsThemeActive');
        Result := IsThemeActive;
      finally
       if huxtheme &gt; 0 then
          FreeLibrary(huxtheme);
      end;
    end;
  end;
end;
 
// Example Call:
 
procedure TForm1.Button1Click(Sender: TObject);
begin
 if _IsThemeActive then
   ShowMessage('Windows Themes are active.');
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
&nbsp;</p>
<hr />
<pre>
uses
Themes;
...
if ThemeServices.ThemesEnabled then // Тема использется
</pre>
<p>&nbsp;<br>
<p class="author">Автор Alex </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

