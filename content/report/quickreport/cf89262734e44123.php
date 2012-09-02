<h1>Как сохранить Quick Report в TStream?</h1>
<div class="date">01.01.2007</div>


<pre>
uses QRPrntr; 
 
procedure SaveQuickReportToStream(AQuickReport: TQuickRep; AStream: TStream); 
var 
  PL: TQRPageList; 
  I: Integer; 
begin 
  PL := nil; 
  try 
    PL := TQRPageList.Create; 
    PL.Stream := TQRStream.Create(100000); 
    AQuickReport.Prepare; 
    PL.LockList; 
    try 
      for I := 1 to AQuickReport.QRPrinter.PageCount do 
        PL.AddPage(AQuickReport.QRPrinter.GetPage(I)); 
      PL.Finish; 
    finally 
      PL.UnlockList; 
    end; 
    PL.Stream.SaveToStream(AStream); 
  finally 
    FreeAndNil(PL); 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  stream: TFileStream; 
begin 
  stream := TFileStream.Create('c:\quickreport.dat', fmCreate); 
  QuickReportToStream(QuickRep1, stream); 
  stream.Free; 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
