---
Title: Чтение из открытого файла
Author: neutrino
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Чтение из открытого файла
=========================

Вариант 1:

Author: neutrino

Даже если файл открыт с низкими привелегиями (используя ReadOnly,
ShareReadWrite), иногда открытие уже открытого файла может приводить к
ошибкам, особенно, если это файл интенсивно используется другим
приложением. Самый простой способ решить эту проблемму - это
использовать MemoryStream вместо непосредственного доступа к файлу:

    var Memory: TMemoryStream;
     
    begin
      Memory := TMemoryStream.Create;
      try
        Memory.LoadFromFile('busyfile.dat'); // это он!!
        ..
          Memory.Read(...); // Вы можете использовать методы чтения как у файлов
          Memory.Seek(...);
          FileSize := Memory.Size;
          ..
      finally
        Memory.Free;
      end;
    end;

Данный способ никогда не открывает файл, а заместо этого создаёт копию
его в памяти. Конечно Вы можете и записать в поток (Stream) в
Памяти(Memory), но изменения не будут записаны на диск до тех пор, пока
Вы не запишете их в файл (командой SaveToFile).


**Комментарий от Vit:**

Решение хорошее, но накладно если файл большой...


------------------------------------------------------------------------

Вариант 2:

Author: Vit

    var b:string[15];
    begin
      with TFileStream.create('c:\MyFile.doc', fmShareDenyNone) do
      try
        read(b,14);
        showmessage(b);
      finally
        Free;
    end;


------------------------------------------------------------------------

Вариант 3:

Author: PILOTIK

    procedure TForm1.Button1Click(Sender: TObject);
    type
      AnyType = byte; // ??? ???? ?????
    var
      F: file of AnyType;
    const
      FName = 'D:/Exp.exe'; //?????????? ????
    begin
      AssignFile(F, FName); { File selected in dialog }
      FileMode:=fmOpenRead;
      Reset(F);
      // ...
      // ...
      CloseFile(F);
      FileMode:=fmOpenReadWrite;
    end;


