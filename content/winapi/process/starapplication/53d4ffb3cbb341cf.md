Завершение всех работающих приложений
=====================================

::: {.date}
01.01.2007
:::

Как мне завершить все работающие задачи?

Ниже приведен код, который поможет вам завершить ВСЕ задачи без всяких
уведомлений о необходимости сохранения данных.

Поэтому, прежде чем запустить этот код, убедитесь в наличии сохраненных
данных и в том, что пользователь осведомлен об этой операции.

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

Взято с <https://delphiworld.narod.ru>
