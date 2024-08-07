---
Title: Перехват изменения размера колонки в TListView
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Перехват изменения размера колонки в TListView
==============================================

Вопрос:
> Как мне перехватить событие изменения размера столбца в TListView,
> OnResize работает только при изменении ListView?

Ответ:  
Событие можно добавить, проделав немного работы.
См. производную TListview ниже.
В нем есть 3 новых события: OnColumnResize, OnBeginColumnResize, OnEndColumnResize

    { 
      Question: 
      How do I capture a column resize event in TListView, the OnResize 
      only works when the ListView is changed? 
     
      Answer: 
      The event can be added with a bit of work. See the custom TListview derivative 
      below. It has 3 new events: 
      OnColumnResize, OnBeginColumnResize, OnEndColumnResize 
    } 
     
    unit PBExListview; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, 
      Dialogs, ComCtrls; 
     
    type 
      TLVColumnResizeEvent = procedure(Sender: TCustomListview; 
        columnindex: Integer; 
        columnwidth: Integer) of object; 
      TPBExListview = class(TListview) 
      private 
        FBeginColumnResizeEvent: TLVColumnResizeEvent; 
        FEndColumnResizeEvent: TLVColumnResizeEvent; 
        FColumnResizeEvent: TLVColumnResizeEvent; 
     
      protected 
        procedure DoBeginColumnResize(columnindex, columnwidth: Integer); 
          virtual; 
        procedure DoEndColumnResize(columnindex, columnwidth: Integer); 
          virtual; 
        procedure DoColumnResize(columnindex, columnwidth: Integer); 
          virtual; 
        procedure WMNotify(var Msg: TWMNotify); message WM_NOTIFY; 
        function FindColumnIndex(pHeader: pNMHdr): Integer; 
        function FindColumnWidth(pHeader: pNMHdr): Integer; 
        procedure CreateWnd; override; 
      published 
        property OnBeginColumnResize: TLVColumnResizeEvent 
          read FBeginColumnResizeEvent write FBeginColumnResizeEvent; 
        property OnEndColumnResize: TLVColumnResizeEvent 
          read FEndColumnResizeEvent write FEndColumnResizeEvent; 
        property OnColumnResize: TLVColumnResizeEvent 
          read FColumnResizeEvent write FColumnResizeEvent; 
      end; 
     
    procedure Register; 
     
    implementation 
     
    uses CommCtrl; 
     
    procedure Register; 
    begin 
      RegisterComponents('PBGoodies', [TPBExListview]); 
    end; 
     
    procedure TPBExListview.DoBeginColumnResize(columnindex, columnwidth: Integer); 
    begin 
      if Assigned(FBeginColumnResizeEvent) then 
        FBeginColumnResizeEvent(Self, columnindex, columnwidth); 
    end; 
     
    procedure TPBExListview.DoEndColumnResize(columnindex, columnwidth: Integer); 
    begin 
      if Assigned(FEndColumnResizeEvent) then 
        FEndColumnResizeEvent(Self, columnindex, columnwidth); 
    end; 
     
    procedure TPBExListview.DoColumnResize(columnindex, columnwidth: Integer); 
    begin 
      if Assigned(FColumnResizeEvent) then 
        FColumnResizeEvent(Self, columnindex, columnwidth); 
    end; 
     
    function TPBExListview.FindColumnIndex(pHeader: pNMHdr): Integer; 
    var 
      hwndHeader: HWND; 
      iteminfo: THdItem; 
      ItemIndex: Integer; 
      buf: array [0..128] of Char; 
    begin 
      Result := -1; 
      hwndHeader := pHeader^.hwndFrom; 
      ItemIndex := pHDNotify(pHeader)^.Item; 
      FillChar(iteminfo, SizeOf(iteminfo), 0); 
      iteminfo.Mask := HDI_TEXT; 
      iteminfo.pszText := buf; 
      iteminfo.cchTextMax := SizeOf(buf) - 1; 
      Header_GetItem(hwndHeader, ItemIndex, iteminfo); 
      if CompareStr(Columns[ItemIndex].Caption, iteminfo.pszText) = 0 then 
        Result := ItemIndex 
      else 
      begin 
        for ItemIndex := 0 to Columns.Count - 1 do 
          if CompareStr(Columns[ItemIndex].Caption, iteminfo.pszText) = 0 then 
          begin 
            Result := ItemIndex; 
            Break; 
          end; 
      end; 
    end; 
     
    procedure TPBExListview.WMNotify(var Msg: TWMNotify); 
    begin 
      inherited; 
      case Msg.NMHdr^.code of 
        HDN_ENDTRACK: 
          DoEndColumnResize(FindColumnIndex(Msg.NMHdr), 
            FindColumnWidth(Msg.NMHdr)); 
        HDN_BEGINTRACK: 
          DoBeginColumnResize(FindColumnIndex(Msg.NMHdr), 
            FindColumnWidth(Msg.NMHdr)); 
        HDN_TRACK: 
          DoColumnResize(FindColumnIndex(Msg.NMHdr), 
            FindColumnWidth(Msg.NMHdr)); 
      end; 
    end; 
     
    procedure TPBExListview.CreateWnd; 
    var 
      wnd: HWND; 
    begin 
      inherited; 
      wnd := GetWindow(Handle, GW_CHILD); 
      SetWindowLong(wnd, GWL_STYLE, 
        GetWindowLong(wnd, GWL_STYLE) and not HDS_FULLDRAG); 
    end; 
     
    function TPBExListview.FindColumnWidth(pHeader: pNMHdr): Integer; 
    begin 
      Result := -1; 
      if Assigned(PHDNotify(pHeader)^.pItem) and 
        ((PHDNotify(pHeader)^.pItem^.mask and HDI_WIDTH) <> 0) then 
        Result := PHDNotify(pHeader)^.pItem^.cxy; 
    end; 
     
    end.

