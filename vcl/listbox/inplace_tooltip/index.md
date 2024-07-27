---
Title: Показ in-place подсказки в TListBox и других компонентах
Author: Joe Huang (Happyjoe@21cn.com)
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Показ in-place подсказки в TListBox и других компонентах
========================================================

    { 
      In-place ToolTips are used to display text strings for objects that have been clipped, 
      in TreeView for example. The following code has been tested only on standard ListBox. 
      Of cause you can use tips on other VCLs after appropriate modification. 
      (Only copy following code to your form1's unit file) 
    } 
     
    //------------------------------------------------------------------------------ 
    //  Show in-place tooltips on ListBox 
    //  Author: Joe Huang   Email: Happyjoe@21cn.com 
    // 
    //------------------------------------------------------------------------------ 
     
     
    unit Unit1; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, 
      Dialogs, StdCtrls, CommCtrl; 
     
    type 
      //Override TListBox's WinProc to get CM_MOUSELEAVE message 
      TNewListBox = class(TListBox) 
      protected 
        { Protected declarations } 
        procedure WndProc(var Message: TMessage); override; 
      end; 
     
    type 
      TForm1 = class(TForm) 
        Button2: TButton; 
        procedure FormCreate(Sender: TObject); 
        procedure Button2Click(Sender: TObject); 
      private 
        { Private declarations } 
        GHWND: HWND; 
        TipVisable: Boolean; 
        OldIndex, CurrentIndex: Integer; 
        ti: TOOLINFO; 
        ListBox1: TListBox; 
     
        procedure InitListBox;   //Create ListBox1 dynamically 
        procedure CreateTipsWindow;  //Create Tooltip Window 
        procedure HideTipsWindow;    //Hide Tooltip Window 
     
        //WM_NOTIFY message's handler, fill Tooltip Window content 
        procedure WMNotify(var Msg: TMessage); message WM_NOTIFY; 
     
        procedure ListBox_MouseMove(Sender: TObject; Shift: TShiftState; X, 
          Y: Integer); 
        procedure ListBox_MouseDown(Sender: TObject; Button: TMouseButton; 
          Shift: TShiftState; X, Y: Integer); 
      public 
        { Public declarations } 
      end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.dfm} 
     
    { TNewListBox } 
     
    procedure TNewListBox.WndProc(var Message: TMessage); 
    begin 
      case Message.Msg of 
        CM_MOUSELEAVE: Form1.HideTipsWindow; 
      end; 
      inherited WndProc(Message); 
    end; 
     
    { TForm1 } 
     
    procedure TForm1.InitListBox; 
    begin 
      ListBox1 := TNewListBox.Create(Self); 
      ListBox1.Parent := Self; 
      ListBox1.Left := 50; 
      ListBox1.Top := 50; 
      ListBox1.Width := 200; 
      ListBox1.Height := 200; 
      //append serveral items for testing 
      ListBox1.Items.Append('happyjoe'); 
      ListBox1.Items.Append('Please send me email: happyjoe@21cn.com'); 
      ListBox1.Items.Append('Delphi 5 Developer`s Guide'); 
      ListBox1.Items.Append('Delphi 5.X ADO/MTS/COM+ Advanced Development'); 
     
      ListBox1.OnMouseMove := ListBox_MouseMove; 
      ListBox1.OnMouseDown := ListBox_MouseDown; 
    end; 
     
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      Self.Font.Name := 'Tahoma'; 
      InitListBox; 
      CreateTipsWindow; 
    end; 
     
    procedure TForm1.CreateTipsWindow; 
    var 
      iccex: tagINITCOMMONCONTROLSEX; 
    begin 
      // Load the ToolTip class from the DLL. 
      iccex.dwSize := SizeOf(tagINITCOMMONCONTROLSEX); 
      iccex.dwICC := ICC_BAR_CLASSES; 
      InitCommonControlsEx(iccex); 
     
      // Create the ToolTip control. 
      GHWND := CreateWindow(TOOLTIPS_CLASS, '', 
                            WS_POPUP, 
                            Integer(CW_USEDEFAULT), Integer(CW_USEDEFAULT), 
                            Integer(CW_USEDEFAULT), Integer(CW_USEDEFAULT), 
                            0, 0, hInstance, 
                            nil); 
     
      // Prepare TOOLINFO structure for use as tracking ToolTip. 
      ti.cbSize := SizeOf(ti); 
      ti.uFlags := TTF_IDISHWND + TTF_TRACK + TTF_ABSOLUTE + TTF_TRANSPARENT; 
      ti.hwnd := Self.Handle; 
      ti.uId := ListBox1.Handle; 
      ti.hinst := hInstance; 
      ti.lpszText := LPSTR_TEXTCALLBACK; 
      ti.Rect.Left := 0; 
      ti.Rect.Top := 0; 
      ti.Rect.Bottom := 0; 
      ti.Rect.Right := 0; 
     
      SendMessage(GHWND, WM_SETFONT, ListBox1.Font.Handle, Integer(LongBool(False))); 
      SendMessage(GHWND,TTM_ADDTOOL,0,Integer(@ti)); 
    end; 
     
    procedure TForm1.WMNotify(var Msg: TMessage); 
    var 
      phd: PHDNotify; 
      NMTTDISPINFO: PNMTTDispInfo; 
    begin 
      phd := PHDNotify(Msg.lParam); 
      if phd.Hdr.hwndFrom = GHWND then 
      begin 
        if phd.Hdr.Code = TTN_NEEDTEXT then 
        begin 
          NMTTDISPINFO := PNMTTDispInfo(phd); 
          NMTTDISPINFO.lpszText := PChar(ListBox1.Items[CurrentIndex]); 
        end; 
      end; 
    end; 
     
    procedure TForm1.ListBox_MouseDown(Sender: TObject; Button: TMouseButton; 
      Shift: TShiftState; X, Y: Integer); 
    begin 
      if TipVisable then     //when mouse down, hide Tooltip Window 
      begin 
        SendMessage(GHWND,TTM_TRACKACTIVATE,Integer(LongBool(False)), 0); 
        TipVisable := False; 
      end; 
    end; 
     
    procedure TForm1.ListBox_MouseMove(Sender: TObject; Shift: TShiftState; X, 
      Y: Integer); 
    var 
      Index: Integer; 
      APoint: TPoint; 
      ARect: TRect; 
      ScreenRect: TRect; 
    begin 
      Index := ListBox1.ItemAtPos(Point(X, Y), true); 
      if Index = -1 then   begin 
        SendMessage(GHWND,TTM_TRACKACTIVATE,Integer(LongBool(False)), 0); 
        OldIndex := -1; 
        TipVisable := False; 
        Exit; 
      end; 
      CurrentIndex := Index; 
      if Index = OldIndex then Exit; 
      if TipVisable then 
      begin 
        SendMessage(GHWND,TTM_TRACKACTIVATE,Integer(LongBool(False)), 0); 
        OldIndex := -1; 
        TipVisable := False; 
      end else 
      begin 
        ARect := ListBox1.ItemRect(Index); 
     
        if (ARect.Right - ARect.Left - 2) >= ListBox1.Canvas.TextWidth(ListBox1.Items[Index]) then 
        begin 
          OldIndex := -1; 
          Exit; 
        end; 
        APoint := ListBox1.ClientToScreen(ARect.TopLeft); 
        windows.GetClientRect(GetDesktopWindow, ScreenRect); 
     
        if ListBox1.Canvas.TextWidth(ListBox1.Items[Index]) + APoint.X > ScreenRect.Right then 
          APoint.X := ScreenRect.Right - ListBox1.Canvas.TextWidth(ListBox1.Items[Index]) - 5; 
        SendMessage(GHWND, 
                    TTM_TRACKPOSITION, 
                    0, 
                    MAKELPARAM(APoint.x - 1, APoint.y - 2)); 
     
        SendMessage(GHWND,TTM_TRACKACTIVATE,Integer(LongBool(True)), Integer(@ti)); 
        OldIndex := Index; 
        TipVisable := True; 
      end; 
    end; 
     
    procedure TForm1.HideTipsWindow; 
    begin 
      if TipVisable then 
      begin 
        SendMessage(GHWND,TTM_TRACKACTIVATE,Integer(LongBool(False)), 0); 
        OldIndex := -1; 
        TipVisable := False; 
      end; 
    end; 
     
    // Test it: 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
     InitListBox; 
     CreateTipsWindow; 
    end; 
     
    end. 
    end.

