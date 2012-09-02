<h1>Сохранить F1Book в Blob поле</h1>
<div class="date">01.01.2007</div>


<pre>
uses vcf1, dbtables;
 
 
procedure SaveSpreadsheet(F1Book: TF1Book);
var
  BlobStream: TBlobStream;
  MyBlob: HGlobal;
  pblob: Pointer;
begin
  with Datamodule1.Query1 do
  begin
    Set8087CW($133f);
    try
      Application.ProcessMessages;
      F1Book.SaveWindowInfo;
      MyBlob := GlobalAlloc(GMEM_MOVEABLE, 2000);
      try
        F1Book.WriteToBlob(MyBlob, 0);
        pBlob := globalLock(MyBlob);
        try
          Blobstream := TBlobStream.Create(TBlobField(FieldByName('QUOTE_BLOB')),
            bmWrite);
          try
            Blobstream.Write(pBlob^, GlobalSize(myBlob));
          finally
            Blobstream.Free;
          end;
        finally
          globalUnlock(MyBlob);
        end;
        F1book.IF1Book_Modified := False;
      finally
        globalFree(myblob);
      end;
    finally
      Set8087CW(Default8087CW);
      Application.ProcessMessages;
    end;
  end;
end;
 
//Depending on your Delphi Version (&lt;D4), you will need:
 
var
  Default8087CW: Word = $1332;
 
procedure Set8087CW(NewCW: Word);
asm
  MOV     Default8087CW,AX
  FLDCW   Default8087CW
end;
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

