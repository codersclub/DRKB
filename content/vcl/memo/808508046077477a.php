<h1>Ограничение длины и количества строк компонента TMemo</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  StdCtrls, ExtCtrls, Forms;
 
type
  TForm1 = class(TForm)
    Memo1: TMemo;
    procedure FormCreate(Sender: TObject);
    procedure Memo1KeyPress(Sender: TObject; var Key: Char);
  public
    MaxCharsPerLine, MaxLines: Integer;
    function MemoLine: Integer;
    function LineLen(r: Integer): Integer;
    function NRows: Integer;
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
function TForm1.NRows: Integer;
begin
 
  with Memo1 do
    Result := 1 + SendMessage(Handle, EM_LINEFROMCHAR, GetTextLen - 1, 0);
end;
 
function TForm1.LineLen(r: Integer): Integer;
var
  r1, r2: Integer;
begin
 
  with Memo1 do
  begin
    r1 := SendMessage(Handle, EM_LINEINDEX, r, 0);
    if (r &gt; NRows - 1) then
      r2 := SendMessage(Handle, EM_LINEINDEX, r + 1, 0) - 2 {-CR/LF}
    else
      r2 := GetTextLen;
  end;
  Result := r2 - r1;
end;
 
function TForm1.MemoLine: Integer;
begin
 
  with Memo1 do
    Result := SendMessage(Handle, EM_LINEFROMCHAR, SelStart, 0);
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
 
  MaxCharsPerLine := 8;
  MaxLines := 4;
end;
 
procedure TForm1.Memo1KeyPress(Sender: TObject; var Key: Char);
begin
 
  with Memo1 do
  begin
    case Key of
      ' '..#255: if (LineLen(MemoLine) &gt;= MaxCharsPerLine) then
          Key := #0;
      #10, #13: if (NRows &gt;= MaxLines) then
          Key := #0;
      #8: if (SelStart = SendMessage(Handle, EM_LINEINDEX, MemoLine, 0)) then
          Key := #0;
    end;
  end;
end;
 
end.
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
<hr />
<pre>
procedure TForm1.Memo1Change(Sender: TObject);
 const
   MaxLineCount = 5;
 begin
   if Memo1.Lines.Count &gt; MaxLineCount then
     // undo the last change 
    // letze Дnderung rьckgдngig machen 
    Memo1.Perform(EM_UNDO, 0, 0);
   // The EM_EMPTYUNDOBUFFER message clears the undo flag, 
  // which means that you can no longer undo your last change 
  // to the edit control. 
  // Die Message EM_EMPTYUNDOBUFFER lцscht das UnDo Flag, 
  // damit kann die letzte Дnderung nicht Rьckgдngig gemacht werden. 
  Memo1.Perform(EM_EMPTYUNDOBUFFER, 0, 0);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
