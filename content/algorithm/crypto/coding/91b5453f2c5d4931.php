<h1>Кодирование с помощью решетки</h1>
<div class="date">01.01.2007</div>

Автор: ___Nikolay</p>
<pre class="delphi">
unit uMain;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  Grids, StdCtrls, Gauges, ExtCtrls;
 
type
  TfmMain = class(TForm)
    sgGrid: TStringGrid;
    Label1: TLabel;
    sgText: TStringGrid;
    Label2: TLabel;
    Label3: TLabel;
    edNormal: TEdit;
    Label4: TLabel;
    edEncoded: TEdit;
    btEncode: TButton;
    btDecode: TButton;
    chAnimation: TCheckBox;
    Timer1: TTimer;
    procedure btEncodeClick(Sender: TObject);
    procedure btDecodeClick(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
  private
    { Private declarations }
    procedure SetGrid(iState: integer); // Выставить решетку
    function EncodeStr(s: string): string; // Шифрование строки
    function DecodeStr(s: string): string; // Расшифрование строки
  public
    { Public declarations }
  end;
 
var
  fmMain: TfmMain;
 
implementation
 
{$R *.DFM}
 
{ TfmMain }
 
// Выставить решетку
procedure TfmMain.SetGrid(iState: integer);
var
  c, r, iColMin, iColMax, iRowMin, iRowMax: integer;
  x, y, iHalfCell: integer;
  pStart: TPoint;
begin
  Timer1.Enabled := false;
  GetCursorPos(pStart);
  iHalfCell := sgGrid.DefaultColWidth div 2; // Половина ширины ячейки
 
  case iState of
    1: begin
         iColMin := 5;
         iColMax := 9;
         iRowMin := 0;
         iRowMax := 4;
       end;
    2: begin
         iColMin := 5;
         iColMax := 9;
         iRowMin := 5;
         iRowMax := 9;
       end;
    3: begin
         iColMin := 0;
         iColMax := 4;
         iRowMin := 5;
         iRowMax := 9;
       end;
    4: begin
         iColMin := 0;
         iColMax := 4;
         iRowMin := 0;
         iRowMax := 4;
       end;
  end;
 
  for c := 0 to sgGrid.ColCount - 1 do
    for r := 0 to sgGrid.RowCount - 1 do
    begin
      if (c &gt;= iColMin) and (c &lt;= iColMax) and (r &gt;= iRowMin) and (r &lt;= iRowMax) then
        sgGrid.Cells[c, r] := '0'
      else
        sgGrid.Cells[c, r] := '1';
 
      // Визуализировать
      if chAnimation.Checked then
      begin
        Application.ProcessMessages;
        x := fmMain.Left + sgGrid.Left + sgGrid.CellRect(c, r).Left + iHalfCell;
        y := fmMain.Top + sgGrid.Top + sgGrid.CellRect(c, r).Top + iHalfCell + GetSystemMetrics(SM_CYCAPTION);
        SetCursorPos(x, y);
        sgGrid.Repaint;
        Sleep(10);
      end;
    end;
 
  SetCursorPos(pStart.x, pStart.y);
end;
 
procedure TfmMain.btEncodeClick(Sender: TObject);
const
  sMsgLengthCheck = 'Длина текста должна быть равна 100';
var
  s: string;
begin
  s := Trim(edNormal.Text);
 
  if Length(s) &lt;&gt; 100 then
  begin
    MessageDlg(sMsgLengthCheck, mtInformation, [mbOk], 0);
    Exit;
  end;
 
  edEncoded.Text := '';
  edEncoded.Text := EncodeStr(s);
end;
 
// Шифрование строки
function TfmMain.EncodeStr(s: string): string;
label
  start;
var
  c, r, i, iGridState: integer;
  sResult: string;
  x, y, iHalfCell: integer;
  pStart: TPoint;
begin
  Timer1.Enabled := false;
  GetCursorPos(pStart);
  iHalfCell := sgGrid.DefaultColWidth div 2; // Половина ширины ячейки
 
  iGridState := 1;
  SetGrid(iGridState);
  i := 1;
  sResult := '';
 
  start:
  for r := 0 to sgText.RowCount - 1 do
    for c := 0 to sgText.ColCount - 1 do
      if not boolean(StrToInt(sgGrid.Cells[c, r])) then
        if sgText.Cells[c, r] = '' then
        begin
          sgText.Cells[c, r] := s[i];
          inc(i);
 
          // Визуализировать
          if chAnimation.Checked then
          begin
            Application.ProcessMessages;
            x := fmMain.Left + sgText.Left + sgText.CellRect(c, r).Left + iHalfCell;
            y := fmMain.Top + sgText.Top + sgText.CellRect(c, r).Top + iHalfCell + GetSystemMetrics(SM_CYCAPTION);
            SetCursorPos(x, y);
            sgText.Repaint;
            Sleep(10);
          end;
        end;
 
  dec(i);
  if i &lt; 100 then
    if i mod 25 = 0 then
    begin
      inc(iGridState);
      SetGrid(iGridState);
      inc(i);
      goto start;
    end;
 
  // Считываем по строкам
  for r := 0 to sgText.RowCount - 1 do
    for c := 0 to sgText.ColCount - 1 do
    begin
      sResult := sResult + sgText.Cells[c, r];
      sgText.Cells[c, r] := '';
 
      // Визуализировать
      if chAnimation.Checked then
      begin
        Application.ProcessMessages;
        x := fmMain.Left + sgText.Left + sgText.CellRect(c, r).Left + iHalfCell;
        y := fmMain.Top + sgText.Top + sgText.CellRect(c, r).Top + iHalfCell + GetSystemMetrics(SM_CYCAPTION);
        SetCursorPos(x, y);
        sgText.Repaint;
        Sleep(10);
      end;
    end;
  Result := sResult;
 
  SetCursorPos(pStart.x, pStart.y);
end;
 
procedure TfmMain.btDecodeClick(Sender: TObject);
const
  sMsgLengthCheck = 'Длина текста должна быть равна 100';
var
  s: string;
begin
  s := Trim(edEncoded.Text);
 
  if Length(s) &lt;&gt; 100 then
  begin
    MessageDlg(sMsgLengthCheck, mtInformation, [mbOk], 0);
    Exit;
  end;
 
  edNormal.Text := '';
  edNormal.Text := DecodeStr(s);
end;
 
// Расшифрование строки
function TfmMain.DecodeStr(s: string): string;
label
  start;
var
  c, r, i, iGridState: integer;
  sResult: string;
  x, y, iHalfCell: integer;
  pStart: TPoint;
begin
  Timer1.Enabled := false;
  GetCursorPos(pStart);
  iHalfCell := sgGrid.DefaultColWidth div 2; // Половина ширины ячейки
 
  iGridState := 1;
  SetGrid(iGridState);
  i := 1;
  sResult := '';
 
  // Заносим по строкам
  for r := 0 to sgText.RowCount - 1 do
    for c := 0 to sgText.ColCount - 1 do
    begin
      sgText.Cells[c, r] := s[i];
      inc(i);
 
      // Визуализировать
      if chAnimation.Checked then
      begin
        Application.ProcessMessages;
        x := fmMain.Left + sgText.Left + sgText.CellRect(c, r).Left + iHalfCell;
        y := fmMain.Top + sgText.Top + sgText.CellRect(c, r).Top + iHalfCell + GetSystemMetrics(SM_CYCAPTION);
        SetCursorPos(x, y);
        sgText.Repaint;
        Sleep(10);
      end;
    end;
 
  i := 1;
  start:
  for r := 0 to sgText.RowCount - 1 do
    for c := 0 to sgText.ColCount - 1 do
      if not boolean(StrToInt(sgGrid.Cells[c, r])) then
      begin
        sResult := sResult + sgText.Cells[c, r];
        sgText.Cells[c, r] := '';
        inc(i);
 
        // Визуализировать
        if chAnimation.Checked then
        begin
          Application.ProcessMessages;
          x := fmMain.Left + sgText.Left + sgText.CellRect(c, r).Left + iHalfCell;
          y := fmMain.Top + sgText.Top + sgText.CellRect(c, r).Top + iHalfCell + GetSystemMetrics(SM_CYCAPTION);
          SetCursorPos(x, y);
          sgText.Repaint;
          Sleep(10);
        end;
      end;
 
    dec(i);
  if i &lt; 100 then
    if i mod 25 = 0 then
    begin
      inc(iGridState);
      SetGrid(iGridState);
      inc(i);
      goto start;
    end;
 
  Result := sResult;
 
  SetCursorPos(pStart.x, pStart.y);
end;
 
procedure TfmMain.FormCreate(Sender: TObject);
begin
  Timer1.Enabled := true;
end;
 
procedure TfmMain.Timer1Timer(Sender: TObject);
begin
  SetGrid(1);
end;
 
end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

