---
Title: Список окон + определение приложения, создавшего эти окна
Author: Rouse\_
Date: 01.01.2007
---

Список окон + определение приложения, создавшего эти окна
=========================================================

::: {.date}
01.01.2007
:::

    ////////////////////////////////////////////////////////////////////////////////
    //
    //  Автор: Александр (Rouse_) Багель
    //  © Fangorn Wizards Lab 1998 - 2002
    //  16 октября 2002 18:21
     
    //  Данный код приведен лишь для демонстрации
    //  А простой вариант поиска Handle Ричедита выглядит так
    //  var
    //    Handle : HWND;
    //  begin
    //    Handle:= FindWindowEx(FindWindow(Название формы например 'Form1',nil), 0, Название элемента например 'Button1',  nil),  0, true);
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ComCtrls;
     
    type
      TMainForm = class(TForm)
        TreeView1: TTreeView;
        procedure FormCreate(Sender: TObject);
        procedure Sys_Windows_Tree(Node: TTreeNode; Handle: HWND);
      end;
     
    var
      MainForm: TMainForm;
     
    implementation
     
    {$R *.DFM}
     
    ////////////////////////////////////////////////////////////////////////////////
    //
    //  Стартовая функция, запускаем рекуссию используя хэндл рабочего стола
    //
     
    procedure TMainForm.FormCreate(Sender: TObject);
    var
      StartHandle : THandle;
    begin 
      //Если требуется найти только данные по одному приложению
      //замени 2 строки в функциях их закоментированными аналогами
      StartHandle := GetDeskTopWindow;
      //StartHandle := 67324;//FindWindow(PChar(Caption), nil);  //На примере Винампа
      Sys_Windows_Tree(nil, StartHandle);
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    //
    //  Рекурсивная функция, строит дерево всех открытых окон, кнопок, едитов и т.д.
    //  В качестве входных данных получает узел дерева и Хэндл окна
    //
     
    procedure TMainForm.Sys_Windows_Tree(Node: TTreeNode; Handle: HWND);
    const
      MAX = 128;
    var
      TmpArray  : array[0..MAX - 1] of Char;
      Result    : String;
      szFileName : array[0..255] of Char;
      iSize : Integer;
      PID: Cardinal;
    begin
      //Запускаем цикл пока не закончатся окна
      while Handle <> 0 do
      begin
        //Получаем имя класса окна
        GetClassName(Handle, @TmpArray, MAX);
        Result := String(TmpArray);
        //Получаем текст (Его Caption) окна
        GetWindowText(Handle, @TmpArray, MAX);
        // Получаем имя модуля
        if GetwindowModuleFilename(Handle, szFileName, SizeOf(szFileName)) = 0 then
          ZeroMemory(@szFileName[0], 256);
        GetWindowThreadProcessId(Handle, PID);
        Result := Result + ' [' + String(szFileName) + '] (' + String(TmpArray) +
          '): Handle = '+ IntToStr(Handle) + ', PID = ' + IntToStr(PID);
        //В следующей процедуре, в скобках, добавляем результат
        //в дерево, получаем хэндл дочернего окна и с результатами
        //выполнения этих двух функций выполняем процедуру Sys_Windows_Tree
        Sys_Windows_Tree(TreeView1.Items.AddChild(Node, Result),
          GetWindow(Handle, GW_CHILD));
        //Получаем хэндл следующего (не дочернего) окна
        Handle := GetNextWindow(Handle, GW_HWNDNEXT);
        //Handle := 0;
      end;
    end; 
     
     
    end.



Взято из <https://forum.sources.ru>

Автор: Rouse\_
