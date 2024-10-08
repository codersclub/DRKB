---
Title: Буфер обмена (Clipboard) и TMemoryStream
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Буфер обмена (Clipboard) и TMemoryStream
========================================

Обычно, это нужно для того, чтобы запихнуть в буфер обмена данные
собственного формата. Сначала необходимо зарегистрировать этот формат
при помощи функции RegisterClipboardFormat():

    CF_MYFORMAT := RegisterClipboardFormat('My Format Description');

Затем необходимо проделать следующие шаги:

1. Создать поток (stream) и записать в него данные.

2. Создать в памяти глобальный буфер и скопировать в него поток (stream).

3. При помощи Clipboard.SetAsHandle() поместить глобальный буфер в буфер обмена.

Пример:

    var
      hbuf    : THandle;
      bufptr  : Pointer;
      mstream : TMemoryStream;
    begin
      mstream := TMemoryStream.Create;
      try
        {-- Записываем данные в mstream. --}
        hbuf := GlobalAlloc(GMEM_MOVEABLE, mstream.size);
        try
          bufptr := GlobalLock(hbuf);
          try
            Move(mstream.Memory^, bufptr^, mstream.size);
            Clipboard.SetAsHandle(CF_MYFORMAT, hbuf);
          finally
            GlobalUnlock(hbuf);
          end;
        except
          GlobalFree(hbuf);
          raise;
        end;
      finally
        mstream.Free;
      end;
    end;

ВАЖНО: Не удаляйте буфер после GlobalAlloc(). Как только Вы поместите
его в буфер обмена, то буфер обмена будет пользоваться им.

Для получения данных из потока, можно воспользоваться следующим кодом:

    var
      hbuf    : THandle;
      bufptr  : Pointer;
      mstream : TMemoryStream;
    begin
      hbuf := Clipboard.GetAsHandle(CF_MYFORMAT);
      if hbuf <> 0 then begin
        bufptr := GlobalLock(hbuf);
        if bufptr <> nil then begin
          try
            mstream := TMemoryStream.Create;
            try
              mstream.WriteBuffer(bufptr^, GlobalSize(hbuf));
              mstream.Position := 0;
              {-- Читаем данные из mstream. --}
            finally
              mstream.Free;
            end;
          finally
            GlobalUnlock(hbuf);
          end;
        end;
      end;
    end;

