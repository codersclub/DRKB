---
Title: Hook на буфер обмена
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Hook на буфер обмена
====================

    { 
      *Just create a new form and call it ClipFormats. 
      *Drop a TButton and call it btnUpdate. 
      *Drop a TListBox and call it lbFormats. 
     
      Then just add the code below and hook up all the event handlers. 
      All it does is display all the formats currently on the clipboard and 
      updates as soon as the clipboard changes. 
    }
     
    unit DynaClip;
    
    interface
    
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ExtCtrls;
    
    type
      TClipFormats = class(TForm)
        btnUpdate: TButton;
        lbFormats: TListBox;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure btnUpdateClick(Sender: TObject);
      private
        { Private declarations }
        NextWindow: HWND;
        procedure WMChangeCBChain(var Message: TWMChangeCBChain); message
        WM_CHANGECBCHAIN;
        procedure WMDrawClipboard(var Message: TWMDrawClipboard); message
        WM_DRAWCLIPBOARD;
      public
        { Public declarations }
      end;
    
    var
      ClipFormats: TClipFormats;
    
    implementation
    
    {$R *.DFM}
    
    procedure TMDIChildClipFormats.FormCreate(Sender: TObject);
    begin
      NextWindow := SetClipboardViewer(Handle);
    end;
    
    procedure TClipFormats.FormDestroy(Sender: TObject);
    begin
      ChangeClipboardChain(Handle, NextWindow);
    end;
    
    procedure TClipFormats.WMChangeCBChain(var Message: TWMChangeCBChain);
    begin
      with Message do
      begin
        if (Remove = NextWindow) then
        begin
          NextWindow := Next;
        end
        else
        begin
          SendMessage(NextWindow, WM_CHANGECBCHAIN, Remove, Next);
        end;
      end;
    end;
     
    procedure TClipFormats.WMDrawClipboard(var Message: TWMDrawClipboard);
    begin
      btnUpdate.Click;
      SendMessage(NextWindow, WM_DRAWCLIPBOARD, 0, 0);
    end;
    
    procedure TClipFormats.btnUpdateClick(Sender: TObject);
    const
      PreDefinedFormats: array[1..16] of string = (
        'CF_TEXT',
        'CF_BITMAP',
        'CF_METAFILEPICT',
        'CF_SYLK',
        'CF_DIF',
        'CF_TIFF',
        'CF_OEMTEXT',
        'CF_DIB',
        'CF_PALETTE',
        'CF_PENDATA',
        'CF_RIFF',
        'CF_WAVE',
        'CF_UNICODETEXT',
        'CF_ENHMETAFILE',
        'CF_HDROP',
        'CF_LOCALE');
    var
      ClipFormat: TClipFormat;
      szBuffer: array[0..511] of Char;
      FormatID: string;
    begin
      if not OpenClipboard(Handle) then Exit;
      try
        lbFormats.Items.BeginUpdate;
        try
          lbFormats.Items.Clear;
    
          ClipFormat := EnumClipboardFormats(0);
          while (ClipFormat <> 0) do
          begin
            if (ClipFormat in [1..16]) then
            begin
              FormatID := PreDefinedFormats[ClipFormat];
            end
            else
            begin
              GetClipboardFormatName(ClipFormat, szBuffer, SizeOf(szBuffer));
              FormatID := string(szBuffer);
            end;
            lbFormats.Items.Add(Format('%s [%d]', [FormatID, ClipFormat]));
            ClipFormat := EnumClipboardFormats(ClipFormat);
          end;
        finally
          lbFormats.Items.EndUpdate;
        end;
      finally
        CloseClipboard;
      end;
    end;
     
    end.

