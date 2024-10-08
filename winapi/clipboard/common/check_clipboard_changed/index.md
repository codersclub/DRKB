---
Title: Контроль за изменением содержимого буфера обмена
Date: 01.01.2007
---


Контроль за изменением содержимого буфера обмена
================================================

Вариант 1:

Author: Александр (Rouse\_) Багель

Source: <https://forum.sources.ru>

    unit Unit1;

     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
        hwndNextViewer: THandle;
        procedure WMChangeCbChain(var Message: TWMChangeCBChain); message WM_CHANGECBCHAIN;
        procedure WMDrawClipboard(var Message: TMessage); message WM_DRAWCLIPBOARD;
      end;

    var
      Form1: TForm1;

    implementation

    {$R *.dfm}

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      // Add the window to the clipboard viewer chain.
      hwndNextViewer := SetClipboardViewer(Handle);
      Memo1.Lines.Clear
    end;

    procedure TForm1.WMChangeCbChain(var Message: TWMChangeCBChain);
    begin
      with Message do
      begin

        // If the next window is closing, repair the chain.
        if Remove = hwndNextViewer then
          hwndNextViewer := Next

        // Otherwise, pass the message to the next link.
        else
          if hwndNextViewer <> 0 then
            SendMessage(hwndNextViewer, Msg, Remove, Next);
      end;
    end;

    // clipboard contents changed.
    procedure TForm1.WMDrawClipboard(var Message: TMessage);
    begin
      // Pass the message to the next window in clipboard
      // viewer chain.
      Memo1.Lines.Add('Сhanged');
      with Message do
       SendMessage(hwndNextViewer, Msg, WParam, LParam);
    end;

    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      ChangeClipboardChain(Handle, hwndNextViewer);
    end;

    end.

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    { 
      An application can be notified of changes in the data stored in the 
      Windows clipboard by registering itself as a Clipboard Viewer. 
     
      Clipboard viewers use two API calls and several messages to communicate 
      with the Clipboard viewer chain. SetClipboardViewer adds a window to the 
      beginning of the chain and returns a handle to the next viewer in the chain. 
      ChangeClipboardChain removes a window from the chain. When a clipboard change occurs, 
      the first window in the clipboard viewer chain is notified via the WM_DrawClipboard 
      message and must pass the message on to the next window. To do this, our application 
      must store the next window along in the chain to forward messages to and also respond 
      to the WM_ChangeCBChain message which is sent whenever any other clipboard viewer on 
      the system is added or removed to ensure the next window along is valid. 
    }
     
     
     unit Unit1;
     
     interface
     
     uses
       Windows, Messages, Forms, Classes, Controls, StdCtrls;
     
     type
       TForm1 = class(TForm)
         Button1: TButton;
         Button2: TButton;
         procedure Button1Click(Sender : TObject);
         procedure Button2Click(Sender : TObject);
         procedure FormCreate(Sender : TObject);
         procedure FormDestroy(Sender : TObject);
       private
         FNextClipboardViewer: HWND;
         procedure WMChangeCBChain(var Msg : TWMChangeCBChain); message WM_CHANGECBCHAIN;
         procedure WMDrawClipboard(var Msg : TWMDrawClipboard); message WM_DRAWCLIPBOARD;
       end;
     
     var
       Form1 : TForm1;
     
     implementation
     
     {$R *.DFM}
     
     procedure TForm1.FormCreate(Sender : TObject);
     begin
       { Initialize variable }
       FNextClipboardViewer := 0;
     end;
     
     
     procedure TForm1.Button1Click(Sender : TObject);
     begin
       if FNextClipboardViewer <> 0 then
         MessageBox(0, 'This window is already registered!', nil, 0)
       else
         { Add to clipboard chain }
         FNextClipboardViewer := SetClipboardViewer(Handle);
     end;
     
     
     procedure TForm1.Button2Click(Sender : TObject);
     begin
       { Remove from clipboard chain }
       ChangeClipboardChain(Handle, FNextClipboardViewer);
       FNextClipboardViewer := 0;
     end;
     
     
     procedure TForm1.WMChangeCBChain(var Msg : TWMChangeCBChain);
     begin
       inherited;
       { mark message as done }
       Msg.Result := 0;
       { the chain has changed }
       if Msg.Remove = FNextClipboardViewer then
         { The next window in the clipboard viewer chain had been removed. We recreate it. }
         FNextClipboardViewer := Msg.Next
       else
         { Inform the next window in the clipboard viewer chain }
         SendMessage(FNextClipboardViewer, WM_CHANGECBCHAIN, Msg.Remove, Msg.Next);
     end;
     
     
     procedure TForm1.WMDrawClipboard(var Msg : TWMDrawClipboard);
     begin
       inherited;
       { Clipboard content has changed }
       try
         MessageBox(0, 'Clipboard content has changed!', 'Clipboard Viewer', MB_ICONINFORMATION);
       finally
         { Inform the next window in the clipboard viewer chain }
         SendMessage(FNextClipboardViewer, WM_DRAWCLIPBOARD, 0, 0);
       end;
     end;
     
     
     procedure TForm1.FormDestroy(Sender : TObject);
     begin
       if FNextClipboardViewer <> 0 then
       begin
         { Remove from clipboard chain }
         ChangeClipboardChain(Handle, FNextClipboardViewer);
         FNextClipboardViewer := 0;
       end;
     end;
     
     end.

