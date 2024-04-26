---
Title: Конвертировать результат запроса в XML и обратно
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---

Конвертировать результат запроса в XML и обратно
================================================

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

