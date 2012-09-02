<h1>Как использовать файлы справки?</h1>
<div class="date">01.01.2007</div>



<pre>
{ First we need to tell the Application object the name 
  of the Help file and where to locate it. } 
 
Application.HelpFile := ExtractFilePath(Application.ExeName) + 'YourHelpFile.hlp'; 
 
{ To Show a help file's content tab: } 
Application.HelpCommand(HELP_CONTENTS, 0); 
{  To display a specific topic of your help file: } 
Application.HelpJump('TApplication_HelpJump'); 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr />Вот код для трех стандартных пунктов меню "Help":</p>

<pre>
procedure TForm1.Contents1Click(Sender: TObject);
begin
  Application.HelpCommand(HELP_CONTENTS, 0);
end;
 
procedure TForm1.SearchforHelpOn1Click(Sender: TObject);
begin
  Application.HelpCommand(HELP_PARTIALKEY, 0);
end;
 
procedure TForm1.HowtoUseHelp1Click(Sender: TObject);
begin
  Application.HelpCommand(HELP_HELPONHELP, 0);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

