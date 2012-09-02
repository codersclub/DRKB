<h1>Конвертировать результат запроса в XML и обратно</h1>
<div class="date">01.01.2007</div>


<pre>
unit ADOXMLUnit;
 
interface
 
uses
  Classes, ADOInt;
 
function RecordsetToXML(const Recordset: _Recordset): string;
function RecordsetFromXML(const XML: string): _Recordset;
 
implementation
 
uses
  ComObj;
 
function RecordsetToXML(const Recordset: _Recordset): string;
var
  RS: Variant;
  Stream: TStringStream;
begin
  Result := '';
  if Recordset = nil then
    Exit;
  Stream := TStringStream.Create('');
  try
    RS := CreateOleObject('ADODB.Recordset');
    RS := Recordset;
    RS.Save(TStreamAdapter.Create(stream) as IUnknown, adPersistXML);
    Stream.Position := 0;
    Result := Stream.DataString;
  finally
    Stream.Free;
  end;
end;
 
function RecordsetFromXML(const XML: string): _Recordset;
var
  RS: Variant;
  Stream: TStringStream;
begin
  Result := nil;
  if XML = '' then
    Exit;
  try
    Stream := TStringStream.Create(XML);
    Stream.Position := 0;
    RS := CreateOleObject('ADODB.Recordset');
    RS.Open(TStreamAdapter.Create(Stream) as IUnknown);
    Result := IUnknown(RS) as _Recordset;
  finally
    Stream.Free;
  end;
end;
 
end.
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
