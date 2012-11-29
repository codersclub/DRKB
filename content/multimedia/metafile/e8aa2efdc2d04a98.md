Как получить доступ к объекту метафайла?
========================================

::: {.date}
01.01.2007
:::

Below is an example of getting metafile information and enumerating each
metafile record :

    function MyEnhMetaFileProc(DC: HDC; {handle to device context}
      lpHTable: PHANDLETABLE; {pointer to metafile handle table}
      lpEMFR: PENHMETARECORD; {pointer to metafile record}
      nObj: integer; {count of objects}
      TheForm: TForm1): integer; stdcall;
    begin
      {draw the metafile record}
      PlayEnhMetaFileRecord(dc, lpHTable^, lpEMFR^, nObj);
      {set to zero to stop metafile enumeration}
      result := 1;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      MyMetafile: TMetafile;
      lpENHMETAHEADER: PENHMETAHEADER; {extra metafile info}
      lpENHMETAHEADERSIZE: DWORD;
      NumMetaRecords: DWORD;
    begin
      {Create a metafile}
      MyMetafile := TMetafile.Create;
      with TMetafileCanvas.Create(MyMetafile, 0) do
      try
        Brush.Color := clRed;
        Ellipse(0, 0, 100, 100);
        Ellipse(100, 100, 200, 200);
        Ellipse(200, 200, 300, 300);
        Ellipse(300, 300, 400, 400);
        Ellipse(400, 400, 500, 500);
        Ellipse(500, 500, 600, 600);
      finally
        Free;
      end;
      {we might as well get some extra metafile info}
      lpENHMETAHEADERSIZE := GetEnhMetaFileHeader(MyMetafile.Handle, 0, nil);
      NumMetaRecords := 0;
      if (lpENHMETAHEADERSIZE > 0) then
      begin
        GetMem(lpENHMETAHEADER, lpENHMETAHEADERSIZE);
        GetEnhMetaFileHeader(MyMetafile.Handle, lpENHMETAHEADERSIZE, lpENHMETAHEADER);
        {Here is an example of getting number of metafile records}
        NumMetaRecords := lpENHMETAHEADER^.nRecords;
        {enumerate the records}
        EnumEnhMetaFile(Canvas.Handle, MyMetafile.Handle, @MyEnhMetaFileProc, self,
          Rect(0, 0, 600, 600));
        FreeMem(lpENHMETAHEADER, lpENHMETAHEADERSIZE);
      end;
      MyMetafile.Free;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
