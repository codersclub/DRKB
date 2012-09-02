<h1>Как получить длину wav в секундах?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  MPlayer, MMsystem;
 
type
  EMyMCIException = class(Exception);
  TWavHeader = record
    Marker1: array[0..3] of Char;
    BytesFollowing: Longint;
    Marker2: array[0..3] of Char;
    Marker3: array[0..3] of Char;
    Fixed1: Longint;
    FormatTag: Word;
    Channels: Word;
    SampleRate: Longint;
    BytesPerSecond: Longint;
    BytesPerSample: Word;
    BitsPerSample: Word;
    Marker4: array[0..3] of Char;
    DataBytes: Longint;
  end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  Header: TWavHeader;
begin
  with TFileStream.Create('C:\SomeFile.wav', fmOpenRead) do
    try
      ReadBuffer(Header, SizeOf(Header));
    finally
      Free;
    end;
  ShowMessage(FloatToStr((Int64(1000) * header.DataBytes div header.BytesPerSecond) / 1000));
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
