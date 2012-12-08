---
Title: Как получить переменные окружения типа PATH и PROMPT?
Date: 01.01.2007
---


Как получить переменные окружения типа PATH и PROMPT?
=====================================================

::: {.date}
01.01.2007
:::

Вариант 1:

Для этого используется API функция GetEnvironmentVariable.

GetEnvironmentVariable возвращает значения:

\- В случае удачного выполнения функции, возвращаемое значение содержит
количество символов, хранящихся в буфере, не включая последнего
нулевого.

\- Если указанная переменная окружения для текущего процесса не найдена,
то возвращаемое значение равно нулю.

\- Если буфер не достаточного размера, то возвращаемое значение равно
требуемому размеру для хранения строки значения и завершающего нулевого
символа.

    function GetDOSEnvVar(const VarName: string): string; 
    var 
      i: integer; 
    begin 
      Result := ''; 
      try 
        i := GetEnvironmentVariable(PChar(VarName), nil, 0); 
     
        if i > 0 then 
          begin 
            SetLength(Result, i); 
            GetEnvironmentVariable(Pchar(VarName), PChar(Result), i); 
          end; 
      except 
        Result := ''; 
      end; 
    end; 

------------------------------------------------------------------------

Вариант 2:

    procedure TMainFrm.AddVarsToMemo(Sender: TObject); 
    var 
      p : pChar; 
    begin 
      Memo1.Lines.Clear; 
      Memo1.WordWrap := false; 
      p := GetEnvironmentStrings; 
      while p^ <> #0 do begin 
        Memo1.Lines.Add(StrPas(p)); 
        inc(p, lStrLen(p) + 1); 
      end; 
    FreeEnvironmentStrings(p); 
    end; 

Взято из <https://forum.sources.ru>
