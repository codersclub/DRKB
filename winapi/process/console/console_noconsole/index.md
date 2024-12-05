---
Title: Как использовать консоль в неконсольном приложении?
Date: 01.01.2007
---

Как использовать консоль в неконсольном приложении?
===================================================

Вариант 1:

Source: <https://forum.sources.ru>

Для того, чтобы добавить в не-консольное приложение ввод/вывод из
консоли, необходимо воспользоваться функциями AllocConsole и
FreeConsole.

Пример:

    procedure TForm1.Button1Click(Sender: TObject); 
    var 
       s: string; 
    begin 
      AllocConsole; 
      try 
        Write('Type here your words and press ENTER: '); 
        Readln(s); 
        ShowMessage(Format('You typed: "%s"', [s])); 
      finally 
        FreeConsole; 
      end; 
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    { 
      For implementing console input/output for non-console applications you 
      should use the AllocConsole and FreeConsole functions. 
      The AllocConsole function allocates a new console for the calling process. 
      The FreeConsole function detaches the calling process from its console. 
      Example below demonstrates using these functions: 
    }
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      s: string;
    begin
      AllocConsole;
      try
        // Change color attributes 
       SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE),
                                            FOREGROUND_BLUE OR FOREGROUND_GREEN or
                                            BACKGROUND_RED );
        Write('Type here your words and press ENTER: ');
        Readln(s);
        ShowMessage(Format('You typed: "%s"', [s]));
      finally
        FreeConsole;
      end;
    end;

