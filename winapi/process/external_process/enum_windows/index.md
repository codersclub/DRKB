---
Title: Пример EnumWindows
Date: 01.01.2007
---

Пример EnumWindows
==================

::: {.date}
01.01.2007
:::

Создайте форму и разместите на ней два компонента ListBox.

Скопируйте код, показанный ниже.

Запустите SysEdit.

Запустите форму Delphi. Первый ListBox должен содержать список всех
запущенных приложений. Дважды щелкните на SysEdit и нижний ListBox
покажет дочернее MDI-окно программы SysEdit.

Paul Powers (Borland)

    unit Wintask1;
     
     
    interface
     
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
     
    type
      TForm1 = class(TForm)
        ListBox1: TListBox;
        ListBox2: TListBox;
        procedure FormCreate(Sender: TObject);
        procedure ListBox1DblClick(Sender: TObject);
      private
        function enumListOfTasks(hWindow: hWnd): Bool; export;
        function enumListOfChildTasks(hWindow: hWnd): Bool; export;
      end;
     
     
      THoldhWnd = class(TObject)
      private
      public
        hWindow: hWnd;
      end;
     
     
    var
      Form1: TForm1;
     
     
    implementation
     
     
    {$R *.DFM}
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      enumWindows(@TForm1.EnumListOfTasks, Longint(Self));
      if (ListBox1.Items.Count > 0) then
        ListBox1.ItemIndex := 0;
    end;
     
     
    function TForm1.enumListOfTasks(hWindow: hWnd): Bool;
    var
      HoldString: PChar;
      WindowStyle: Longint;
      IsAChild: Word;
      HoldhWnd: THoldhWnd;
     
     
    begin
      GetMem(HoldString, 256);
     
     
      HoldhWnd := THoldhWnd.Create;
      HoldhWnd.hWindow := hWindow;
     
     
      WindowStyle := GetWindowLong(hWindow, GWL_STYLE);
      WindowStyle := WindowStyle and Longint(WS_VISIBLE);
      IsAChild := GetWindowWord(hWindow, GWW_HWNDPARENT);
     
     
     
    {Добавляем строку с текстом задачи или именем класса и дескриптор в ListBox1.Items }
      if (GetWindowText(hWindow, HoldString, 255) > 0) and
        (WindowStyle > 0) and (IsAChild = Word(nil)) then
        ListBox1.Items.AddObject(StrPas(HoldString), TObject(HoldhWnd))
      else if (GetClassName(hWindow, HoldString, 255) > 0) and
        (WindowStyle > 0) and (IsAChild = Word(nil)) then
        ListBox1.Items.AddObject(Concat('<', StrPas(HoldString), '>'), TObject(HoldhWnd));
     
     
      FreeMem(HoldString, 256);
      HoldhWnd := nil;
      Result := TRUE;
    end;
     
     
    function TForm1.enumListOfChildTasks(hWindow: hWnd): Bool;
    var
      HoldString: PChar;
      WindowStyle: Longint;
      IsAChild: Word;
      HoldhWnd: THoldhWnd;
     
     
    begin
      GetMem(HoldString, 256);
     
     
      HoldhWnd := THoldhWnd.Create;
      HoldhWnd.hWindow := hWindow;
     
     
      WindowStyle := GetWindowLong(hWindow, GWL_STYLE);
      WindowStyle := WindowStyle and Longint(WS_VISIBLE);
      IsAChild := GetWindowWord(hWindow, GWW_HWNDPARENT);
     
     
    {Добавляем строку с текстом задачи или именем класса и дескриптор в ListBox1.Items }
      if (GetWindowText(hWindow, HoldString, 255) > 0) and
        (WindowStyle > 0) and (IsAChild <> Word(nil)) then
        ListBox2.Items.AddObject(StrPas(HoldString), TObject(HoldhWnd))
      else if (GetClassName(hWindow, HoldString, 255) > 0) and
        (WindowStyle > 0) and (IsAChild = Word(nil)) then
        ListBox2.Items.AddObject(Concat('<', StrPas(HoldString), '>'), TObject(HoldhWnd));
     
     
      FreeMem(HoldString, 256);
      HoldhWnd := nil;
      Result := TRUE;
    end;
     
     
    procedure TForm1.ListBox1DblClick(Sender: TObject);
    begin
     
      enumChildWindows(THoldhWnd(ListBox1.Items.Objects[ListBox1.ItemIndex]).hWindow, @TForm1.enumListOfChildTasks, Longint(Self));
     
      ListBox2.RePaint;
    end;
     
     
    end.

Дополнение

В Kuliba1000.chm Win32 API/Разное/Пример EnumWindows есть принципиальная
ошибка в коде:

ЛЮБАЯ callback ( обратного вызова ) функция в Delphi должна
сопровождаться директивой stdcall.

Предоставленный пример просто не работает.

Определение класса формы должно выглядеть как-то так:

     
    type
      TForm1 = class(TForm)
        ListBox1: TListBox;
        ListBox2: TListBox;
        procedure FormCreate(Sender: TObject);
        procedure ListBox1DblClick(Sender: TObject);
      private
        function enumListOfTasks(hWindow: hWnd): Bool; stdcall;
        function enumListOfChildTasks(hWindow: hWnd): Bool; stdcall;
      end;

Директивы export (это написано в Help\'е) просто не работают
(игнорируются) под Win 32 :(

С наилучшими пожеданиями

Андрей Бреслав

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
