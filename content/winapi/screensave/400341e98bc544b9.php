<h1>Инсталляция screensaver'a</h1>
<div class="date">01.01.2007</div>


<pre>
uses
   shellapi;
 
 procedure InstallScreenSaver(const FileName: string);
 begin
   { Set this screensaver as default screensaver and open the properties dialog}
   ShellExecute(Application.Handle, 'open', PChar('rundll32.exe'),
     PChar('desk.cpl,InstallScreenSaver ' + FileName), nil, SW_SHOWNORMAL);
 end;
 
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   InstallScreenSaver('c:\YourScreenSaverFile.scr');
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

