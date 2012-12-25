---
Title: Как загрузить юникоды в мемо?
Date: 01.01.2007
---


Как загрузить юникоды в мемо?
=============================

::: {.date}
01.01.2007
:::

    procedure LoadUnicodeFile(const filename: string; strings: TStrings);
     
      procedure SwapWideChars(p: PWideChar);
      begin
        while p^ <> #0000 do
        begin
          p^ := WideChar(Swap(Word(p^)));
          Inc(p);
        end;
      end;
     
    var
      ms: TMemoryStream;
      wc: WideChar;
      pWc: PWideChar;
    begin
      ms := TMemoryStream.Create;
      try
        ms.LoadFromFile(filename);
        ms.Seek(0, soFromend);
        wc := #0000;
        ms.Write(wc, sizeof(wc));
        pWC := ms.Memory;
        if pWc^ = #$FEFF then {normal byte order mark}
          Inc(pWc)
        else if pWc^ = #$FFFE then
        begin {byte order is big-endian}
          SwapWideChars(pWc);
          Inc(pWc);
        end
        else
          ; {no byte order mark}
        strings.Text := WideChartoString(pWc);
      finally
        ms.free;
      end;
    end;

Использовать

LoadUnicodeFile(filename, memo1.lines);

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
