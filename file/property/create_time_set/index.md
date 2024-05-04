---
Title: Устанавливаем дату создания файла
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Устанавливаем дату создания файла
=================================

Вариант 1:

    function SetFileDate(
      Const FileName : String;
      Const FileDate : TDateTime): Boolean;
    var
     FileHandle        : THandle;
     FileSetDateResult : Integer;
    begin
     try
      try
       FileHandle := FileOpen
          (FileName,
           fmOpenWrite OR fmShareDenyNone);
       if FileHandle > 0 Then  begin
        FileSetDateResult :=
          FileSetDate(
            FileHandle,
            DateTimeToFileDate(FileDate));
          result := (FileSetDateResult = 0);
        end;
      except
       Result := False;
      end;
     finally
      FileClose (FileHandle);
     end;
    end;
     
    {Использование:}
    SetFileDate('c:\mydir\myfile.ext', Now)
     

------------------------------------------------------------------------

Вариант 2:

    var
      f: file;
    begin
      Assign(f, DirInfo.Name);
      Reset(f);
      SetFTime(f, Time);
      Close(f);
    end;


------------------------------------------------------------------------

Вариант 3:

Функция, которая устанавливает дату одного файла, равную дате другого
файла

    procedure CopyFileDate(const Source, Dest: String);
    var
      SourceHand, DestHand: word;
    begin
      SourceHand := FileOpen(Source, fmOutput);       { открываем исходный файл }
      DestHand := FileOpen(Dest, fmInput);            { открываем целевой файл }
      FileSetDate(DestHand, FileGetDate(SourceHand)); { получаем/устанавливаем дату }
      FileClose(SourceHand);                          { закрываем исходный файл }
      FileClose(DestHand);                            { закрываем целевой файл }
    end; 

