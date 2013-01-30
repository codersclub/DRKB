---
Title: Как пользоваться командой шелла MinimizeAll?
Date: 01.01.2007
---


Как пользоваться командой шелла MinimizeAll?
============================================

::: {.date}
01.01.2007
:::

Для этого надо импортировать Microsoft Shell Controls & Automation Type
Library.

В меню Project..Import Type Library

Выберите Microsoft Shell Controls & Automation (version 1.0).

Нажмите Install\...

На панели компонентов, в закладке ActiveX появится несколько
компонентов. Перетащите на форму компонент TShell. После этого,
например, можно всё минимизировать:

Shell1.MinimizeAll;

    /*********************************************************************
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

Взято из <https://forum.sources.ru>
