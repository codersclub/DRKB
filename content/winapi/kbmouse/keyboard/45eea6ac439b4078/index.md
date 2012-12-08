---
Title: Как конвертировать виртуальную клавишу в ASCII-код?
Date: 01.01.2007
---


Как конвертировать виртуальную клавишу в ASCII-код?
===================================================

::: {.date}
01.01.2007
:::

Получаем символ, соответствующий виртуальной клавише:

    function GetCharFromVKey(vkey: Word): string;
    var
      keystate: TKeyboardState;
      retcode: Integer;
    begin
      Win32Check(GetKeyboardState(keystate));
      SetLength(Result, 2);
      retcode := ToAscii(vkey,
        MapVirtualKey(vkey, 0),
        keystate, @Result[1],
        0);
      case retcode of
        0: Result := '';
        1: SetLength(Result, 1);
        2: ;
        else
          Result := '';
      end;
    end;
     
    {
    Использование:
    procedure TForm1.Edit1KeyDown
      (Sender: TObject; var Key: Word;
      Shift: TShiftState);
    begin
      ShowMessage(GetCharFromVKey(Key));
    end; 
    }

Взято из <https://forum.sources.ru>
