---
Title: OLE и Interbase - прочесть и записать
Author: Rob Minte
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


OLE и Interbase - прочесть и записать
======================================

    procedure TForm1.ReadOLE;
    var
      BS:    TBlobStream;
    begin
      BS := TBlobStream.Create(Table1BLOBFIELD_BLOB, bmRead);
      OLEContainer1.LoadFromStream(BS);
      BS.Free;
    end;
     
    procedure TForm1.WriteOLE;
    var
      BS:    TBlobStream;
    begin
      BS := TBlobStream.Create(Table1BLOBFIELD_BLOB, bmWrite);
      OLEContainer1.SaveToStream(BS);
      BS.Free;
    end;

