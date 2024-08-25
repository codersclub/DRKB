---
Title: Предотвратить работу с командами буфера обмена в TEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Предотвратить работу с командами буфера обмена в TEdit
======================================================

    unit MyEdit;
     
     interface
     
     uses
       Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
       Dialogs, stdctrls, clipbrd;
     
     type
       TPreventNotifyEvent = procedure(Sender: TObject; Text: string; var Accept: Boolean) of object;
     
     type
       TMyEdit = class(TCustomEdit)
       private
         FPreventCut: Boolean;
         FPreventCopy: Boolean;
         FPreventPaste: Boolean;
         FPreventClear: Boolean;
     
         FOnCut: TPreventNotifyEvent;
         FOnCopy: TPreventNotifyEvent;
         FOnPaste: TPreventNotifyEvent;
         FOnClear: TPreventNotifyEvent;
     
         procedure WMCut(var Message: TMessage); message WM_CUT;
         procedure WMCopy(var Message: TMessage); message WM_COPY;
         procedure WMPaste(var Message: TMessage); message WM_PASTE;
         procedure WMClear(var Message: TMessage); message WM_CLEAR;
       protected
         { Protected declarations }
       public
         { Public declarations }
       published
         property PreventCut: Boolean read FPreventCut write FPreventCut default False;
         property PreventCopy: Boolean read FPreventCopy write FPreventCopy default False;
         property PreventPaste: Boolean read FPreventPaste write FPreventPaste default False;
         property PreventClear: Boolean read FPreventClear write FPreventClear default False;
         property OnCut: TPreventNotifyEvent read FOnCut write FOnCut;
         property OnCopy: TPreventNotifyEvent read FOnCopy write FOnCopy;
         property OnPaste: TPreventNotifyEvent read FOnPaste write FOnPaste;
         property OnClear: TPreventNotifyEvent read FOnClear write FOnClear;
       end;
     
     procedure Register;
     
     implementation
     
     procedure TMyEdit.WMCut(var Message: TMessage);
     var
       Accept: Boolean;
       Handle: THandle;
       HandlePtr: Pointer;
       CText: string;
     begin
       if FPreventCut then
         Exit;
       if SelLength = 0 then
         Exit;
       CText := Copy(Text, SelStart + 1, SelLength);
       try
         OpenClipBoard(Self.Handle);
         Accept := True;
         if Assigned(FOnCut) then
           FOnCut(Self, CText, Accept);
         if not Accept then
           Exit;
         Handle := GlobalAlloc(GMEM_MOVEABLE + GMEM_DDESHARE, Length(CText) + 1);
         if Handle = 0 then
           Exit;
         HandlePtr := GlobalLock(Handle);
         Move((PChar(CText))^, HandlePtr^, Length(CText));
         SetClipboardData(CF_TEXT, Handle);
         GlobalUnlock(Handle);
         CText := Text;
         Delete(CText, SelStart + 1, SelLength);
         Text := CText;
       finally
         CloseClipBoard;
       end;
     end;
     
     
     procedure TMyEdit.WMCopy(var Message: TMessage);
     var
       Accept: Boolean;
       Handle: THandle;
       HandlePtr: Pointer;
       CText: string;
     begin
       if FPreventCopy then
         Exit;
       if SelLength = 0 then
         Exit;
       CText := Copy(Text, SelStart + 1, SelLength);
       try
         OpenClipBoard(Self.Handle);
         Accept := True;
         if Assigned(FOnCopy) then
           FOnCopy(Self, CText, Accept);
         if not Accept then
           Exit;
         Handle := GlobalAlloc(GMEM_MOVEABLE + GMEM_DDESHARE, Length(CText) + 1);
         if Handle = 0 then
           Exit;
         HandlePtr := GlobalLock(Handle);
         Move((PChar(CText))^, HandlePtr^, Length(CText));
         SetClipboardData(CF_TEXT, Handle);
         GlobalUnlock(Handle);
       finally
         CloseClipBoard;
       end;
     end;
     
     
     procedure TMyEdit.WMPaste(var Message: TMessage);
     var
       Accept: Boolean;
       Handle: THandle;
       CText: string;
       LText: string;
       AText: string;
     begin
       if FPreventPaste then
         Exit;
       if IsClipboardFormatAvailable(CF_TEXT) then
       begin
         try
           OpenClipBoard(Self.Handle);
           Handle := GetClipboardData(CF_TEXT);
           if Handle = 0 then
             Exit;
           CText := StrPas(GlobalLock(Handle));
           GlobalUnlock(Handle);
           Accept := True;
           if Assigned(FOnPaste) then
             FOnPaste(Self, CText, Accept);
           if not Accept then
             Exit;
           LText := '';
           if SelStart > 0 then
             LText := Copy(Text, 1, SelStart);
           LText := LText + CText;
           AText := '';
           if (SelStart + 1) < Length(Text) then
             AText := Copy(Text, SelStart + SelLength + 1, Length(Text) - SelStart + SelLength + 1);
           Text := LText + AText;
         finally
           CloseClipBoard;
         end;
       end;
     end;
     
     
     procedure TMyEdit.WMClear(var Message: TMessage);
     var
       Accept: Boolean;
       CText: string;
     begin
       if FPreventClear then
         Exit;
       if SelStart = 0 then
         Exit;
       CText  := Copy(Text, SelStart + 1, SelLength);
       Accept := True;
       if Assigned(FOnClear) then
         FOnClear(Self, CText, Accept);
       if not Accept then
         Exit;
       CText := Text;
       Delete(CText, SelStart + 1, SelLength);
       Text := CText;
     end;
     
     
     procedure Register;
     begin
       RegisterComponents('Samples', [TMyEdit]);
     end;
     
     end.

