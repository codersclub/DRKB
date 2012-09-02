<h1>Узнать / установить разрешение JPEG?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure GetResJpg(JPGFile: string);
const
  BufferSize = 50;
var
  Buffer: string;
  Index: integer;
  FileStream: TFileStream;
  HorzRes, VertRes: Word;
  DP: Byte;
  Measure: string;
begin
  FileStream := TFileStream.Create(JPGFile,
    fmOpenReadWrite);
  try
    SetLength(Buffer, BufferSize);
    FileStream.Read(buffer[1], BufferSize);
    Index := Pos('JFIF' + #$00, buffer);
    if Index &gt; 0 then
    begin
      FileStream.Seek(Index + 6, soFromBeginning);
      FileStream.Read(DP, 1);
      case DP of
        1: Measure := 'DPI'; //Dots Per Inch
        2: Measure := 'DPC'; //Dots Per Cm.
      end;
      FileStream.Read(HorzRes, 2); // x axis
      HorzRes := Swap(HorzRes);
      FileStream.Read(VertRes, 2); // y axis
      VertRes := Swap(VertRes);
    end
  finally
    FileStream.Free;
  end;
end;
 
procedure SetResJpg(name: string; dpix, dpiy: Integer);
const
  BufferSize = 50;
  DPI = 1; //inch
  DPC = 2; //cm
var
  Buffer: string;
  index: INTEGER;
  FileStream: TFileStream;
  xResolution: WORD;
  yResolution: WORD;
  _type: Byte;
begin
  FileStream := TFileStream.Create(name,
    fmOpenReadWrite);
  try
    SetLength(Buffer, BufferSize);
    FileStream.Read(buffer[1], BufferSize);
    index := POS('JFIF' + #$00, buffer);
    if index &gt; 0
      then begin
      FileStream.Seek(index + 6, soFromBeginning);
      _type := DPI;
      FileStream.write(_type, 1);
      xresolution := swap(dpix);
      FileStream.write(xresolution, 2);
      yresolution := swap(dpiy);
      FileStream.write(yresolution, 2);
    end
  finally
    FileStream.Free;
  end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
