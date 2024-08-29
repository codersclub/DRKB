---
Title: Как скрыть / показать иконки на рабочем столе?
Date: 01.01.2007
---


Как скрыть / показать иконки на рабочем столе?
==============================================

Вариант 1:


    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      // скрыть иконки
      ShowWindow(FindWindow(nil,'Program Manager'),SW_HIDE); 
    end; 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      // показать иконки
      ShowWindow(FindWindow(nil,'Program Manager'),SW_SHOW); 
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

    procedure ShowDesktop(const YesNo : boolean);
    var h : THandle;
    begin
     h := FindWindow('ProgMan', nil);
     h := GetWindow(h, GW_CHILD);
     if YesNo = True then
       ShowWindow(h, SW_SHOW)
     else
       ShowWindow(h, SW_HIDE);
    end;
     
    {Использование:}
    {Скрыть иконки на рабочем столе}
    ShowDesktop(False);
    {Показать иконки на рабочем столе}
    ShowDesktop(true);

