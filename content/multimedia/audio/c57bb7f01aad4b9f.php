<h1>Как определить продолжительность в секундах wav файла?</h1>
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
<hr />
<pre>
function GetWaveLength(WaveFile: string): Double;
var
    groupID: array[0..3] of char;
    riffType: array[0..3] of char;
    BytesPerSec: Integer;
    Stream: TFileStream;
    dataSize: Integer;
  // chunk seeking function,
  // -1 means: chunk not found
 
  function GotoChunk(ID: string): Integer;
  var
      chunkID: array[0..3] of char;
      chunkSize: Integer;
  begin
      Result := -1;
 
    with Stream do
        begin
             // index of first chunk
          Position := 12;
        repeat
             // read next chunk
          Read(chunkID, 4);
          Read(chunkSize, 4);
           if chunkID &lt;&gt; ID then
             // skip chunk
         Position := Position + chunkSize;
          until(chunkID = ID) or (Position &gt;= Size);
          if chunkID = ID then
               // chunk found,
             // return chunk size
            Result := chunkSize;
        end;
  end;
 
begin
    Result := -1;
    Stream := TFileStream.Create(WaveFile, fmOpenRead or fmShareDenyNone);
    with Stream do
        try
          Read(groupID, 4);
        Position := Position + 4; // skip four bytes (file size)
        Read(riffType, 4);
 
        if(groupID = 'RIFF') and (riffType = 'WAVE') then
           begin
              // search for format chunk
           if GotoChunk('fmt') &lt;&gt; -1 then
              begin
                // found it
              Position := Position + 8;
              Read(BytesPerSec, 4);
                 //search for data chunk
                dataSize := GotoChunk('data');
 
                if dataSize &lt;&gt; -1 then
                     // found it
                  Result := dataSize / BytesPerSec
                end
            end
        finally
          Free;
      end;
end;
</pre>

<p>This returns the number of seconds as a floating point number, which is not necessarily the most helpful format. Far better to return it as a string representing the time in hours, minutes and seconds. The following function achieves this based on the number of seconds as an integer:</p>
<pre>
function SecondsToTimeStr(RemainingSeconds: Integer): string;
var
    Hours, Minutes, Seconds: Integer;
    HourString, MinuteString, SecondString: string;
begin
     // Calculate Minutes
    Seconds := RemainingSeconds mod 60;
    Minutes := RemainingSeconds div 60;
    Hours := Minutes div 60;
    Minutes := Minutes - (Hours * 60);
 
    if Hours &lt; 10 then
       HourString := '0' + IntToStr(Hours) + ':'
     else
       HourString := IntToStr(Hours) + ':';
 
    if Minutes &lt; 10 then
        MinuteString := '0' + IntToStr(Minutes) + ':'
      else
        MinuteString := IntToStr(Minutes) + ':';
 
    if Seconds &lt; 10 then
        SecondString := '0' + IntToStr(Seconds)
      else
        SecondString := IntToStr(Seconds);
    Result := HourString + MinuteString + SecondString;
end;
</pre>

<p>Having created these functions you can call them from any relevant event - for example a button click:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
   Seconds: Integer;
begin
    Seconds := Trunc(GetWaveLength(Edit1.Text));
    //gets only the Integer part of the length
    Label1.Caption := SecondsToTimeStr(Seconds);
end;
</pre>

<p>You can even reduce this to a single line of code if you prefer:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
    Label1.Caption := SecondsToTimeStr(Trunc(GetWaveLength(Edit1.Text)));
end;
</pre>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
