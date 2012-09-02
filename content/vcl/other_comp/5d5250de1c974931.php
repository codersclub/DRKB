<h1>Загрузка файлов в THTMLViewer и TFrameBrowser</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 

 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, Readhtml, FramView, FramBrwz, HtmlView;
 
type
  TForm1 = class(TForm)
    FrameBrowser1: TFrameBrowser;
    procedure FormCreate(Sender: TObject);
    procedure FrameBrowser1GetPostRequest(Sender: TObject; IsGet: Boolean;
      const URL, Query: String; Reload: Boolean; var NewURL: String;
      var DocType: ThtmlFileType; var Stream: TMemoryStream);
    procedure FrameBrowser1ImageRequest(Sender: TObject; const SRC: String;
      var Stream: TMemoryStream);
  public
    BaseDir: string;
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  BaseDir := 'F:\Download\';
  FrameBrowser1.LoadURL('file://F:\Download\index.htm');
end;
 
procedure TForm1.FrameBrowser1GetPostRequest(Sender: TObject;
  IsGet: Boolean; const URL, Query: String; Reload: Boolean;
  var NewURL: String; var DocType: ThtmlFileType;
  var Stream: TMemoryStream);
var
  S, sType: string;
  F: TFileStream;
  P: Integer;
begin
  S := StringReplace(URL, '|', ':', [rfReplaceAll]);
 
  P := Pos(':', S) + 2;
  sType := Copy(S, 1, P);
 
  Stream := TMemoryStream.Create;
 
  if AnsiLowerCase(sType) = 'file://' then
  begin
    S := StringReplace(Copy(S, P + 1, MaxInt), '/', '\', [rfReplaceAll]);
 
    F := TFileStream.Create(S, fmOpenRead);
    try
      Stream.CopyFrom(F, F.Size);
    finally
      F.Free;
    end;
  end;
end;
 
procedure TForm1.FrameBrowser1ImageRequest(Sender: TObject;
  const SRC: String; var Stream: TMemoryStream);
begin
{}
end;
 
end.
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p class="author">Автор: Smike</p>
