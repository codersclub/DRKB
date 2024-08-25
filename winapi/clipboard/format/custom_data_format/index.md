---
Title: Сохранение данных в Clipboard
Author: Vladimir Timonin
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Сохранение данных в Clipboard
=============================

Вопрос:

> Мне нужно использовать clipboard для сохранения данных в собственном
> формате и я хочу для этого написать набор процедур ввода/вывода с
> использованием потоков (streams). Возможно ли создать объект
> TMemoryStream, эаполнить его и поместить в Clipboard?

Ответ:

Hе только возможно, именно так поступают функции Clipboard.GetComponent
и Clipboard.SetComponent. Сначала вы должны зарегистрировать свой
собственный формат данных для Clipboard с помощью функции
RegisterClipboardFormat:

    CF_MYFORMAT := RegisterClipboardFormat('My Format Description');

Далее вы должны выполнить шаги:

1. Создать поток (memory stream) и записать туда данные.

2. Создать глобальный буфер в памяти и скопировать поток туда.

3. Вызвать Clipboard.SetAsHandle(), чтобы поместить буфер в Clipboard.

Пример:

    var
      hBuf: THandle;
      Bufptr: Pointer;
      MStream: TMemoryStream;
    begin
      MStream := TMemoryStream.Create;
      try
      { write your data to the stream }
        hBuf := GlobalAlloc(GMEM_MOVEABLE, MStream.Size);
        try
          BufPtr := GlobalLock(hBuf);
          try
            Move(MStream.Memory^, BufPtr^, MStream.Size);
            Clipboard.SetAsHandle(CF_MYFORMAT, hBuf);
          finally
            GlobalUnlock(hBuf);
          end;
        except
          GlobalFree(hBuf);
          raise;
        end;
      finally
        MStream.Free;
      end;
    end;

Внимание: не уничтожайте буфер, созданный с GlobalAlloc. Поскольку вы
поместили его в Clipboard, это уже дело clipboard\'а его уничтожить.
Опять же, получая буфер из Clipboard, не уничтожайте этот буфер - просто
сделайте копию содержимого.

Для обратного получения потока и данных, сделайте что-нибудь вроде
этого:

    var
      hBuf: THandle;
      BufPtr: Pointer;
      MStream: TMemoryStream;
    begin
      hBuf := Clipboard.GetAsHandle(CF_MYFORMAT);
      if hBuf <> 0 then

      begin
        BufPtr := GlobalLock(hBuf);
        if BufPtr <> nil then
        try
          MStream := TMemoryStream.Create;
          try
            MStream.WriteBuffer(BufPtr^, GlobalSize(hBuf));
            MStream.Position := 0;
          { read your data from the stream }
          finally
            MStream.Free;
          end;
        finally
          GlobalUnlock(hBuf);
        end;
      end;
    end;


