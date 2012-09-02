<h1>Как использовать ресурсы?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  To create resource files (*.res) for Kylix you can use the Delphi 
  brcc32.exe resource compiler. 
  Take a look at ;http://www.swissdelphicenter.ch/en/showcode.php?id=1049 
 
 
  Kylix dont support userdefined resourcetypes. Therefore you have to define 
  all resources without a predefined ResType as RCDATA. 
 
  Example with TResourceStream 
  Saves the resource (in userdefined.res) with the name MYRES1 to the file 
  test.txt 
} 
 
uses 
  SysUtils, Types, Classes, Variants, QGraphics, QControls, QForms, QDialogs, 
  QStdCtrls; 
 
type 
  TForm1 = class(TForm) 
    Button1: TButton; 
    procedure Button1Click(Sender: TObject); 
  private 
    { Private-Deklarationen } 
  public 
    { Public-Deklarationen } 
  end; 
 
var 
  Form1: TForm1; 
 
implementation 
 
{$R *.xfm} 
{$R userdefined.res} 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  stream: TResourceStream; 
begin 
  stream := TResourceStream.Create(HInstance, 'MYRES1', RT_RCDATA); 
  with TFileStream.Create('test.txt', fmCreate) do begin 
    CopyFrom(stream, stream.Size); 
    Free; 
  end; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
