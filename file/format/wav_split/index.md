---
Title: Как разрезать wav файл?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как разрезать wav файл?
=======================

    type
      TWaveHeader = record
        ident1: array[0..3] of Char;       // Must be "RIFF"
        len: DWORD;                        // remaining length after this header
        ident2: array[0..3] of Char;       // Must be "WAVE"
        ident3: array[0..3] of Char;       // Must be "fmt "
        reserv: DWORD;                     // Reserved Size
        wFormatTag: Word;                  // format type
        nChannels: Word;                   // number of channels (i.e. mono, stereo, etc.)
        nSamplesPerSec: DWORD;             //sample rate
        nAvgBytesPerSec: DWORD;            //for buffer estimation
        nBlockAlign: Word;                 //block size of data
        wBitsPerSample: Word;              //number of bits per sample of mono data
        cbSize: Word;                      //the count in bytes of the size of
        ident4: array[0..3] of Char;       //Must be "data"
    end;
     

Вы можете загрузить заголовок файла с помощью этой функции:

    function GetWaveHeader(FileName: TFilename): TWaveHeader;
    const
      riff = 'RIFF';
      wave = 'WAVE';
    var
      f: TFileStream;
      w: TWaveHeader;
    begin
      if not FileExists(Filename) then
        exit;
     
      try
        f := TFileStream.create(Filename, fmOpenRead);
        f.Read(w, Sizeof(w));
     
        if w.ident1 <> riff then
        begin
          Showmessage('This is not a RIFF File');
          exit;
        end;
     
        if w.ident2 <> wave then
        begin
          Showmessage('This is not a valid wave file');
          exit;
        end;
     
      finally
        f.free;
      end;
     
      Result := w;
    end;

Теперь у нас есть все для создания кода для разделения wav файла:

    function SplitWave(Source, Dest1, Dest2: TFileName; Pos: Integer): Boolean;
    var
      f1, f2, f3: TfileStream;
      w: TWaveHeader;
      p: Integer;
    begin
      Result:=False
     
      if not FileExists(Source) then
        exit;
     
      try
        w := GetWaveHeader(Source);
     
        p := Pos - Sizeof(TWaveHeader);
     
        f1 := TFileStream.create(Source, fmOpenRead);
        f2 := TFileStream.create(Dest1, fmCreate);
        f3 := TFileStream.create(Dest2, fmCreate);
     
        {++++++++++Create file 1 ++++++++++++++++}
        w.len := p;
        f2.Write(w, Sizeof(w));
        f1.position := Sizeof(w);
        f2.CopyFrom(f1, p);
        {++++++++++++++++++++++++++++++++++++++++}
     
        {+++++++++++Create file 2 +++++++++++++++}
        w.len := f1.size - Pos;
        f3.write(w, Sizeof(w));
        f1.position := Pos;
        f3.CopyFrom(f1, f1.size - pos);
        {++++++++++++++++++++++++++++++++++++++++}
      finally
        f1.free;
        f2.free;
        f3.free;
      end;
     
      Result:=True;
    end;

