---
Title: Как рисовать картинки в пунктах меню?
Author: Eugeny Sverchkov (StayAtHome) es906@kolnpp.elektra.ru
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как рисовать картинки в пунктах меню?
=====================================

    unit DN_Win;
     
    interface
     
    uses
     SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
     Forms, Dialogs, Menus, StdCtrls,
     
    type
     TDNForm = class(TForm)
       MainMenu1: TMainMenu;
       cm_MainExit: TMenuItem;
       procedure FormCreate(Sender: TObject);
       procedure cm_MainExitClick(Sender: TObject);
     private
       { Private declarations }
     public
       { Public declarations }
       BM:TBitmap;
       Procedure WMDrawItem(var Msg:TWMDrawItem);      message wm_DrawItem;
       Procedure WMMeasureItem(var Msg:TWMMeasureItem); message
    wm_MeasureItem;
     
    end;
     
    var
     DNForm : TDNForm;
     
    implementation
     
    {$R *.DFM}
     
    var
     Comm,yMenu : word;
     
    procedure TDNForm.FormCreate(Sender: TObject);
    begin
     yMenu:=GetSystemMetrics(SM_CYMENU);
     comm:=cm_MainExit.Command;
     ModifyMenu(MainMenu1.Handle,0,mf_ByPosition or mf_OwnerDraw,comm,'Go');
    end;{TDNForm.FormCreate}
     
    procedure TDNForm.cm_MainExitClick(Sender: TObject);
    begin
     DNForm.Close;
    end;{TDNForm.cmExitClick}
     
    Procedure TDNForm.WMMeasureItem(var Msg:TWMMeasureItem);
     
    Begin
    with Msg.MeasureItemStruct^ do
     if ItemID=comm then  begin ItemWidth:=yMenu; Itemheight:=yMenu; end;
    End;{WMMeasureItem}
     
    Procedure TDNForm.WMDrawItem(var Msg:TWMDrawItem);
    var
     MemDC:hDC;
     BM:hBitMap;
     mtd:longint;
    Begin
    with Msg.DrawItemStruct^ do
     begin
     if ItemID=comm then
       begin
         BM:=LoadBitMap(hInstance,'dver');
         MemDC:=CreateCompatibleDC(hDC);{hDC  ? TDrawItemStruct}
         SelectObject(MemDC,BM); {rcItem  ?  TDrawItemStruct}
     
         if ItemState=ods_Selected then mtd:=NotSrcCopy  else mtd:=SrcCopy;
     
         StretchBlt(hDC,rcItem.left,rcItem.top,yMenu,yMenu,MemDC,0,0,24,23,mtd);
         DeleteDC(MemDC);
         DeleteObject(BM);
       end;
     end{with}
    End;{TDNForm.WMDrawItem}
     
    end.

Eugeny Sverchkov (StayAtHome)  
es906@kolnpp.elektra.ru  
(2:5031/12.23)

