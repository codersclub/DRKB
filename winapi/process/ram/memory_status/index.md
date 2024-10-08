---
Title: Как узнать состояние памяти?
Date: 01.01.2007
---

Как узнать состояние памяти?
============================

Вариант 1:

Source: <https://forum.sources.ru>

    var 
      Status : TMemoryStatus; 
    begin 
      Status.dwLength := sizeof( TMemoryStatus ); 
      GlobalMemoryStatus( Status ); 
    ... 

После этого TMemoryStatus будет содержать следующие поля:

- Status.dwMemoryLoad: Количество используемой памяти в процентах (%).
- Status.dwTotalPhys: Общее количество физической памяти в байтах.
- Status.dwAvailPhys: Количество оставшейся физической памяти в байтах.
- Status.dwTotalPageFile: Объём страничного файла в байтах.
- Status.dwAvailPageFile: Свободного места в страничном файле.
- Status.dwTotalVirtual: Общий объём виртуальной памяти в байтах.
- Status.dwAvailVirtual: Количество свободной виртуальной памяти в байтах.

Предварительно, желательно преобразовать эти значения в гига-, мега- или
килобайты, например так:

    label14.Caption := 'Total Ram: '
                     + IntToStr(Status.dwTotalPhys div 1024417)
                     + ' meg';


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    unit MemForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      Grids, ExtCtrls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        StringGrid1: TStringGrid;
        Timer1: TTimer;
        StringGrid2: TStringGrid;
        BtnString: TButton;
        BtnStringList: TButton;
        BtnForm: TButton;
        BtnBigAlloc: TButton;
        BtnSmallAlloc: TButton;
        procedure FormCreate(Sender: TObject);
        procedure Timer1Timer(Sender: TObject);
        procedure BtnStringClick(Sender: TObject);
        procedure BtnStringListClick(Sender: TObject);
        procedure BtnFormClick(Sender: TObject);
        procedure BtnSmallAllocClick(Sender: TObject);
        procedure BtnBigAllocClick(Sender: TObject);
      private
        procedure UpdateStatus;
      public
        s: string;
        sl: TStringList;
        f: TForm;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.UpdateStatus;
    var
      MemStatus: TMemoryStatus;
      HeapStatus: THeapStatus;
    begin
      MemStatus.dwLength := sizeof(TMemoryStatus);
      GlobalMemoryStatus(MemStatus);
      with MemStatus do
      begin
        // load
        StringGrid1.Cells[1, 0] := IntToStr(dwMemoryLoad) + '%';
     
        // RAM (total, free, load)
        StringGrid1.Cells[1, 1] := FloatToStrF(
          dwTotalPhys / 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid1.Cells[1, 2] := FloatToStrF(
          dwAvailPhys / 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid1.Cells[1, 3] := IntToStr(100 -
          dwAvailPhys div (dwTotalPhys div 100)) + '%';
     
        // page file (total, free, load)
        StringGrid1.Cells[1, 4] := FloatToStrF(
          dwTotalPageFile / 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid1.Cells[1, 5] := FloatToStrF(
          dwAvailPageFile / 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid1.Cells[1, 6] := IntToStr(100 -
          dwAvailPageFile div (dwTotalPageFile div 100)) + '%';
     
        // page file (total, used, free)
        StringGrid1.Cells[1, 7] := FloatToStrF(
          dwTotalVirtual / 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid1.Cells[1, 8] := FloatToStrF(
          dwAvailVirtual / 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid1.Cells[1, 9] := FloatToStrF(
          (dwTotalVirtual - dwAvailVirtual) / 1024,
          ffNumber, 20, 0) + ' Kbytes';
      end; // with MemStatus
     
      HeapStatus := GetHeapStatus;
      with HeapStatus do
      begin
        StringGrid2.Cells[1, 0] := FloatToStrF(
          TotalAddrSpace div 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid2.Cells[1, 1] := FloatToStrF(
          TotalUncommitted div 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid2.Cells[1, 2] := FloatToStrF(
          TotalCommitted div 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid2.Cells[1, 3] := FloatToStrF(
          TotalFree div 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid2.Cells[1, 4] := FloatToStrF(
          TotalAllocated div 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid2.Cells[1, 5] := IntToStr(
          TotalAllocated div (TotalAddrSpace div 100)) + '%';
        StringGrid2.Cells[1, 6] := FloatToStrF(
          FreeSmall div 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid2.Cells[1, 7] := FloatToStrF(
          FreeBig div 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid2.Cells[1, 8] := FloatToStrF(
          Unused div 1024,
          ffNumber, 20, 0) + ' Kbytes';
        StringGrid2.Cells[1, 9] := FloatToStrF(
          Overhead div 1024,
          ffNumber, 20, 0) + ' Kbytes';
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      StringGrid1.Cells[0, 0] := 'Memory load';
      StringGrid1.Cells[0, 1] := 'Physical memory';
      StringGrid1.Cells[0, 2] := 'Free physical memory';
      StringGrid1.Cells[0, 3] := 'RAM load';
      StringGrid1.Cells[0, 4] := 'Maximum size of paging file';
      StringGrid1.Cells[0, 5] := 'Available in paging file';
      StringGrid1.Cells[0, 6] := 'Paging file load';
      StringGrid1.Cells[0, 7] := 'Virtual address space';
      StringGrid1.Cells[0, 8] := 'Free in address space';
      StringGrid1.Cells[0, 9] := 'Used address space';
     
      StringGrid2.Cells[0, 0] := 'Available address space ';
      StringGrid2.Cells[0, 1] := 'Uncommitted portion';
      StringGrid2.Cells[0, 2] := 'Committed portion';
      StringGrid2.Cells[0, 3] := 'Free portion';
      StringGrid2.Cells[0, 4] := 'Allocated portion';
      StringGrid2.Cells[0, 5] := 'Address space load';
      StringGrid2.Cells[0, 6] := 'Total small free blocks';
      StringGrid2.Cells[0, 7] := 'Total big free blocks';
      StringGrid2.Cells[0, 8] := 'Other unused blocks';
      StringGrid2.Cells[0, 9] := 'Total overhead';
     
      UpdateStatus;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      UpdateStatus;
    end;
     
    procedure TForm1.BtnStringClick(Sender: TObject);
    begin
      // 10 megabytes
      SetLength(s, 10000000);
      UpdateStatus;
    end;
     
    procedure TForm1.BtnStringListClick(Sender: TObject);
    var
      I: Integer;
    begin
      sl := TStringList.Create;
      // add one thousand strings
      for I := 0 to 1000 do
        sl.Add('hello');
      // destroy some of them
      for I := 300 downto 1 do
        sl.Delete(I * 3);
      UpdateStatus;
    end;
     
    procedure TForm1.BtnFormClick(Sender: TObject);
    var
      I: Integer;
    begin
      // create ten forms
      for I := 1 to 10 do
        F := TForm.Create(Application);
      UpdateStatus;
    end;
     
    procedure TForm1.BtnSmallAllocClick(Sender: TObject);
    var
      P: Pointer;
    begin
      GetMem(P, 100);
      Integer(P^) := 10;
      UpdateStatus;
    end;
     
    procedure TForm1.BtnBigAllocClick(Sender: TObject);
    var
      P: Pointer;
    begin
      GetMem(P, 100000);
      Integer(P^) := 10;
      UpdateStatus;
    end;
     
    end.


