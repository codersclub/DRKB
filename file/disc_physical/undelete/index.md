---
Title: Программа для восстановления удаленных файлов
Author: NikNet (NikNet@Yandex.ru)
Date: 01.01.2007
---


Программа для восстановления удаленных файлов
=============================================

    {$S-,R-,B-}
     
    {Avtor: NikNet@yandex.ru}
     
    unit uMain;

    interface
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, tlHelp32,  ExtCtrls, FileCtrl, ComCtrls,
      StdCtrls, Grids, Menus, shellApi,UFAT, ToolWin;
     
    type
      TForm1 = class(TForm)
        StringGrid1: TStringGrid;
        ToolBar1: TToolBar;
        ToolButton1: TToolButton;
        SaveDialog1: TSaveDialog;
        ToolButton2: TToolButton;
        StatusBar1: TStatusBar;
        DriveComboBox1: TDriveComboBox;
        procedure StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
          R: TRect; State: TGridDrawState);
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure FormShow(Sender: TObject);
        procedure StringGrid1DblClick(Sender: TObject);
        procedure ToolButton1Click(Sender: TObject);
        procedure Rootdirectory1Click(Sender: TObject);
        procedure DriveComboBox1Change(Sender: TObject);
      protected
      private
        { Private declarations }
      public
        { Public declarations }
        Procedure DirView(Cluster:Int64);
      end;
     
    var
      Form1  : TForm1;
     
    implementation
     
    {$R *.DFM}
     
    VAR
      entres : Integer;
      dir    : PDIR_Entry;
      Drv    : Char;
      I, J  : DWORD;
      QP     : LongInt;
     
     
    Procedure TForm1.DirView(Cluster:Int64);
    Function ITS(Int:Int64):String;
    Begin
     Str(int,result);
     if Length(Result) = 1 then
     Result:='0'+Result;
    end;
     
    Var
      i :word;
      Hour, Minute, Second:word;
      Day, Month, Year:word;
      attr:array[0..5] of char;
    begin
     attr:='______';
      if ReadDIR(Cluster,dir,entres) then
      Begin
      i:=0;
      QP:=entres;
      StringGrid1.RowCount:=QP+1;
      Repeat
        inc(i);
        if i > entres then  exit;
        StringGrid1.Cells[00,i]:=IntToHex(Dir.CurrentSector,8);
        StringGrid1.Cells[01,i]:=IntToHex(Dir.StartByteNamePerSec,3);
        StringGrid1.Cells[02,i]:=DosToWin(Dir.Name);
        StringGrid1.Cells[03,i]:=DosToWin(Dir.Ext);
        if dir.Erased then
          StringGrid1.Cells[04,i]:='deleted'
        else
          StringGrid1.Cells[04,i]:='';
        if (dir.Attr and ATTR_DIRECTORY) <> 0 Then
          StringGrid1.Cells[05,i]:='Dir'
        else
          StringGrid1.Cells[05,i]:='File';
        If dir.Attr and ATTR_READONLY  <> 0 Then  attr[5]:='r' else attr[5]:='_';
        If dir.Attr and ATTR_HIDDEN    <> 0 Then  attr[4]:='h' else attr[4]:='_';
        If dir.Attr and ATTR_SYSTEM    <> 0 Then  attr[3]:='s' else attr[3]:='_';
        If dir.Attr and ATTR_VOLUME    <> 0 Then  attr[2]:='v' else attr[2]:='_';
        If dir.Attr and ATTR_DIRECTORY <> 0 Then  attr[1]:='d' else attr[1]:='_';
        If dir.Attr and ATTR_ARCHIVE   <> 0 Then  attr[0]:='a' else attr[0]:='_';
        StringGrid1.Cells[06,i]:=attr;
        StringGrid1.Cells[07,i]:=FormatDiskSize(Dir.FileSize);
        StringGrid1.Objects[07,i]:=TObject(Dir.FileSize);
        ParseDOSDate(dir.CreateDate,Day, Month, Year);
        ParseDOSTime(Dir.CreateTime,Hour, Minute, Second);
        StringGrid1.Cells[08,i]:=
        ITS(Day)+'/'+ITS(Month)+'/'+ITS(Year)+'  '+
        ITS(Hour)+':'+ITS(Minute)+':'+ITS(Second);
        ParseDOSDate(Dir.WriteLastDate,Day, Month, Year);
        ParseDOSTime(Dir.WriteLastTime,Hour, Minute, Second);
        StringGrid1.Cells[09,i]:=
        ITS(Day)+'/'+ITS(Month)+'/'+ITS(Year)+'  '+
        ITS(Hour)+':'+ITS(Minute)+':'+ITS(Second);
        ParseDOSDate(Dir.LastAccessDate,Day, Month, Year);
        StringGrid1.Cells[10,i]:=ITS(Day)+'/'+ITS(Month)+'/'+ITS(Year);
        StringGrid1.Cells[11,i]:=IntToHex(Dir.StartCluster,8);
        inc(dir);
      Until i = entres;
      end;
        StringGrid1.rePaint;
    end;
     
     
    PROCEDURE kc(r,g,b:integer);
    var
      c,z:integer;
      m:array[1..4] of byte absolute c;
     
    Function o(z:integer):integer;
    begin
      if z>255 then o:=255 else if z<0 then o:=0 else o:=z;
    end;
     
    begin
    //корекция цвета
      c:=form1.stringGrid1.canvas.brush.color;
      m[1]:=o(m[1]+r);
      m[2]:=o(m[2]+g);
      m[3]:=o(m[3]+b);
      form1.stringGrid1.canvas.brush.color:=c;
    end;
     
    procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
      R: TRect; State: TGridDrawState);
    var
      s:string;
      cw:integer;

    begin
     with StringGrid1.Canvas do
     begin
      pen.color:=$C0C0CC;
      if (aRow<qp) then
        r:=rect(r.left,r.top,r.right,r.bottom+1);
      if (aCol<stringGrid1.colCount-1) then
        r:=rect(r.left,r.top,r.right+1,r.bottom);
      s:='';
     
      if aRow=0 then
      begin
      {   if (aCol=0) or (aCol=1) then
            brush.color:=$B0C0D0 else}
     
       brush.color:=$B0C2E0;
       pen.color:=$A0A0AA;
       font.color:=000000;
       rectangle(r);
       case aCol of
          00:s:='Sector';
          01:s:='Offset';
          //--------------
          02:s:='Name';
          03:s:='Ext';
          04:s:='Status';
          05:s:='Type';
          06:s:='Attr';
          07:s:='Size';
          08:s:='Created';
          09:s:='Modified';
          10:s:='Accessed';
          11:s:='Cluster';
          12:s:='';
       end;
      end else
      begin
       font.color:=$8088A8;
       if gdSelected in State then
         brush.color:=$DFE8FF
       else
         brush.color:=$FFFFFF;
     
       if aRow<=qp then
       begin
        // текст
        case aCol of
          00: s:= StringGrid1.Cols[00].Strings[aRow];
          01: s:= StringGrid1.Cols[01].Strings[aRow];
          02: s:= StringGrid1.Cols[02].Strings[aRow];
          03: s:= StringGrid1.Cols[03].Strings[aRow];
          04: s:= StringGrid1.Cols[04].Strings[aRow];
          05: s:= StringGrid1.Cols[05].Strings[aRow];
          06: s:= StringGrid1.Cols[06].Strings[aRow];
          07: s:= StringGrid1.Cols[07].Strings[aRow];
          08: s:= StringGrid1.Cols[08].Strings[aRow];
          09: s:= StringGrid1.Cols[09].Strings[aRow];
          10: s:= StringGrid1.Cols[10].Strings[aRow];
          11: s:= StringGrid1.Cols[11].Strings[aRow];
          12: s:= StringGrid1.Cols[12].Strings[aRow];
        end;
     
       if aCol=4 then
       begin
        kc(80,-10,-20);
        font.color:=$8888DD
       end else
        kc(5,-5,-5);
     
       if (aCol=2) then
       begin
        kc(100,-12,-30);
        if (StringGrid1.Cols[05].Strings[aRow][1] = 'D') then
        Begin
         if (StringGrid1.Cols[04].Strings[aRow] <> 'deleted') then
         font.color:=0 else
         font.color:=$8850DD;
        end else
        Begin
         if (StringGrid1.Cols[04].Strings[aRow] <> 'deleted') then
         font.color:=$600600 else
         font.color:=$8888DD;
        end;
    //     font.color:=clGray-100;
     
    {    if StringGrid1.Cols[03].Strings[aRow] <> '' then
        font.color:=$8888DD}
       end else
        kc(5,-5,-5);
     
       if (aCol=0) or (aCol=1) then
       begin
         kc(80,-10,-20);
         brush.color:=$FFFFFF;
         pen.Color:=$FFEFFF;
       end else
       Begin
        kc(5,-5,-5);
       end;
       rectangle(r);
       if gdSelected in State then begin
         pen.Color:=$A0C0FF;
         moveTo(r.left,r.top+1); lineTo(r.right,r.top+1);
         moveTo(r.left,r.bottom-2); lineTo(r.right,r.bottom-2);
       end;
      end;
     end;
     textOut(r.left+3,r.top+3,s);
    end;
    end;
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
       stringGrid1.GridLineWidth:=0;
       stringGrid1.color:=$DFEFFF;
    end;
     
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
     Done;
    end;
     

    procedure TForm1.FormShow(Sender: TObject);
    begin
      DirView(0);
    end;
     

    procedure TForm1.StringGrid1DblClick(Sender: TObject);
    begin
      if (StringGrid1.Cells[5,StringGrid1.Row][1] <> 'F') then
        DirView(StrToInt('$'+StringGrid1.Cells[11,StringGrid1.Row]));
    end;
     

    procedure TForm1.ToolButton1Click(Sender: TObject);
    Var
     Buf:Pointer;
     nSize:Dword;
     Sector:Dword;
     nSectors:Dword;
     F:File;
    begin
      if (StringGrid1.Cells[5,StringGrid1.Row][1] <> 'D') then
      Begin
        SaveDialog1.FileName:=StringGrid1.Cells[2,StringGrid1.Row]+'.'+
        StringGrid1.Cells[3,StringGrid1.Row];
     
        if SaveDialog1.Execute then
        Begin
          Sector:=StrToInt('$'+StringGrid1.Cells[11,StringGrid1.Row]);
          sector:=((Sector-2) * SectorsPerCluster)+DataAreaSector;
          nSize:=DWORD(StringGrid1.Objects[07,StringGrid1.Row]);
          nSectors:=Round(nSize div BytesPerSector)+1;
          GetMem(Buf,nSize);
          ReadSector(Sector,nSectors,Buf^,nSize);
          AssignFile(F,SaveDialog1.FileName);
          Rewrite(f,1);
          BlockWrite(F,Buf^,nSize);
          CloseFile(F);
        end;
      end;
    end;
     
    procedure TForm1.Rootdirectory1Click(Sender: TObject);
    begin
      DirView(0);
    end;
     
    procedure TForm1.DriveComboBox1Change(Sender: TObject);
    begin
      drv:=DriveComboBox1.Drive;
      Init(ord(drv)-64);
      DirView(0);   
    end;
     
    end.

