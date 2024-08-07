---
Title: Как вставить содержимое файла в текущую позицию TMemo?
Date: 01.01.2007
---


Как вставить содержимое файла в текущую позицию TMemo?
======================================================

Вариант 1:

Source: <https://forum.sources.ru>

Для чтения файла будем использовать TMemoryStream, а затем используем
метод SetSelTextBuf() из TMemo, чтобы вставить в него текст:

    var
      TheMStream : TMemoryStream;
      Zero : char;
    begin
      TheMStream := TMemoryStream.Create;
      TheMStream.LoadFromFile('C:\AUTOEXEC.BAT');
      TheMStream.Seek(0, soFromEnd);
    //Буфер завершается нулём!
      Zero := #0;
      TheMStream.Write(Zero, 1);
      TheMStream.Seek(0, soFromBeginning);
      Memo1.SetSelTextBuf(TheMStream.Memory);
      TheMStream.Free;
    end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

> Как мне импортировать файл в элемент управления TMemo начиная с позиции
> курсора? LoadFromFile заменяет содержимое TMemo содержимым текстового
> файла. Я хочу включить текстовый файл или в поцизию курсора или, если
> выбран текст, заменить этот текст содержимым текстового файла. Все это
> должно быть похоже на работу фунции PasteFromClipboard.

Самый простой путь вставки текста в компонент Memo заключается в посылке
ему сообщения EM\_REPLACESEL.

    { InsertFileInMemo--
     
    ПРИМЕЧАНИЕ: если вы хотите заменить к настоящему времени
    выбранный в Memo текст, передайте в параметре ReplaceSel
    TRUE. FALSE необходим для простой вставки текста... }
     
    procedure InsertFileInMemo(Memo: TMemo; FileName: string;
      ReplaceSel: Boolean);
    var
      Stream: TMemoryStream;
      NullTerminator: Char;
    begin
      Stream := TMemoryStream.Create;
      try
        { Загружаем текст... }
        Stream.LoadFromFile(FileName);
     
        { Добавляем в конец текста терминирующий ноль... }
        Stream.Seek(0, 2);
        NullTerminator := #0;
        Stream.Write(NullTerminator, 1);
     
        { Вставляем текст в Memo... }
        if not ReplaceSel then
          Memo.SelLength := 0;
        SendMessage(Memo.Handle, EM_ReplaceSel, 0,
          LongInt(Stream.Memory));
      finally
        Stream.Free;
      end;
    end;

------------------------------------------------------------------------

Вариант 3:

Source: <https://www.swissdelphicenter.ch>

    procedure TForm1.Button1Click(Sender: TObject);
     var
       sl: TStringList;
     begin
       sl := TStringList.Create;
       try
         sl.LoadFromFile('c:\afile.txt');
         Memo1.SetSelTextBuf(PChar(sl.Text));
       finally
         sl.Free;
       end;
     end;

