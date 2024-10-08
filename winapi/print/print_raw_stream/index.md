---
Title: Как мне отправить на принтер чистый поток данных?
Author: Акжан Абдулин
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---

Как мне отправить на принтер чистый поток данных?
=================================================

Под Win16 Вы можете использовать функцию SpoolFile, или
Passthrough escape, если принтер поддерживает последнее.

Под Win32 Вы можете использовать WritePrinter.

Ниже пример открытия принтера и записи чистого потока данных в принтер.

Учтите, что Вы должны передать корректное имя принтера, такое,
как "HP LaserJet 5MP", чтобы функция сработала успешно.

Конечно, Вы можете включать в поток данных любые необходимые управляющие
коды, которые могут потребоваться.

    uses WinSpool;
     
    procedure WriteRawStringToPrinter(PrinterName:String; S:String);
    var
      Handle: THandle;
      N: DWORD;
      DocInfo1: TDocInfo1;
    begin
      if not OpenPrinter(PChar(PrinterName), Handle, nil) then
      begin
        ShowMessage('error ' + IntToStr(GetLastError));
        Exit;
      end;
      with DocInfo1 do begin
        pDocName := PChar('test doc');
        pOutputFile := nil;
        pDataType := 'RAW';
      end;
      StartDocPrinter(Handle, 1, @DocInfo1);
     
      StartPagePrinter(Handle);
      WritePrinter(Handle, PChar(S), Length(S), N);
      EndPagePrinter(Handle);
      EndDocPrinter(Handle);
      ClosePrinter(Handle);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      WriteRawStringToPrinter('HP', 'Test This');
    end;

(Borland FAQ N714, переведен Акжаном Абдулиным)

