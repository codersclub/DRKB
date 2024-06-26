---
Title: Как отследить завершение работы в приложении?
Author: Mazenrat
Date: 01.01.2007
---


Как отследить завершение работы в приложении?
=============================================

Вариант 1:

Нужно отследить момент завершения Windows, и, если пользователь
собирается выключить компьютер - программа должна вывести диалог
запроса. Если пользователь нажимает кнопку YES - разрешаем выключение,
если NO - отменяем. С помощью VCL компонентов это делается элементарно:

    procedure TForm1.FormCloseQuery(Sender: TObject; var CanClose: Boolean); 
    begin 
     //Спрашиваем пользователя, если инициировано завершение работы. 
     if MessageDlg('Вы уверены?', mtConfirmation, mbYesNoCancel, 0) = mrYes 
      then CanClose := true   //Разрешаем завершение работы. 
      else CanClose := false; //Nе разрешаем завершение работы. 
    end;

Author: Mazenrat

Source: Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------
Вариант 2:

Пример отслеживания завершения приложения написанного на чистом API:

    program kvd;
     
    uses
      Windows,
      Messages;
     
    var
      hWnd: THandle;
      WndClass: TWndClass;
      Msg: TMsg;
     
    function WindowProc(hWnd: THandle; uMsg, wParam, lParam: Integer): Integer;
     stdcall;
    begin
     Result:=0;
     case uMsg of
      WM_QUERYENDSESSION:
           Result := integer(false);
       WM_DESTROY:
          PostQuitMessage(0);
     else
       Result := DefWindowProc(hWnd, uMsg, wParam, lParam);
     end;
    end;
     
    begin
     FillChar(WndClass, SizeOf(WndClass), 0);
      with WndClass do begin
       hInstance      := SysInit.hInstance;
       lpszClassName  := 'dd';
       lpfnWndProc    := @WindowProc;
      end;
       RegisterClass(WndClass);
      hWnd := CreateWindow('dd', '', 0, 0, 0, 0, 0, 0, 0, hInstance, NIL);
      if hWnd = 0 then
       Exit;
      ShowWindow(hWnd, SW_HIDE);
      while GetMessage(Msg, 0, 0, 0) do begin
       TranslateMessage(Msg);
       DispatchMessage(Msg);
      end;
    end.

Author: Fantasist

Source: Vingrad.ru <https://forum.vingrad.ru>
