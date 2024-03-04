---
Title: Запись потока в BLOB-поле
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Запись потока в BLOB-поле
=========================

Вся хитрость заключается в использовании StrPcopy (помещения вашей
строки в PChar) и записи буфера в поток. Вы не сможете передать это в
PChar непосредственно, поскольку ему нужен буфер, поэтому для получения
необходимого размера буфера используйте \<BufferName\>[0] и StrLen().

Вот пример использования TMemoryStream и записи его в Blob-поле:

    var
      cString: string;
      oMemory: TMemoryStream;
      Buffer: PChar;
    begin
      cString := 'Ну, допустим, хочу эту строку!';
     
      { СОздаем новый поток памяти }
      oMemory := TMemoryStream.Create;
     
      {!! Копируем строку в PChar }
      StrPCopy(Buffer, cString);
     
      { Пишем =буфер= и его размер в поток }
      oMemory.Write(Buffer[0], StrLen(Buffer));
     
      {Записываем это в поле}
      < Blob / Memo / GraphicFieldName > .LoadFromStream(oMemory);
     
      { Необходимо освободить ресурсы}
      oMemory.Free;
    end;

