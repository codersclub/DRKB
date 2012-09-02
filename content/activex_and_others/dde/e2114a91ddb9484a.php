<h1>GROUPFILE и ADDITEM для групп</h1>
<div class="date">01.01.2007</div>

Вот код для создания файла группы и добавления в группу файла-элемента. Чтобы использовать эту процедуру, определите DDE clientconv App как ProgMan.</p>
<pre>
procedure TMainForm.CreateWinGroup(Sender: TObject);
var
  Name: string;
  Name1: string;
  Macro: string;
  Macro1: string;
  Cmd, Cmd1: array[0..255] of Char;
begin
  {destDir - dos-каталог, хранящий YourFile.Ext'}
  Name := 'GroupName';
  Name1 := destDir + 'YourFile.Ext, FileName_in_Group ';
  Macro := Format('[CreateGroup(%s)]', [Name]) + #13#10;
  Macro1 := Format('[Additem(%s)]', [Name1]) + #13#10;
  StrPCopy(Cmd, Macro);
  StrPCopy(cmd1, Macro1);
  DDEClient.OpenLink;
  if not DDEClient.ExecuteMacro(Cmd, False) then
    MessageDlg('Невозможно создать группу ' + Name, mtInformation, [mbOK], 0)
  else
  begin
    DDEClient.ExecuteMacro(Cmd1, False);
  end;
  DDEClient.CloseLink;
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

