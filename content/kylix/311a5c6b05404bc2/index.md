---
Title: Как запустить консольное приложение и перехватить вывод?
Author: Vit
Date: 01.01.2007
---


Как запустить консольное приложение и перехватить вывод?
========================================================

::: {.date}
01.01.2007
:::

    procedure ExecCmdine(const CmdLine: string; CmdResult: TStrings);
    var
      Output: PIOFile;
      Buffer: PChar;
      TempString: string;
      Line: string;
      BytesRead: Integer;
     
    const
      BufferSize: Integer = 1000;
     
    begin
      Output := popen(PChar(CmdLine), 'r');
      GetMem(Buffer, BufferSize);
      if Assigned(Output) then
      try
        while feof(Output) = 0 do
        begin
          BytesRead := Libc.fread(Buffer, 1, BufferSize, Output);
          SetLength(TempString, Length(TempString)+BytesRead);
          memcpy(@TempString[length(TempString)-(BytesRead-1)], Buffer, BytesRead);
          while Pos(#10, TempString) > 0 do
          begin
            Line := Copy(TempString, 1, Pos(#10, TempString)-1);
            if CmdResult<>nil then CmdResult.Add(Line);
            TempString := copy(TempString, Pos(#10, TempString)+1, Length(TempString));
          end;
        end;
      finally
        Libc.pclose(output);
        wait(nil);
        FreeMem(Buffer,BufferSize);
      end;
    end;

Примечание

Под отладчиком Kylix код может не работать. Надо запускать приложение не
под Kylix для того чтобы удостовериться что код работает. Кроме того
некоторые консольные приложения, типа top не совсем стандартно
используют консоль, поэтому я наблюдала такое явление, что  top можно
запустить только если запускать готовое приложение в терминале.

Автор: Vit
