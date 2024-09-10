---
Title: Как прервать печать и заставить печатать свой файл?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---

Как прервать печать и заставить печатать свой файл?
===================================================

    uses
      printers;
     
    {$R *.DFM}
     
    procedure StartPrintToFile(filename: string);
    var
      CTitle: array[0..31] of Char;
      DocInfo: TDocInfo;
    begin
      with Printer do
      begin
        BeginDoc;
        { Abort job just started on API level. }
        EndPage(Canvas.handle);
        Windows.AbortDoc(Canvas.handle);
        { Restart it with a print file as destination. }
        StrPLCopy(CTitle, Title, SizeOf(CTitle) - 1);
        FillChar(DocInfo, SizeOf(DocInfo), 0);
        with DocInfo do
        begin
          cbSize := SizeOf(DocInfo);
          lpszDocName := CTitle;
          lpszOutput := PChar(filename);
        end;
        StartDoc(Canvas.handle, DocInfo);
        StartPage(Canvas.handle);
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      StartPrintToFile('C:\temp\temp.prn');
      try
        Printer.Canvas.TextOut(100, 100, 'Hello World.');
      finally
        Printer.endDoc;
      end;
    end;

