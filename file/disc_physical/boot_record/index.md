---
Title: Показать загрузочную запись визуально
Author: NikNet (NikNet@Yandex.ru)
Date: 01.01.2007
---


Показать загрузочную запись визуально
=====================================

    {$S-,R-,B-}
    unit uBoot;
    interface
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, tlHelp32,  ExtCtrls, FileCtrl, ComCtrls,
      StdCtrls, Grids, Menus, shellApi,UFAT, ToolWin;
     
     
    type
      TForm1 = class(TForm)
        StatusBar1: TStatusBar;
        MainMenu1: TMainMenu;
        Drive1: TMenuItem;
        ScrollBar1: TScrollBar;
        Panel2: TPanel;
        Boot32Grid: TStringGrid;
        procedure Boot32GridDrawCell(Sender: TObject; ACol, ARow: Integer;
          R: TRect; State: TGridDrawState);
        procedure FormCreate(Sender: TObject);
        procedure Boot32GridMouseWheelDown(Sender: TObject;
          Shift: TShiftState; MousePos: TPoint; var Handled: Boolean);
        procedure Boot32GridMouseWheelUp(Sender: TObject;
          Shift: TShiftState; MousePos: TPoint; var Handled: Boolean);
        procedure Boot32GridMouseMove(Sender: TObject; Shift: TShiftState;
          X, Y: Integer);
        procedure Boot32GridClick(Sender: TObject);
        procedure FormResize(Sender: TObject);
      protected
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
     
    var
      Form1  : TForm1;
     
     
    implementation
     
    uses Disk;
     
    {$R *.DFM}
     
    VAR
      QP           : LongInt = 14;
      MSScrollDown : Boolean = False;
      MSScrollUp   : Boolean = False;
     
     
    procedure TForm1.Boot32GridDrawCell(Sender: TObject; ACol, ARow: Integer;
      R: TRect; State: TGridDrawState);
    var
      s:string;
      cR   : TRect;
      rR   : TRect;
      rTmp : TRect;
      gr  :TGridRect;
      i,j:Byte;
    begin
     with Boot32Grid.Canvas do
     begin
      if (aRow<qp) then
        r:=rect(r.left,r.top,r.right,r.bottom+1);
      if (aCol<Boot32Grid.colCount-1) then
        r:=rect(r.left,r.top,r.right+1,r.bottom);
      s:='';
      font.color:=$0;
     
      if aRow=0 then
      begin
        brush.color:=$D5F5E0;
        pen.color:=$D5F5E0;
        r:=rect(0,r.top,r.Right,r.bottom-1);
        rectangle(r);
        TextOut(r.Left+5,r.Top+2,'Sector');
        TextOut(r.left+70,r.Top+2,'Boot Sector (FAT32)');
      end else
      if (aRow=1)  then
      begin
        brush.color:=$B9B0E0;
        pen.color:=$B9B0E0;
        r:=rect(0,r.top,r.Right,r.bottom-1);
        rectangle(r);
        TextOut(r.Left+4,r.top+2,'x'+Boot32Grid.Cols[00].Strings[aRow]);
        TextOut(r.Left+70,r.top+2,'Valid Boot Sector');
        pen.color:=$BF;
      end else
      begin
       pen.Color:=$DFE8FF;
       brush.color:=$DFE8FF;
       font.color:=$0;
       if aRow<=qp then
       begin
         // текст
        case ACol  of
          00: s:= Boot32Grid.Cols[00].Strings[aRow];
          01: s:= Boot32Grid.Cols[01].Strings[aRow];
          02: s:= Boot32Grid.Cols[02].Strings[aRow];
          03: s:= Boot32Grid.Cols[03].Strings[aRow];
          04: s:= Boot32Grid.Cols[04].Strings[aRow];
          05: s:= Boot32Grid.Cols[05].Strings[aRow];
          06: s:= Boot32Grid.Cols[06].Strings[aRow];
          07: s:= Boot32Grid.Cols[07].Strings[aRow];
        end;
     
        if (aCol=0)  then
        begin
         brush.color:=$FFFFFF;
         pen.Color:=$FFFFFF;
        end;
     
        if (aCol=2) or (aCol=4)  then
        Begin
          Brush.Color:=$DFECFF;
            pen.Color:=$DFECFF;
    //     Font.Color:=$A928FF;
        end;
     
        rectangle(r);
      end;
    // -------------------- Select -----------------------
      if gdSelected in State then
      begin
        if (ACol <> 1)and(aCol <> 3) Then
        Begin
         rTmp:=Rect(r.Left+1,r.Top+1,r.Right-2,r.Bottom-1);
         brush.color:=$455D9F;
         Font.Color:=$FFFFFF;
         pen.Color:=$DE81F5;
         rectangle(rTmp);
        end else
        Boot32Grid.Col:=ACol+1;
      end;
     end;
       textOut(r.left+5,r.top+2,s);
    //----------------------------------------------------
       pen.Color:=$B9B0E0;
      if (aRow>=2) and ((aCol = 1)or(aCol = 3)) then
      Begin
       moveTo(r.Left,r.Bottom);
       LineTo(R.Left,r.Top-1);
      end;
    //-----------------------------------------------------
      if (aRow=Boot32Grid.RowCount-1)  then
      Begin
       moveTo(r.Left+r.Right,R.Top+Boot32Grid.DefaultRowHeight-1);
       LineTo(r.Left,r.Top+Boot32Grid.DefaultRowHeight-1);
      end;
    end;
    end;
     
     
    procedure TForm1.FormCreate(Sender: TObject);
     
     
    function AlgStr(Str: string): string;
    Var
     d,l,i:Byte;
    begin
     d:=20;
     l:=Length(Str);
     if l >= 20 then
     Begin
       Copy(Str,1,20);
       l:=20;
     end;
     d:=d-l;
     For i:=l to d do
     Str:=Str+' ';
     Result:='x'+str;
    end;
     
    Function StrToHexInt(Int,Def:DWORD):String;
    Begin
     Result:=AlgStr(IntToHex(Int,Def))+IntToStr(Int);
    end;
     
    Function GetActiveFAT(bsExtFlags:word):String;
    Begin
     if (bsExtFlags and $40) = 0 then
     Result:='Yes (bit 7 clear)' else
     Result:='No (bit 7 clear)';
    end;
     
    Var
     P:Pointer;
    begin
       Boot32Grid.GridLineWidth:=0;
       Boot32Grid.color:=$DFEFFF;
       ScrollBar1.Max:=1000000000;
       Boot32Grid.Cells[0,01]:=IntToHex(63,8);
       Boot32Grid.Cells[0,02]:=IntToStr(63);
       Boot32Grid.Cells[1,02]:='OEM name:';             Boot32Grid.Cells[3,02]:='Big sectors per FAT:';
       Boot32Grid.Cells[1,03]:='Bytes per sector:';     Boot32Grid.Cells[3,03]:='Active FAT:';
       Boot32Grid.Cells[1,04]:='Sectors per cluster:';  Boot32Grid.Cells[3,04]:='FAT mirrored:';
       Boot32Grid.Cells[1,05]:='Reserved sectors:';     Boot32Grid.Cells[3,05]:='Minor FS version:';
       Boot32Grid.Cells[1,06]:='FATs:';                 Boot32Grid.Cells[3,06]:='Major FS version:';
       Boot32Grid.Cells[1,07]:='Root dir entries:';     Boot32Grid.Cells[3,07]:='1st Root cluster:';
       Boot32Grid.Cells[1,08]:='Sectors on drive:';     Boot32Grid.Cells[3,08]:='FS info sector:';
       Boot32Grid.Cells[1,09]:='Media descriptor:';     Boot32Grid.Cells[3,09]:='Backup Boot sector:';
       Boot32Grid.Cells[1,10]:='Sectors per FAT:';      Boot32Grid.Cells[3,10]:='Physical drive #:';
       Boot32Grid.Cells[1,11]:='Sectors per track:';    Boot32Grid.Cells[3,11]:='Boot record signature:';
       Boot32Grid.Cells[1,12]:='heads:';                Boot32Grid.Cells[3,12]:='Volume serial number:';
       Boot32Grid.Cells[1,13]:='Hidden sectors:';       Boot32Grid.Cells[3,13]:='Volume label:';
       Boot32Grid.Cells[1,14]:='Big sectors on drive:'; Boot32Grid.Cells[3,14]:='File system:';
      GetMem(P,512);
       ReadPlysicalSector($0,63,1,P^);
       With PBoot32(P)^ do
       Begin
        Boot32Grid.Cells[2,02]:=bsOemname;                     Boot32Grid.Cells[4,02]:=StrToHexInt(bsFATSz32,8);
        Boot32Grid.Cells[2,03]:=StrToHexInt(bsBytePerSec,4);   Boot32Grid.Cells[4,03]:=StrToHexInt(bsExtFlags and $F,1);
        Boot32Grid.Cells[2,04]:=StrToHexInt(bsSecPerClus,2);   Boot32Grid.Cells[4,04]:=GetActiveFAT(bsExtFlags);
        Boot32Grid.Cells[2,05]:=StrToHexInt(bsRsvdSecCnt,4);   Boot32Grid.Cells[4,05]:=StrToHexInt(hi(bsFSVer),1);
        Boot32Grid.Cells[2,06]:=StrToHexInt(bsNumFATs,2);      Boot32Grid.Cells[4,06]:=StrToHexInt(lo(bsFSVer),1);
        Boot32Grid.Cells[2,07]:=StrToHexInt(bsRootEntCnt,4);   Boot32Grid.Cells[4,07]:=StrToHexInt(bsRootClus,8);
        Boot32Grid.Cells[2,08]:=StrToHexInt(bsToolSec16,4);    Boot32Grid.Cells[4,08]:=StrToHexInt(bsFSInfo,4);
        Boot32Grid.Cells[2,09]:=StrToHexInt(bsMedia,2);        Boot32Grid.Cells[4,09]:=StrToHexInt(bsBkBootSec,4);
        Boot32Grid.Cells[2,10]:=StrToHexInt(bsFATz16,4);       Boot32Grid.Cells[4,10]:=StrToHexInt(bsDrvNum,2);
        Boot32Grid.Cells[2,11]:=StrToHexInt(bsSecPerTrk,4);    Boot32Grid.Cells[4,11]:=StrToHexInt(bsBootSig,2);
        Boot32Grid.Cells[2,12]:=StrToHexInt(bsNumHeads,4);     Boot32Grid.Cells[4,12]:=StrToHexInt(bsVolId,2);
        Boot32Grid.Cells[2,13]:=StrToHexInt(bsHiddSec,8);      Boot32Grid.Cells[4,13]:=bsVolLab;
        Boot32Grid.Cells[2,14]:=StrToHexInt(bsTolSec32,8);     Boot32Grid.Cells[4,14]:=bsFSType;
       end;
     FreeMem(P);
    end;
     
     
     
     
    procedure TForm1.Boot32GridMouseWheelDown(Sender: TObject;
      Shift: TShiftState; MousePos: TPoint; var Handled: Boolean);
    begin
      MSScrollDown:=True;
      MSScrollUp:=False;
    end;
     
    procedure TForm1.Boot32GridMouseWheelUp(Sender: TObject;
      Shift: TShiftState; MousePos: TPoint; var Handled: Boolean);
    begin
      MSScrollUp:=True;
      MSScrollDown:=False;
    end;
     
    procedure TForm1.Boot32GridMouseMove(Sender: TObject;
      Shift: TShiftState; X, Y: Integer);
    begin
      MSScrollUp:=False;
      MSScrollDown:=False;
    end;
     
    procedure TForm1.Boot32GridClick(Sender: TObject);
    Var
    gr:TGridRect;
    begin
     
    end;
     
    procedure TForm1.FormResize(Sender: TObject);
    Var
     i,ColsWidth,RowsHeight:Integer;
    begin
     ColsWidth:=0;
     RowsHeight:=0;
    With Boot32Grid do
    Begin
     For i:=0 to ColCount-2 do
       ColsWidth:=ColsWidth+ColWidths[i];
     For i:=1 to RowCount-1 do
       RowsHeight:=RowsHeight+RowHeights[i];
     ColWidths[ColCount-1]:=Form1.Width-ColsWidth-26;
     Height:=RowsHeight;
    end;
    end;
     
    end.
     
     
     
