<h1>Пример DDE и WordPerfect</h1>
<div class="date">01.01.2007</div>

<p>Вот небольшой пример, скопированный из моего проекта:</p>
<pre class="delphi">
procedure TForm1.PrintSave(Doc: string);
var
  ProdDoc, ArchDoc: string;
  WPCommands: TStringList;
begin
  ProdDoc := ProdDrive + Doc;
  ArchDoc := ArchDrive + Doc;
 
  WPCommands := TStringList.Create;
  with WPCommands do
  begin
    Add('FileOpen(Filename:"' + ProdDoc + '")');
    Add('FileSave(Filename:"' + ProdDoc + '";ExportType:3;Overwrite:1)');
 
    Add('PrintCopies(NumberOfCopies:2)');
    Add('PrintCopiesBy(CopiesBy:1) ');
    Add('PrintFullDoc() ');
    Add('DocCompare(FileName:"' + ArchDoc + '";CompFlags:1) ');
    Add('FileSave(Filename:"' + EMailDoc + '";ExportType:3;Overwrite:1');
 
    Add('Close(Save:0) ');
  end;
 
  if PDDE.ExecuteMacroLines(WPCommands, True) then
  begin
    log('WPCommand Worked!')
      {  Теперь необходимо подождать WP, чтобы завершить команду... }
  end
  else
    log('Ошибка WPCommand!');
 
  WPCommands.Free;
end;
</pre>

<p class="note">Примечание</p>
<p>Вы не можете использовать 'True!' или 'False!', как это делается в макросах WP. Вы должны использовать числовые значения. Как узнать числовой эквивалент команды: если в WP использовать построитель макросов, то можно передавать перечислимые типы в диалоговое окно и узнавать их числовой эквивалент.</p>
<p>Все это проверено, DDE работает в связке WP/Delphi, первая команда возвращает сообщение 'Ok, я получил это', и запускает макрос. При попытке послать второй запрос DDE, он ожидает завершение обработки первого, выводит сообщение типа 'Необходимо подождать....', после чего немедленно передает управление. Мне хотелось бы дождаться команды завершения прежде, чем я возвращусь из своей процедуры.</p>

<div class="author">Автор: John Studt</div>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
