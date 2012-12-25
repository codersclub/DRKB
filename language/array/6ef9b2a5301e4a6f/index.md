---
Title: TMemoryStream \> Array of Byte
Author: Rouse\_
Date: 01.01.2007
---


TMemoryStream \> Array of Byte
==============================

::: {.date}
01.01.2007
:::

Для преобразования TMemoryStream в array of Byte можно использовать
следующий код:\

 

    procedure TForm1.Button1Click(Sender: TObject);

    var
      M: TMemoryStream;
      Buff: array of Byte;
    begin
      M := TMemoryStream.Create;
      try
        M.LoadFromFile('c:\test.htm');
        SetLength(Buff, M.Size);
        M.Position := 0;
        M.Read(Buff[0], M.Size);
      finally
        M.Free;
      end;
    end;

 \

 \

Автор: Rouse\_
