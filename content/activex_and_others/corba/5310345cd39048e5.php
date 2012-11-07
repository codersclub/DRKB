<h1>CORBA клиент &ndash; Java Server</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
unit uDelphiClient;
 
interface
 
uses
  Windows, Messages, SysUtils, CorbInit, CorbaObj, orbpas, Classes, Graphics,
    Controls, Forms, Dialogs,
  StdCtrls;
 
type
 
  ISimpleText = interface
    ['{49F25940-3C3C-11D3-9703-0000861F6726}']
    function SetText(const txt: string): string;
  end;
 
  TSimpleTextStub = class(TCorbaStub, ISimpleText)
  public
    function SetText(const txt: string): string;
  end;
 
  TForm1 = class(TForm)
    edtDelphiText: TEdit;
    btnDelphiTextLate: TButton;
    btnDelphiTextEarlyClick: TButton;
    edtResult: TEdit;
    procedure btnDelphiTextLateClick(Sender: TObject);
    procedure btnDelphiTextEarlyClickClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.btnDelphiTextLateClick(Sender: TObject);
var
  JavaServer: TAny;
begin
  JavaServer := ORB.Bind('IDL:CorbaServer/SimpleText:1.0');
  edtResult.Text := JavaServer.setText(edtDelphiText.text);
end;
 
{ TSimpleTextStub }
 
function TSimpleTextStub.SetText(const txt: string): string;
var
  InBuf: IMarshalInBuffer;
  OutBuf: IMarshalOutBuffer;
begin
  FStub.CreateRequest('setText', True, OutBuf);
  OutBuf.PutText(pchar(txt));
  FStub.Invoke(OutBuf, InBuf);
  Result := UnmarshalText(InBuf);
end;
 
procedure TForm1.btnDelphiTextEarlyClickClick(Sender: TObject);
var
  JavaServer: ISimpleText;
begin
  JavaServer := CorbaBind(ISimpleText) as ISimpleText;
  edtResult.Text := JavaServer.SetText(edtDelphiText.text);
end;
 
initialization
  CorbaStubManager.RegisterStub(ISimpleText, TSimpleTextStub);
  CorbaInterfaceIDManager.RegisterInterface(ISimpleText,
    'IDL:CorbaServer/SimpleText:1.0');
 
end.
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
