---
Title: Как послать файл на принтер?
Date: 01.01.2007
---

Как послать файл на принтер?
============================

    uses winspool;
    Const
      GenericPrinter: Pchar = 'Universal/Nur Text';
      // Change to systems generic drivers name, it's localized
    Procedure PrintLineToGeneric(Const line: string );
    Var
      BytesWritten: DWORD;
      hPrinter: THandle;
      DocInfo: TDocInfo1;
    Begin
      If not WinSpool.OpenPrinter(GenericPrinter, hPrinter, nil) Then
        raise exception.create('Printer not found');
      Try
        DocInfo.pDocName := 'MyDocument';
        DocInfo.pOutputFile := Nil;
        DocInfo.pDatatype := 'RAW';
        If StartDocPrinter(hPrinter, 1, @DocInfo) = 0 Then
          Abort;
        Try
          If not StartPagePrinter(hPrinter) Then
            Abort;
          try
            If not WritePrinter(hPrinter, @line[1], Length(line), BytesWritten)
            Then
              Abort;
          Finally
            EndPagePrinter(hPrinter);
          End;
        Finally
          EndDocPrinter(hPrinter);
        End;
      Finally
        WinSpool.ClosePrinter(hPrinter);
      End;
    End;
