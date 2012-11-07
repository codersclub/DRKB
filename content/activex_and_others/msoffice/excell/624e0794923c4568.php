<h1>Создаем Excel файл без OLE</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
const 
  CXlsBof: array[0..5] of Word = ($809, 8, 00, $10, 0, 0); 
  CXlsEof: array[0..1] of Word = ($0A, 00); 
  CXlsLabel: array[0..5] of Word = ($204, 0, 0, 0, 0, 0); 
  CXlsNumber: array[0..4] of Word = ($203, 14, 0, 0, 0); 
  CXlsRk: array[0..4] of Word = ($27E, 10, 0, 0, 0); 
 
procedure XlsBeginStream(XlsStream: TStream; const BuildNumber: Word); 
begin 
  CXlsBof[4] := BuildNumber; 
  XlsStream.WriteBuffer(CXlsBof, SizeOf(CXlsBof)); 
end; 
 
procedure XlsEndStream(XlsStream: TStream); 
begin 
  XlsStream.WriteBuffer(CXlsEof, SizeOf(CXlsEof)); 
end; 
 
procedure XlsWriteCellRk(XlsStream: TStream; const ACol, ARow: Word; 
  const AValue: Integer); 
var 
  V: Integer; 
begin 
  CXlsRk[2] := ARow; 
  CXlsRk[3] := ACol; 
  XlsStream.WriteBuffer(CXlsRk, SizeOf(CXlsRk)); 
  V := (AValue shl 2) or 2; 
  XlsStream.WriteBuffer(V, 4); 
end; 
 
procedure XlsWriteCellNumber(XlsStream: TStream; const ACol, ARow: Word; 
  const AValue: Double); 
begin 
  CXlsNumber[2] := ARow; 
  CXlsNumber[3] := ACol; 
  XlsStream.WriteBuffer(CXlsNumber, SizeOf(CXlsNumber)); 
  XlsStream.WriteBuffer(AValue, 8); 
end; 
 
procedure XlsWriteCellLabel(XlsStream: TStream; const ACol, ARow: Word; 
  const AValue: string); 
var 
  L: Word; 
begin 
  L := Length(AValue); 
  CXlsLabel[1] := 8 + L; 
  CXlsLabel[2] := ARow; 
  CXlsLabel[3] := ACol; 
  CXlsLabel[5] := L; 
  XlsStream.WriteBuffer(CXlsLabel, SizeOf(CXlsLabel)); 
  XlsStream.WriteBuffer(Pointer(AValue)^, L); 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  FStream: TFileStream; 
  I, J: Integer; 
begin 
  FStream := TFileStream.Create('c:\e.xls', fmCreate); 
  try 
    XlsBeginStream(FStream, 0); 
    for I := 0 to 99 do 
      for J := 0 to 99 do 
      begin 
        XlsWriteCellNumber(FStream, I, J, 34.34); 
        // XlsWriteCellRk(FStream, I, J, 3434); 
        // XlsWriteCellLabel(FStream, I, J, Format('Cell: %d,%d', [I, J])); 
      end; 
    XlsEndStream(FStream); 
  finally 
    FStream.Free; 
  end; 
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
