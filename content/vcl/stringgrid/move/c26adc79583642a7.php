<h1>Перетаскиваем колонки и строки в TStringGrid мышью</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  The user can move rows and columns of a StringGrid with the mouse. 
  Can it also be done by code? 
  In the help for TCustomGrid you can see the methods MoveColumn and MoveRow, 
  but they are hidden in TStringGrid. 
  We can make them accessible again by subclassing TStringGrid and 
  declaring these methods as public: 
} 
 
type 
  TStringGridHack = class(TStringGrid) 
  public 
    procedure MoveColumn(FromIndex, ToIndex: Longint); 
    procedure MoveRow(FromIndex, ToIndex: Longint); 
  end; 
 
{ 
  The implementation of these methods simply consists of invoking the 
  corresponding method of the ancestor: 
} 
 
procedure TStringGridHack.MoveColumn(FromIndex, ToIndex: Integer); 
begin 
  inherited; 
end; 
 
procedure TStringGridHack.MoveRow(FromIndex, ToIndex: Integer); 
begin 
  inherited; 
end; 
 
 
// Example, Beispiel: 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  TStringGridHack(StringGrid1).MoveColumn(1, 3); 
end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
