---
Title: Информация о файле
Date: 01.01.2007
---


Информация о файле
==================

Привожу пример функции которая собирает довольно большое количество
информации о выбранном файле:

    Type TFileInfo=record
      Exists:boolean;//true если файл найден
      Name:String; //имя файла с расширением
      ShortName:String;//DOS 8.3 имя файла
      NameNoExt:String;//имя файла без расширения
      Extension:string;//расширение файла
      AssociatedFile:string;//программа с которой ассоциирован файл
      Path:string;// путь к файлу
      ShortPath:string;// DOS 8.3 путь файла
      Drive:string;// дисковод на котором находится файл
      CreateDate:TDateTime; //время когда файл создан
      Size:Int64;// размер файла (работает для файлов и больше 2Gb)
      Attributes:record //нали?ие/отсутствие системных атрибутов
        ReadOnly:boolean;
        Hidden:boolean;
        System:boolean;
        Archive:boolean;
      end;
      ModifyDate:TDateTime; // время последнего изменения файла
      LastAccessDate:TDateTime; // дата последнего открытия файла
    end;

    Function ReadFileInfo(FileName:string):TFileInfo;
      var ts:TSearchRec;
     
    Function FileTime2DateTime(FT:_FileTime):TDateTime;
      var FileTime:_SystemTime;
    begin
      FileTimeToLocalFileTime(FT, FT);
      FileTimeToSystemTime(FT,FileTime);
      Result:=EncodeDate(FileTime.wYear, FileTime.wMonth, FileTime.wDay)+
      EncodeTime(FileTime.wHour, FileTime.wMinute, FileTime.wSecond, FileTime.wMilliseconds);
    end;
     
    Function AssociatedFile(FileExt:string):string;
      var key:string;
    begin
      With TRegistry.create do
        try
          RootKey:=HKEY_CLASSES_ROOT;
          OpenKey(FileExt, false);
          Key:=ReadString('');
          CloseKey;
          OpenKey(key+'\Shell\open\command', false);
          result:=ReadString('');
          Closekey;
        finally
          free;
        end
    end;

    begin
      Result.Name:=ExtractFileName(FileName);
      Result.Extension:=ExtractFileExt(FileName);
      Result.NameNoExt:=Copy(Result.Name,1,length(Result.Name)-length(Result.Extension));
      Result.Path:=ExtractFilePath(FileName);
      Result.Drive:=ExtractFileDrive(FileName);
      Result.ShortPath:=ExtractShortPathName(ExtractFilePath(FileName));
      if lowercase(Result.Extension)<>'.exe' then Result.AssociatedFile:=AssociatedFile(Result.Extension);
      if FindFirst(FileName, faAnyFile, ts)=0 then
        begin
          Result.Exists:=true;
          Result.CreateDate:=FileDateToDateTime(ts.Time);
          Result.Size:=ts.FindData.nFileSizeHigh*4294967296+ts.FindData.nFileSizeLow;
          Result.Attributes.ReadOnly:=(faReadOnly and ts.Attr)>0;
          Result.Attributes.Hidden:=(faHidden and ts.Attr)>0;
          Result.Attributes.System:=(faSysFile and ts.Attr)>0;
          Result.Attributes.Archive:=(faArchive and ts.Attr)>0;
          Result.ModifyDate:=FileTime2DateTime(ts.FindData.ftLastWriteTime);
          Result.LastAccessDate:=FileTime2DateTime(ts.FindData.ftLastAccessTime);
          Result.ShortName:=ts.FindData.cAlternateFileName;
          Findclose(ts);
        end
      else 
        Result.Exists:=false;
    end;

Скорее всего эта функция как есть вряд ли понадобится, так как наверняка
бОльшее количество определяемых параметров избыточно, тем не менее может
кому пригодится как пример выяснения информации о файле.
