<h1>Как пользоваться командой шелла MinimizeAll?</h1>
<div class="date">01.01.2007</div>


<p>Для этого надо импортировать Microsoft Shell Controls &amp; Automation Type Library.</p>
<p>В меню Project..Import Type Library</p>
<p>Выберите Microsoft Shell Controls &amp; Automation (version 1.0).</p>
<p>Нажмите Install...</p>
<p>На панели компонентов, в закладке ActiveX появится несколько компонентов. Перетащите на форму компонент TShell. После этого, например, можно всё минимизировать:</p>
<p>Shell1.MinimizeAll;</p>
<pre>/*********************************************************************
  Так же в этом компоненте присутствует давольно много забавных примочек.
*********************************************************************/
procedure TForm1.Shell(sMethod: Integer);
begin
  case sMethod of
  0:
     //Минимизируем все окна на рабочем столе
   begin
     Shell1.MinimizeAll;
     Button1.Tag := Button1.Tag + 1;
   end;
  1:
     //Показываем диалоговое окошко Run
   begin
     Shell1.FileRun;
     Button1.Tag := Button1.Tag + 1;
   end;
  2:
     //Показываем окошко завершения работы Windows
   begin
     Shell1.ShutdownWindows;
     Button1.Tag := Button1.Tag + 1;
   end;
  3:
     //Показываем окно поиска файлов
   begin
     Shell1.FindFiles;
     Button1.Tag := Button1.Tag + 1;
   end;
  4:
     //Отображаем окно настройки времени и даты
   begin
     Shell1.SetTime;
     Button1.Tag := Button1.Tag + 1;
   end;
  5:
     //Показываем диалоговое окошко настройки интернета (Internet Properties)
   begin
     Shell1.ControlPanelItem('INETCPL.cpl');
     Button1.Tag := Button1.Tag + 1;
   end;
  6:
     //Предлагаем пользователю выбрать директорию из Program Files
   begin
     Shell1.BrowseForFolder(0, 'My Programs', 0, 'C:\Program Files');
     Button1.Tag := Button1.Tag + 1;
   end;
  7:
     //Показываем диалоговое окошко настройки панели задач
   begin
     Shell1.TrayProperties;
     Button1.Tag := Button1.Tag + 1;
   end;
   8:
     //Восстанавливаем все окна на рабочем столе
   begin
     Shell1.UndoMinimizeAll;
     Button1.Tag := 0;
   end;
  end; {case}
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Shell(Button1.Tag);
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

