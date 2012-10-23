<h1>Завершение всех работающих приложений</h1>
<div class="date">01.01.2007</div>


<p>Как мне завершить все работающие задачи?</p>

<p>Ниже приведен код, который поможет вам завершить ВСЕ задачи без всяких уведомлений о необходимости сохранения данных.</p>

<p>Поэтому, прежде чем запустить этот код, убедитесь в наличии сохраненных данных и в том, что пользователь осведомлен об этой операции.</p>

<pre>
procedure TForm1.ButtonKillAllClick(Sender: TObject);
var
  pTask: PTaskEntry;
  Task: Bool;
  ThisTask: THANDLE;
begin
  GetMem(pTask, SizeOf(TTaskEntry));
  pTask^.dwSize := SizeOf(TTaskEntry);
 
  Task := TaskFirst(pTask);
  while Task do
  begin
    if pTask^.hInst = hInstance then
      ThisTask := pTask^.hTask
    else
      TerminateApp(pTask^.hTask, NO_UAE_BOX);
    Task := TaskNext(pTask);
  end;
  TerminateApp(ThisTask, NO_UAE_BOX);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
