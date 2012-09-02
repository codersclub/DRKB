<h1>Как прочитать заголовок wav файла?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TWaveHeader = record
    ident1: array[0..3] of Char;      // Must be "RIFF"
    len: DWORD;                       // Remaining length after this header
    ident2: array[0..3] of Char;      // Must be "WAVE"
    ident3: array[0..3] of Char;      // Must be "fmt "
    reserv: DWORD;                    // Reserved 4 bytes
    wFormatTag: Word;                 // format type
    nChannels: Word;                  // number of channels (i.e. mono, stereo, etc.)
    nSamplesPerSec: DWORD;            //sample rate
    nAvgBytesPerSec: DWORD;           //for buffer estimation
    nBlockAlign: Word;                //block size of data
    wBitsPerSample: Word;             //number of bits per sample of mono data
    cbSize: Word;                     //the count in bytes of the size of
    ident4: array[0..3] of Char;      //Must be "data"
end;
</pre>


<p>With this structure you can get all the information's about a wave file you want to.</p>
<p>After this header following the wave data which contains the data for playing the wave file.</p>

<p>Now we trying to get the information's from a wave file. To be sure it's really a wave file, we test the information's:</p>

<pre>
function GetWaveHeader(FileName: TFilename): TWaveHeader;
const
  riff = 'RIFF';
  wave = 'WAVE';
var
  f: TFileStream;
  w: TWaveHeader;
begin
  if not FileExists(Filename) then
    exit; //exit the function if the file does not exists
 
  try
    f := TFileStream.create(Filename, fmOpenRead);
    f.Read(w, Sizeof(w)); //Reading the file header
 
    if w.ident1 &lt;&gt; riff then
    begin //Test if it is a RIFF file, otherwise exit
      Showmessage('This is not a RIFF File');
      exit;
    end;
 
    if w.ident2 &lt;&gt; wave then
    begin //Test if it is a wave file, otherwise exit
      Showmessage('This is not a valid wave file');
      exit;
    end;
 
  finally
    f.free;
  end;
 
  Result := w;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
