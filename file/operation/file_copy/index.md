---
Title: Копирование файлов
Date: 01.01.2007
Source: <https://dmitry9.nm.ru/info/>
---


Копирование файлов
==================

**Копирование методом Pascal**

    Type
      TCallBack=procedure (Position,Size:Longint); {Для индикации процесса копирования}
     
    procedure FastFileCopy(Const InfileName, OutFileName: String; CallBack: TCallBack);
    Const BufSize = 3*4*4096; { 48Kbytes дает прекрасный результат }
    Type
      PBuffer = ^TBuffer;
      TBuffer = array [1..BufSize] of Byte;
    var
      Size             : integer;
      Buffer           : PBuffer;
      infile, outfile  : File;
      SizeDone,SizeFile: Longint;
    begin
      if (InFileName <> OutFileName) then
      begin
       buffer := Nil;
       AssignFile(infile, InFileName);
       System.Reset(infile, 1);
       try
         SizeFile := FileSize(infile);
         AssignFile(outfile, OutFileName);
         System.Rewrite(outfile, 1);
         try
           SizeDone := 0; New(Buffer);
           repeat
             BlockRead(infile, Buffer^, BufSize, Size);
             Inc(SizeDone, Size);
             CallBack(SizeDone, SizeFile);
             BlockWrite(outfile,Buffer^, Size)
           until Size < BufSize;
           FileSetDate(TFileRec(outfile).Handle,
             FileGetDate(TFileRec(infile).Handle));
         finally
          if Buffer <> Nil then Dispose(Buffer);
          System.close(outfile)
         end;
       finally
         System.close(infile);
       end;
     end else
      Raise EInOutError.Create('File cannot be copied into itself');
    end;

**Копирование методом потока**

    Procedure FileCopy(Const SourceFileName, TargetFileName: String);
    Var
      S,T   : TFileStream;
    Begin
     S := TFileStream.Create(sourcefilename, fmOpenRead );
     try
      T := TFileStream.Create(targetfilename, fmOpenWrite or fmCreate);
      try
        T.CopyFrom(S, S.Size ) ;
        FileSetDate(T.Handle, FileGetDate(S.Handle));
      finally
       T.Free;
      end;
     finally
      S.Free;
     end;
    end;

**Копирование методом LZExpand**

    uses LZExpand;
    procedure CopyFile(FromFileName, ToFileName  : string);
    var
      FromFile, ToFile: File;
    begin
      AssignFile(FromFile, FromFileName);
      AssignFile(ToFile, ToFileName);
      Reset(FromFile);
      try
       Rewrite(ToFile);
       try
        if LZCopy(TFileRec(FromFile).Handle, TFileRec(ToFile).Handle)<0 then
         raise Exception.Create('Error using LZCopy')
       finally
        CloseFile(ToFile);
       end;
      finally
       CloseFile(FromFile);
      end;
    end;

**Копирование методами Windows**

    uses ShellApi; // !!! важно
     
    function WindowsCopyFile(FromFile, ToDir : string) : boolean;
    var F : TShFileOpStruct;
    begin
      F.Wnd := 0; F.wFunc := FO_COPY;
      FromFile:=FromFile+#0; F.pFrom:=pchar(FromFile);
      ToDir:=ToDir+#0; F.pTo:=pchar(ToDir);
      F.fFlags := FOF_ALLOWUNDO or FOF_NOCONFIRMATION;
      result:=ShFileOperation(F) = 0;
    end;
     // пример копирования
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     if not WindowsCopyFile('C:\UTIL\ARJ.EXE', GetCurrentDir) then
       ShowMessage('Copy Failed');
    end;

