<h1>Пример программирования com портов</h1>
<div class="date">01.01.2007</div>


<pre>
unit TestRosh;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls, ExtCtrls;
 
type
  TForm1 = class(TForm)
  Panel1: TPanel;
  Label1: TLabel;
  PortCombo: TComboBox;
  Label2: TLabel;
  BaudCombo: TComboBox;
  Label3: TLabel;
  ByteSizeCombo: TComboBox;
  Label4: TLabel;
  ParityCombo: TComboBox;
  Label5: TLabel;
  StopBitsCombo: TComboBox;
  Label6: TLabel;
  Memo1: TMemo;
  Edit1: TEdit;
  Button1: TButton;
  Memo2: TMemo;
  Edit2: TEdit;
  Label7: TLabel;
  Button2: TButton;
  Label8: TLabel;
  Edit3: TEdit;
  procedure Button1Click(Sender: TObject);
  procedure Memo2Change(Sender: TObject);
  procedure Memo1Change(Sender: TObject);
  procedure FormDestroy(Sender: TObject);
  procedure Button2Click(Sender: TObject);
  procedure PortComboChange(Sender: TObject);
  procedure FormShow(Sender: TObject);
  procedure Memo1DblClick(Sender: TObject);
end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
uses
  Registry;
 
var
  hPort: THandle;
 
procedure TForm1.Memo1Change(Sender: TObject);
var
  i: Integer;
begin
  Edit1.Text := '';
  for i := 1 to Length(Memo1.Text) do
    Edit1.Text := Edit1.Text + Format('%x', [Ord(Memo1.Text[i])]) + ' '
end;
 
procedure TForm1.Memo2Change(Sender: TObject);
var
  i: Integer;
begin
  Edit2.Text := '';
  for i := 1 to Length(Memo2.Text) do
    Edit2.Text := Edit2.Text + Format('%x', [Ord(Memo2.Text[i])]) + ' '
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  S, D: array[0..127] of Char;
  actual_bytes: Integer;
  DCB: TDCB;
begin
 
  FillChar(S, 128, #0);
  FillChar(D, 128, #0);
 
  DCB.DCBlength := SizeOf(DCB);
 
  if not GetCommState(hPort, DCB) then
  begin
    ShowMessage('Can not get port state: ' + IntToStr(GetLastError));
    Exit;
  end;
 
  try
    DCB.BaudRate := StrToInt(BaudCombo.Text);
  except
    BaudCombo.Text := IntToStr(DCB.BaudRate);
  end;
 
  try
    DCB.ByteSize := StrToInt(ByteSizeCombo.Text);
  except
    ByteSizeCombo.Text := IntToStr(DCB.ByteSize);
  end;
 
  if ParityCombo.ItemIndex &gt; -1 then
    DCB.Parity := ParityCombo.ItemIndex
  else
    ParityCombo.ItemIndex := DCB.Parity;
 
  if StopBitsCombo.ItemIndex &gt; -1 then
    DCB.StopBits := StopBitsCombo.ItemIndex
  else
    StopBitsCombo.ItemIndex := DCB.StopBits;
 
  if not SetCommState(hPort, DCB) then
  begin
    ShowMessage('Can not set new port settings: ' + IntToStr(GetLastError));
    Exit;
  end;
 
  PurgeComm(hPort, PURGE_TXABORT or PURGE_RXABORT or PURGE_TXCLEAR or PURGE_RXCLEAR);
 
  StrPCopy(S, Memo1.Text);
 
  if not WriteFile(hPort, S, StrLen(S), actual_bytes, nil) then
  begin
    ShowMessage('Can not write to port: ' + IntToStr(GetLastError));
    Exit;
  end;
 
  if not ReadFile(hPort, D, StrToInt(Edit3.Text), actual_bytes, nil) then
    ShowMessage('Can not read from port: ' + IntToStr(GetLastError))
  else
    ShowMessage('Read ' + IntToStr(actual_bytes) + ' bytes');
  Memo2.Text := D;
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  with TRegistry.Create do
  begin
    OpenKey('Shkila', True);
    WriteString('Port', PortCombo.Text);
    WriteString('Baud Rate', BaudCombo.Text);
    WriteString('Byte Size', ByteSizeCombo.Text);
    WriteString('Parity', IntToStr(ParityCombo.ItemIndex));
    WriteString('Stop Bits', IntToStr(StopBitsCombo.ItemIndex));
    Destroy;
  end;
  if not CloseHandle(hPort) then
  begin
    ShowMessage('Can not close port: ' + IntToStr(GetLastError));
    Exit;
  end;
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  hPort := CreateFile(PChar(PortCombo.Text),
  GENERIC_READ + GENERIC_WRITE,
  0,
  nil,
  OPEN_EXISTING,
  FILE_ATTRIBUTE_NORMAL,
  0);
 
  if hPort = INVALID_HANDLE_VALUE then
    ShowMessage('Can not open ' + PortCombo.Text + ': ' + IntToStr(GetLastError))
  else
    Button2.Hide;
end;
 
procedure TForm1.PortComboChange(Sender: TObject);
begin
  FormDestroy(Sender);
  Button2.Show;
end;
 
procedure TForm1.FormShow(Sender: TObject);
begin
  with TRegistry.Create do
  begin
    OpenKey('Shkila', True);
    PortCombo.Text := ReadString('Port');
    BaudCombo.Text := ReadString('Baud Rate');
    ByteSizeCombo.Text := ReadString('Byte Size');
    ParityCombo.ItemIndex := StrToInt(ReadString('Parity'));
    StopBitsCombo.ItemIndex := StrToInt(ReadString('Stop Bits'));
    Destroy;
  end;
end;
 
procedure TForm1.Memo1DblClick(Sender: TObject);
begin
  Memo1.Lines.Clear;
  Memo2.Lines.Clear;
  Edit1.Text := '';
  Edit2.Text := '';
end;
 
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

