---
Title: Как взять URL из окна IE?
Author: Song
Date: 01.01.2007
---


Как взять URL из окна IE?
=========================

Вариант 1:

Author: Song

Source: Vingrad.ru <https://forum.vingrad.ru>

    uses windows, ddeman, ......
     
    function Get_URL(Servicio: string): String;
    uses windows, ddeman, ......
     
    function Get_URL(Servicio: string): String;
    var
      Cliente_DDE: TDDEClientConv;
      temp:PChar;   
    begin
       Result := '';
       Cliente_DDE:= TDDEClientConv.Create( nil );
        with Cliente_DDE do
           begin
              SetLink( Servicio,'WWW_GetWindowInfo');
              temp := RequestData('0xFFFFFFFF');
              Result := StrPas(temp);
              StrDispose(temp);  //<<-Предотвращаем утечку памяти
              CloseLink;
           end;
         Cliente_DDE.Free;
    end;
     
    procedure TForm1.Button1Click(Sender);
    begin
      showmessage(Get_URL('Netscape'));
         или
      showmessage(Get_URL('IExplore'));
    end; 

------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

Пример показывает, как найти окно Internet Explorer, и захватить из него
текущий URL, находящийся в поле адреса IE. В Исходнике используются
простые функции win32 api на delphi.

    function GetText(WindowHandle: hwnd): string;
    var
      txtLength: integer;
      buffer: string;
    begin
      TxtLength := SendMessage(WindowHandle, WM_GETTEXTLENGTH, 0, 0);
      txtlength := txtlength + 1;
      setlength(buffer, txtlength);
      sendmessage(WindowHandle, wm_gettext, txtlength, longint(@buffer[1]));
      result := buffer;
    end;
     
     
    function GetURL: string;
    var
      ie, toolbar, combo,
        comboboxex, edit,
        worker, toolbarwindow: hwnd;
    begin
      ie := FindWindow(pchar('IEFrame'), nil);
      worker := FindWindowEx(ie, 0, 'WorkerA', nil);
      toolbar := FindWindowEx(worker, 0, 'rebarwindow32', nil);
      comboboxex := FindWindowEx(toolbar, 0, 'comboboxex32', nil);
      combo := FindWindowEx(comboboxex, 0, 'ComboBox', nil);
      edit := FindWindowEx(combo, 0, 'Edit', nil);
      toolbarwindow := FindWindowEx(comboboxex, 0, 'toolbarwindow32', nil);
     
      result := GetText(edit);
    {-------------------------------------------------------}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      showmessage(GetURL);
    end;

