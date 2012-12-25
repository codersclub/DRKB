---
Title: Примеры форматирования строк с использованием API функции wvsprintf
Date: 01.01.2007
---


Примеры форматирования строк с использованием API функции wvsprintf
===================================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Примеры форматирования строк с использованием API-функции wvsprintf
     
    Примеры показывают приемы использования функции wvsprintf в Delphi для
    форматирования строк. Эта функция входит в состав Windows API
    (реализована в user32.dll), поэтому не требует подключения модуля
    SysUtils по сравнению с аналогичной функцией Format.
     
    Зависимости: Windows
    Автор:       Внук, Zhigalin@poria.ru, ICQ:60571446, Самара
    Copyright:   Внук
    Дата:        29 мая 2002 г.
    ***************************************************** }
     
    // Пример использования функции wvsprintf с двумя параметрами разного типа
     
    function WinFormat(out TargetString: AnsiString): Boolean;
    const
      FormatStr = 'String Parameter:"%s", Number Parameter:%05d';
    var
      StrParam: AnsiString;
      NumberParam, FormatResult: Integer;
      ParamArray: array[0..1] of Pointer;
    begin
      NumberParam := 105; // Задаем значение первого параметра
      StrParam := 'Hello'; // Задаем значение второго параметра
      SetLength(TargetString, 50); // Должно быть достаточно места для результата.
      // Без этой строки работать не будет
      ParamArray[0] := @StrParam[1];
      ParamArray[1] := Pointer(NumberParam);
      FormatResult := wvsprintf(PChar(TargetString), FormatStr, PChar(@ParamArray));
      if FormatResult < Length(FormatStr) then // В случае ошибки значение функции
        // меньше длины шаблонной строки
      begin
        TargetString := '';
        Result := False;
      end
      else
        result := True;
    end;
     
    // Пример использования функции wvsprintf с одним параметром
     
    function SimpleWinFormat(out TargetString: AnsiString): Boolean;
    const
      FormatStr = 'Number Parameter:%05d';
    var
      NumberParam, FormatResult: Integer;
    begin
      NumberParam := 112;
      SetLength(TargetString, 50); // Должно быть достаточно места для результата.
      // Без этой строки работать не будет
      FormatResult := wvsprintf(PChar(TargetString), FormatStr,
        PChar(@NumberParam));
      if FormatResult < Length(FormatStr) then // В случае ошибки значение функции
        // меньше длины шаблонной строки
      begin
        TargetString := '';
        Result := False;
      end
      else
        result := True;
    end;
    Пример использования: 
     
    uses Dialogs, ...;
    ...
    var
      S: AnsiString;
      ...
    begin
      ...
        if WinFormat(S) then
        ShowMessage(S)
      else
        ShowMessage('An error has been occured!');
      if SimpleWinFormat(S) then
        ShowMessage(S)
      else
        ShowMessage('An error has been occured!');
      ...
    end;
    ...

 
