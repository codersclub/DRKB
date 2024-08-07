---
Title: Загрузка нескольких RTF-файлов в TRichEdit
Author: McAndrews
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Загрузка нескольких RTF-файлов в TRichEdit
==========================================

    //Кидаем на форму RichEdit1, Button1, OpenDialog1
    //и по клику кнопки создаём следующую процедуру:
    procedure TForm1.Button1Click(Sender: TObject);
    var
      i, nFiles: integer;
      FileNames, UnitedText, Separator, Tmp: string;
      TextStream: TStringStream;
    begin
      TextStream := TStringStream.Create('');
      Separator := '\par \par \par '; // это разеделитель между выводимыми
      // файлами, в данном случае - 3 параграфа
      UnitedText := '';
     
      OpenDialog1.Options := OpenDialog1.Options
        // что бы можно было выбрать несколько
        + [ofAllowMultiSelect]; // файлов
     
      RichEdit1.MaxLength := $7FFFFFF0; // предусмотрительно увеличиваем максимальный
      // объём загружаемых данных в RichEdit1
     
      try // а вдруг что..
     
        if OpenDialog1.Execute then
        begin
          nFiles := OpenDialog1.Files.count - 1;
          for i := 0 to nFiles do
          begin
     
            FileNames := OpenDialog1.Files.Strings[i];
            RichEdit1.Lines.LoadFromFile(FileNames);
            // открываем каждый файл поочереди
            // в RichEdit1
            RichEdit1.Lines.SaveToStream(TextStream);
            // и записываем данные уже от туда в
            // поток TextStream,
            Tmp := TextStream.DataString; // а из потока во временную
            // переменную Tmp типа String,
     
            TextStream.Position := 0; // ставим указатель в потоке на 0,
     
            if i = 0 then // проверяем - является ли данный
              Tmp := copy(Tmp, 0, length(Tmp) - 5) // файл первый, последним, или
            else if i = nFiles then // или между ними, в зависимости
              Tmp := Separator + copy(Tmp, 2, length(Tmp))
                // от этого удаляем управляющие
            else // символы начала или окончания
              Tmp := Separator + copy(Tmp, 2, length(Tmp) - 5);
                //  RTF-файла и всталяем разделитель.
            // дело в том, что каждый RTF-файл
            // начинаетcz c символа '{' и заканчивается '}'.
            UnitedText := UnitedText + Tmp; // записываем всё в переменную UnitedText
          end;
     
          TextStream.WriteString(UnitedText);
          // помещаем уже объеденённый текст в поток
     
          TextStream.Position := 0; // ставим указатель на 0
          RichEdit1.Lines.LoadFromStream(TextStream);
          // и записываем потом в RichEdit1
        end;
      finally
        TextStream.Free;
      end;
    end;


