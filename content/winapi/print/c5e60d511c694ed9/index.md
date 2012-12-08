---
Title: Перехватывать печать на принтере
Author: Rouse\_
Date: 01.01.2007
---

Перехватывать печать на принтере
================================

::: {.date}
01.01.2007
:::

    unit Unit1;
     

     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, WinSpool;
     
    type
      TForm1 = class(TForm)
        btnStart: TButton;
        cbPrinters: TComboBox;
        procedure btnStartClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      PrintersInfo: array of TPrinterInfo5;
      I, Needed, Returned: DWORD;
    begin
      EnumPrinters(PRINTER_ENUM_LOCAL, nil, 5, nil,
        0, Needed, Returned);
      SetLength(PrintersInfo, Needed div SizeOf(TPrinterInfo5));
      if EnumPrinters(PRINTER_ENUM_LOCAL, nil, 5, PrintersInfo,
        Needed, Needed, Returned) then
        if Returned > 0 then
        begin
          for I := 0 to Returned - 1 do
            cbPrinters.Items.Add(PrintersInfo[I].pPrinterName);
          btnStart.Enabled := True;
          cbPrinters.ItemIndex := 1;
        end;
    end;
     
    procedure TForm1.btnStartClick(Sender: TObject);
    var
      hPrinter, hChanges: THandle;
      NotifyOption: TPrinterNotifyOptions;
      NotifyTipes: TPrinterNotifyOptionsType;
      Field: TPrinterNotifyInfoData;
    begin
      if OpenPrinter(PChar(cbPrinters.Items.Strings[cbPrinters.ItemIndex]),
        hPrinter, nil) then
      try
     
        NotifyTipes.wType := JOB_NOTIFY_TYPE;
        NotifyTipes.Reserved0 := 0;
        NotifyTipes.Reserved1 := 0;
        NotifyTipes.Reserved2 := 0;
        NotifyTipes.Count := 1;
        NotifyTipes.pFields := @Field;
     
        NotifyOption.Version := 2;
        NotifyOption.Flags := PRINTER_CHANGE_ALL;
        NotifyOption.Count := 1;
        NotifyOption.pTypes := @NotifyTipes;
     
        hChanges := FindFirstPrinterChangeNotification(hPrinter, PRINTER_CHANGE_ALL,
          0, @NotifyOption);
        if hChanges = INVALID_HANDLE_VALUE then
          RaiseLastOSError
        else
        try
          case WaitForSingleObject(hChanges, INFINITE) of
            WAIT_OBJECT_0: ShowMessage('Есть изменения');
            WAIT_FAILED: RaiseLastOSError;
          end;
        finally
          FindClosePrinterChangeNotification(hChanges);
        end;
      finally
        ClosePrinter(hPrinter);
      end;
    end;
     
    end.

Взято из <https://forum.sources.ru>

Автор: Rouse\_
