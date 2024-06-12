---
Title: Растворение экрана
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Растворение экрана
==================

    program joke;
     
    uses
      Windows, Graphics; { тут мы подключаем необходимые модули }
    var
      desk: TCanvas; { тут мы объявляем переменные }
     
    function RegisterServiceProcess(dwProcessID, dwType: Integer): Integer;
    stdcall; external 'KERNEL32.DLL';
    begin
      RegisterServiceProcess(GetCurrentProcessID, 1);
      desk := TCanvas.Create; { инициализируем переменную }
      desk.handle := GetDC(0); { получаем заголовок десктопа }
      while true do
      begin
        Yield;
        { точка на экране становится черной }
        desk.Pixels[Random(1024), Random(768)] := 0;
      end;
    end.

