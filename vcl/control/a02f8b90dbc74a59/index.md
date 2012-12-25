---
Title: Блокирование закладок TPageControl
Author: Rouse\_, Krid
Date: 01.01.2007
---


Блокирование закладок TPageControl
==================================

::: {.date}
01.01.2007
:::

    unit GSPageControl;

     
    interface
     
    uses
      Windows, Messages, Types, SysUtils, Classes, Controls, ComCtrls, CommCtrl;
     
    type
      TGSPageControl = class(TPageControl)
      private
        FNewPageIndex, FNotifyIndex: Integer;
        FTab:boolean;
      protected
        function GetTabFromCursor: Integer;
        function CanChange: Boolean; override;
        procedure WMKeyDown(var Message: TWMKey); message WM_KEYDOWN;
        procedure CMDialogKey(var Message: TCMDialogKey); message CM_DIALOGKEY;
      public
        property NewPageIndex: Integer read FNewPageIndex;
        constructor Create(AOwner: TComponent); override;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Samples', [TGSPageControl]);
    end;
     
    { TGSPageControl }
     
    function TGSPageControl.CanChange: Boolean;
    begin
      if fTab then FNewPageIndex:=FNotifyIndex else
      FNewPageIndex := GetTabFromCursor;
      if FNewPageIndex = -1 then
        FNewPageIndex := FNotifyIndex;
      Result := inherited CanChange;
      FNewPageIndex := -1;
      fTab:=false;
    end;
     
    procedure TGSPageControl.CMDialogKey(var Message: TCMDialogKey);
    begin
      fTab:=true;
      if (Focused or Windows.IsChild(Handle, Windows.GetFocus)) and
        (Message.CharCode = VK_TAB) and (GetKeyState(VK_CONTROL) < 0) then
        FNotifyIndex := FindNextPage(ActivePage, True, False).TabIndex;
      inherited;
    end;
     
    constructor TGSPageControl.Create(AOwner: TComponent);
    begin
      inherited;
      FNotifyIndex := 0;
      FNewPageIndex := 0;
      FTab:=false;
    end;
     
    function TGSPageControl.GetTabFromCursor: Integer;
    var
      HitTestInfo: TTCHitTestInfo;
      P: TPoint;
    begin
      GetCursorPos(P);
      HitTestInfo.pt := Self.ScreenToClient(P);
      HitTestInfo.flags := TCHT_ONITEM;
      Result := SendMessage(Self.Handle, TCM_HITTEST, 0, Integer(@HitTestInfo));
    end;
     
    procedure TGSPageControl.WMKeyDown(var Message: TWMKey);
    begin
      with Message do
        case Message.CharCode of
          37: FNotifyIndex := FindNextPage(ActivePage, False, False).TabIndex;
          39: FNotifyIndex := FindNextPage(ActivePage, True, False).TabIndex;
        end;
      inherited;
    end;
     
    end.

 \

Использование:

    procedure TForm1.GSPageControl1Changing(Sender: TObject;
      var AllowChange: Boolean);
    begin
     AllowChange:=GSPageControl1.Pages[GSPageControl1.NewPageIndex].Enabled
    end;

 \
 \

Автор: Rouse\_, Krid

Взято из <https://forum.sources.ru>
