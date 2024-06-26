---
Title: Сохранение массива c изображениями
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Сохранение массива c изображениями
==================================

Я решил проблему записи массива TBitmap в файл и его повторного чтения.

Идея заключается в загрузке каждого TBitmap во временный TMemoryStream.
Член TMemoryStream.Size информирует о размере данных, которые нужно
сохранить на диске. Затем мы пишем размер и сопровождаем его данными
типа TFileStream. Эту манипуляцию мы проделываем для каждого TBitmap в
массиве.

Для процедуры чтения сначала мы должны считать из потока размер данных
TBitmap. Затем мы распределяем область для типа TMemoryStream
полученного размера и считываем данные. Затем переписываем из
TFileStream в TMemoryStream. И, наконец, мы читает из TMemoryStream сам
TBitmap. Эту манипуляцию мы проделываем для каждого TBitmap в массиве.

Ниже я привел код, который я реально использовал. Код из игры Bingo,
которую я разрабатываю, имеет сетку 5x5, чьи ячейки содержат
изображение.

Реализация алгоритма весьма медленна, поэтому если вы имеете или найдете
более быстрый алгоритм, пожалуйста, уведомите меня об этом. Если у вас
есть любые вопросы, пожалуйста, свяжитесь со мной.

    procedure TMainForm.SaveBoard;
    var
      MemoryStream: TMemoryStream;
      FileStream: TFileStream;
      Writer: TWriter;
      Buffer: Pointer;
      Size: Longint;
      Column: Integer;
      Row: Integer;
    begin
      MemoryStream := TMemoryStream.Create;
      FileStream := TFileStream.Create(SaveFilename, fmCreate);
      Writer := TWriter.Create(FileStream, $1000);
      try
        for Column := 0 to 4 do
          for Row := 0 to 4 do
          begin
            MemoryStream.Clear;
            Bitmaps[Column, Row].SaveToStream(MemoryStream);
            Buffer := MemoryStream.Memory;
            Size := MemoryStream.Size;
            Writer.WriteInteger(Size);
            Writer.Write(Buffer^, Size);
          end;
      finally
        Writer.Free;
        FileStream.Free;
        MemoryStream.Free;
      end;
    end;
     
    procedure TMainForm.Open1Click(Sender: TObject);
    var
      MemoryStream: TMemoryStream;
      FileStream: TFileStream;
      Buffer: Pointer;
      Reader: TReader;
      Column: Integer;
      Row: Integer;
      Size: Longint;
    begin
      OpenDialog2.Filename := SaveFilename;
      if not OpenDialog2.Execute then
        Exit;
      MemoryStream := TMemoryStream.Create;
      FileStream := TFileStream.Create(OpenDialog2.Filename, fmOpenRead);
      Reader := TReader.Create(FileStream, $1000);
      try
        for Column := 0 to 4 do
          for Row := 0 to 4 do
          begin
            Size := Reader.ReadInteger;
            MemoryStream.SetSize(Size);
            Buffer := MemoryStream.Memory;
            Reader.Read(Buffer^, Size);
            Bitmaps[Column, Row].LoadFromStream(MemoryStream);
          end;
      finally
        Reader.Free;
        FileStream.Free;
        MemoryStream.Free;
      end;
      DrawGrid1.Repaint;
      SaveFilename := OpenDialog2.Filename;
      Caption := 'Bingo-создатель - ' + ExtractFilename(SaveFilename);
    end;

