---
Title: Конвертирование Flash SWF -\> EXE
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Конвертирование Flash SWF -\> EXE
================

    function Swf2Exe(S, D, F: string): string;
      //S = Source file (swf)
      //D = Destionation file (exe)
      //F = Flash Player
    var
      SourceStream, DestinyStream, LinkStream: TFileStream;
      flag: Cardinal;
      SwfFileSize: Integer;
    begin
      Result := 'something error';
      DestinyStream := TFileStream.Create(D, fmCreate);
      try
        LinkStream := TFileStream.Create(F, fmOpenRead or fmShareExclusive);
        try
          DestinyStream.CopyFrom(LinkStream, 0);
        finally
          LinkStream.Free;
        end;
     
        SourceStream := TFileStream.Create(S, fmOpenRead or fmShareExclusive);
        try
          DestinyStream.CopyFrom(SourceStream, 0);
          flag := $FA123456;
          DestinyStream.WriteBuffer(flag, SizeOf(Integer));
          SwfFileSize := SourceStream.Size;
          DestinyStream.WriteBuffer(SwfFileSize, SizeOf(Integer));
          Result := '';
        finally
          SourceStream.Free;
        end;
      finally
        DestinyStream.Free;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Swf2Exe('c:\somefile.swf', 'c:\somefile.exe',
        'c:\Program Files\Macromedia\Flash MX\Players\SAFlashPlayer.exe');
    end;

