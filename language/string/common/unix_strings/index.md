---
Title: Unix-строки (чтение и запись Unix-файлов)
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---


Unix-строки (чтение и запись Unix-файлов)
=========================================

    unit StreamFile;
     
    interface
     
    uses SysUtils;
     
    procedure AssignStreamFile(var F: Text; Filename: string);
     
    implementation
     
    const
      BufferSize = 128;
     
    type
      TStreamBuffer = array[1..High(Integer)] of Char;
      TStreamBufferPointer = ^TStreamBuffer;
      TStreamFileRecord = record
        case Integer of
          1:
          (
            Filehandle: Integer;
            Buffer: TStreamBufferPointer;
            BufferOffset: Integer;
            ReadCount: Integer;
            );
          2:
          (
            Dummy: array[1..32] of Char
            )
      end;
     
    function StreamFileOpen(var F: TTextRec): Integer;
    var
      Status: Integer;
    begin
      with TStreamFileRecord(F.UserData) do
        begin
          GetMem(Buffer, BufferSize);
          case F.Mode of
            fmInput:
              FileHandle := FileOpen(StrPas(F.Name), fmShareDenyNone);
            fmOutput:
              FileHandle := FileCreate(StrPas(F.Name));
            fmInOut:
              begin
                FileHandle := FileOpen(StrPas(F.Name), fmShareDenyNone or
                  fmOpenWrite or fmOpenRead);
                if FileHandle <> -1 then
                  status := FileSeek(FileHandle, 0, 2); { Перемещаемся в конец файла. }
                F.Mode := fmOutput;
              end;
          end;
          BufferOffset := 0;
          ReadCount := 0;
          F.BufEnd := 0; { В этом месте подразумеваем что мы достигли конца файла (eof). }
          if FileHandle = -1 then
            Result := -1
          else
            Result := 0;
        end;
    end;
     
    function StreamFileInOut(var F: TTextRec): Integer;
     
      procedure Read(var Data: TStreamFileRecord);
        procedure CopyData;
        begin
          while (F.BufEnd < Sizeof(F.Buffer) - 2)
            and (Data.BufferOffset <= Data.ReadCount)
            and (Data.Buffer[Data.BufferOffset] <> #10) do
            begin
              F.Buffer[F.BufEnd] := Data.Buffer^[Data.BufferOffset];
              Inc(Data.BufferOffset);
              Inc(F.BufEnd);
            end;
          if Data.Buffer[Data.BufferOffset] = #10 then
            begin
              F.Buffer[F.BufEnd] := #13;
              Inc(F.BufEnd);
              F.Buffer[F.BufEnd] := #10;
              Inc(F.BufEnd);
              Inc(Data.BufferOffset);
            end;
        end;
     
      begin
        F.BufEnd := 0;
        F.BufPos := 0;
        F.Buffer := '';
        repeat
          begin
            if (Data.ReadCount = 0) or (Data.BufferOffset > Data.ReadCount) then
              begin
                Data.BufferOffset := 1;
                Data.ReadCount := FileRead(Data.FileHandle, Data.Buffer^, BufferSize);
              end;
            CopyData;
        end until (Data.ReadCount = 0)
        or (F.BufEnd >= Sizeof(F.Buffer) - 2);
        Result := 0;
      end;
     
      procedure Write(var Data: TStreamFileRecord);
      var
        Status: Integer;
        Destination: Integer;
        II: Integer;
      begin
        with TStreamFileRecord(F.UserData) do
          begin
            Destination := 0;
            for II := 0 to F.BufPos - 1 do
              begin
                if F.Buffer[II] <> #13 then
                  begin
                    Inc(Destination);
                    Buffer^[Destination] := F.Buffer[II];
                  end;
              end;
            Status := FileWrite(FileHandle, Buffer^, Destination);
            F.BufPos := 0;
            Result := 0;
          end;
      end;
    begin
      case F.Mode of
        fmInput:
          Read(TStreamFileRecord(F.UserData));
        fmOutput:
          Write(TStreamFileRecord(F.UserData));
      end;
    end;
     
    function StreamFileFlush(var F: TTextRec): Integer;
    begin
      Result := 0;
    end;
     
    function StreamFileClose(var F: TTextRec): Integer;
    begin
      with TStreamFileRecord(F.UserData) do
        begin
          FreeMem(Buffer);
          FileClose(FileHandle);
        end;
      Result := 0;
    end;
     
    procedure AssignStreamFile(var F: Text; Filename: string);
    begin
      with TTextRec(F) do
        begin
          Mode := fmClosed;
          BufPtr := @Buffer;
          BufSize := Sizeof(Buffer);
          OpenFunc := @StreamFileOpen;
          InOutFunc := @StreamFileInOut;
          FlushFunc := @StreamFileFlush;
          CloseFunc := @StreamFileClose;
          StrPLCopy(Name, FileName, Sizeof(Name) - 1);
        end;
    end;
    
    end.

