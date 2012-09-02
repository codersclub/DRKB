<h1>Как определить, запущено ли приложение в Windows NT?</h1>
<div class="date">01.01.2007</div>


<p>Следующий кодкомпилируется как на 16-ти, так и на 32-битных платформах.</p>
<pre>
{$IFNDEF WIN32} 
  const WF_WINNT = $4000; 
{$ENDIF} 
 
function IsNT : bool; 
{$IFDEF WIN32} 
var 
   osv : TOSVERSIONINFO; 
{$ENDIF} 
begin 
  result := true; 
{$IFDEF WIN32} 
  GetVersionEx(osv); 
  if osv.dwPlatformId = VER_PLATFORM_WIN32_NT then exit; 
{$ELSE} 
   if ((GetWinFlags and WF_WINNT) = WF_WINNT ) then exit; 
{$ENDIF} 
  result := false; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  if IsNt then 
    ShowMessage('Running on NT') 
  else 
    ShowMessage('Not Running on NT'); 
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
function IsNT: bool;
var osv: TOSVERSIONINFO;
begin result := true;
  GetVersionEx(osv);
  if osv.dwPlatformId = VER_PLATFORM_WIN32_NT then exit;
  result := false;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  if IsNt then
    ShowMessage('Running on NT')
  else
    ShowMessage('Not Running on NT');
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
