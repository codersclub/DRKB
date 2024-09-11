---
Title: Как получить дескриптор окна консоли?
Date: 01.01.2007
---

Как получить дескриптор окна консоли?
=====================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

В следующем примере используется функция Windows API FindWindow().
Обратите внимание, что WndClass консольного окна отличаются для Windows
95 и Window NT и заголовок окна может содержать полный путь под Windows
NT.

     procedure TForm1.Button1Click(Sender: TObject); 
     var 
       info : TOSVersionInfo; 
       ClassName : string; 
       Title : string; 
     begin 
      {Проверяем -  Win95 или NT.} 
       info.dwOSVersionInfoSize := sizeof(info); 
       GetVersionEx(info); 
       if (info.dwPlatformId = VER_PLATFORM_WIN32_NT) then begin 
         ClassName := 'ConsoleWindowClass'; 
         Title := 'Command Prompt'; 
       end else begin 
         ClassName := 'tty'; 
         Title := 'MS-DOS Prompt'; 
       end; 
       ShowMessage(IntToStr(FindWindow(PChar(ClassName), PChar(Title)))); 
     end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

При поиске окон, как отмечалось, нужен класс и имя, так вот - если Вы
ищите DOS-окно, то его класс всегда = \'tty\'.


