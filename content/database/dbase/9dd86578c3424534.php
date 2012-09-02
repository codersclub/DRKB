<h1> Как прочитать базу данных с Досовским шрифтом</h1>
<div class="date">01.01.2007</div>


<p>При старте приложения попробуй вызвать вот такую процедуру:<br>
<p>&nbsp;</p>
<pre>
procedure SetLangForParadoxAndDBase;
var
  p :TStringList;
  c :TConfigMode;
begin
  p := TStringList.Create;
  c := Session.ConfigMode; Session.ConfigMode := cmSession;
  try
    p.Text := 'LANGDRIVER=ancyrr'^M^J'LEVEL=7';
    Session.ModifyDriver('PARADOX',p);
    p.Text := 'LANGDRIVER=db866ru0'^M^J'LEVEL=7';
    Session.ModifyDriver('DBASE',p);
  finally
    Session.ConfigMode := c;
    p.Free;
  end;
end;
</pre>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
