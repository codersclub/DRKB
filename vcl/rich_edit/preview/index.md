---
Title: Сделать предварительный просмотр для TRichEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Сделать предварительный просмотр для TRichEdit
==============================================

    unit RichEditPreview;
     
    interface
    
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, ExtCtrls, Printers, RichEdit, Menus, ComCtrls, ToolWin;
    
    type
      TPageOffset = record
        mStart, mEnd: Integer;
        rendRect: TRect;
      end;
    
      TPreviewForm = class(TForm)
        Panel1: TPanel;
        Panel2: TPanel;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure FormResize(Sender: TObject);
      private
        { Private-Deklarationen }
      public
        { Public-Deklarationen }
        PreviewPanel: TPanel;
        procedure DrawRichEdit;
      end;
    
      TPreviewPanel = class(TPanel)
      private
    
      public
        constructor Create(Owner: TComponent); override;
        destructor Destroy; override;
        procedure Paint; override;
        property Canvas;
      end;
    
    var
      PreviewForm: TPreviewForm;
    
    implementation
    
    uses Unit1, RxRichEd;
    
    {$R *.dfm}
    
    procedure TPreviewForm.FormCreate(Sender: TObject);
    begin
      PreviewPanel := TPreviewPanel.Create(Self);
      PreviewPanel.Parent := Self;
      PreviewPanel.Color := clWhite;
    end;
    
    procedure TPreviewForm.FormDestroy(Sender: TObject);
    begin
      if PreviewPanel <> nil then PreviewPanel.Free
    end;
    
    // We want the TPreviewPanel to approximate the scaled dimensions of the printed page. 
    // Whenever the parent 
    // form is resized, we need to rescale and center the panel on the form. 
    // To do this, add an OnResize event to 
    // the form and add the following code: 
     
    procedure TPreviewForm.FormResize(Sender: TObject);
    var
       wPage, hPage, wClient, hClient: integer;
    begin
      // get the printer dimensions 
      wPage := GetDeviceCaps(Printer.Handle, PHYSICALWIDTH);
      hPage := GetDeviceCaps(Printer.Handle, PHYSICALHEIGHT);
      // get the client window dimensions. 
      hClient := Panel2.ClientHeight;
      // initially adjust width to match height 
      wClient := MulDiv(Panel2.ClientHeight, wPage, hPage);
      // if that doesn't fit, then do it the other way 
      if wClient > Panel2.ClientWidth then
      begin
        wCLient := Panel2.ClientWidth;
        hClient := MulDiv(Panel2.ClientWidth, hPage, wPage);
        // center the page in the window 
        PreviewPanel.Top := ((Panel2.ClientHeight - hClient) div 2) - Panel1.Height;
      end
      else
      begin
        // center the page in the window 
        PreviewPanel.Left := (Panel2.ClientWidth - wClient) div 2;
        PreviewPanel.Top  := Panel1.Height;
      end;
      // now set size of panel 
      PreviewPanel.Width  := wClient;
      PreviewPanel.Height := hClient
    end;
     
    // The DrawRichEdit() method renders the contents of 
    // the control on the preview panel. 
    // Much of the code is 
    // very close to the code used to print the control in Part 2. 
    // The first part of the method is identical to 
    // the printing code: 
     
    procedure TPreviewForm.DrawRichEdit;
     var
       wPage, hPage, xPPI, yPPI, wTwips, hTwips, currPage: integer;
       pageRect, rendRect, frameRect: TRect;
       po: TPageOffset;
       fr: TFormatRange;
       lastOffset, xOffset, yOffset, xPrinterOffset, yPrinterOffset: integer;
       FPageOffsets: array of TPageOffset;
       TextLenEx: TGetTextLengthEx;
       hdcDesktop, hdcCanvas, hdcPrinter, xDesktopPPI, yDesktopPPI,
       xFactor, yFactor: integer;
     begin
       wPage := GetDeviceCaps(Printer.Handle, PHYSICALWIDTH);
       hPage := GetDeviceCaps(Printer.Handle, PHYSICALHEIGHT);
       xPPI := GetDeviceCaps(Printer.Handle, LOGPIXELSX);
       yPPI := GetDeviceCaps(Printer.Handle, LOGPIXELSY);
       wTwips := MulDiv(wPage, 1440, xPPI);
       hTwips := MulDiv(hPage, 1440, yPPI);
       with pageRect do
       begin
         Left := 0;
         Top := 0;
         Right := wTwips;
         Bottom := hTwips
       end;
       with rendRect do
       begin
         Left := 0;
         Top := 0;
         Right := pageRect.Right - (1440 * 4);
         Bottom := pageRect.Bottom - (1440 * 4)
       end;
       po.mStart := 0;
       // We will be using several device contexts (DCs), 
       // so let's go ahead and create variables for them. 
       hdcDesktop := GetWindowDC(GetDesktopWindow);
       hdcCanvas  := TPreviewPanel(PreviewPanel).Canvas.Handle;
       hdcPrinter := Printer.Handle;
       // Next, define and initialize a FORMATRANGE structure. 
       fr.hdc        := hdcDesktop;
       fr.hdcTarget  := hdcPrinter;
       fr.chrg.cpMin := po.mStart;
       fr.chrg.cpMax := -1;
       // We will need the size of the text in the control. 
       if RichEditVersion >= 2 then
       begin
         with TextLenEx do
         begin
           flags    := GTL_DEFAULT;
           codepage := CP_ACP;
         end;
         lastOffset := SendMessage(Form1.Editor.Handle, EM_GETTEXTLENGTHEX,
           wParam(@TextLenEx), 0)
       end
       else
         lastOffset := SendMessage(Form1.Editor.Handle, WM_GETTEXTLENGTH, 0, 0);
       // Clear the control's formatting buffer before rendering. 
       SendMessage(Form1.Editor.Handle, EM_FORMATRANGE, 0, 0);
       // Here is the tricky part. 
       // We need to scale the rendering DC to match the size of the printed page in 
       // printer device units. 
       SaveDC(hdcCanvas);
       SetMapMode(hdcCanvas, MM_TEXT);
       SetMapMode(hdcCanvas, MM_ANISOTROPIC);
       SetMapMode(hdcPrinter, MM_TEXT);
       SetWindowExtEx(hdcCanvas, pageRect.Right, pageRect.Bottom, nil);
       xDesktopPPI := GetDeviceCaps(hdcDesktop, LOGPIXELSX);
       yDesktopPPI := GetDeviceCaps(hdcDesktop, LOGPIXELSY);
       ScaleWindowExtEx(hdcCanvas, xDesktopPPI, 1440, yDesktopPPI, 1440, nil);
       SetViewportExtEx(hdcCanvas, PreviewPanel.ClientWidth, PreviewPanel.ClientHeight, nil);
       // Apparently, the Rich Edit control reduces the width of the 
       // rendering area by the amount of the left 
       // offset to the printable portion of the page when printing. 
       // This is a little odd to me because none of 
       // the Windows API GDI functions care whether you are printing 
       // within the printable portion of the page. 
       // Further, this occurs even though the rendering rectangle is 
       // already within the printable portion of the 
       // page.  Anyway, this does not seem to happen when the rendering 
       // DC is the screen so we need to manually 
       // adjust the rectangle ourselves. 
       xPrinterOffset  := MulDiv(GetDeviceCaps(hdcPrinter, PHYSICALOFFSETX), 1440, xPPI);
       yPrinterOffset  := MulDiv(GetDeviceCaps(hdcPrinter, PHYSICALOFFSETY), 1440, yPPI);
       rendRect.Left   := rendRect.Left + (xPrinterOffset shr 1);
       rendRect.Right  := rendRect.Right - xPrinterOffset - (xPrinterOFfset shr 1);
       rendRect.Top    := rendRect.Top + (yPrinterOffset shr 1);
       rendRect.Bottom := rendRect.Bottom - yPrinterOffset - (yPrinterOFfset shr 1);
       // Remember that we are hardcoding two-inch margins. 
       xOffset := MulDiv(PreviewPanel.ClientWidth shl 1, 1440, pageRect.Right);
       yOffset := MulDiv(PreviewPanel.ClientHeight shl 1, 1440, pageRect.Bottom);
       SetViewportOrgEx(hdcCanvas, xOffset, yOffset, nil);
       // Now we build the table of offsets. 
       // Note that we save the rendering rectangle returned by the format 
       // call.  When the rendering and target devices are the same 
       // (or the target device is set to zero), the 
       // returned rectangle is not really needed. 
       // In that case, you can simply ask the control to print to the 
       // original rendering rectangle.  However, when the devices are different, 
       // the returned rendering rectangle 
       // is sometimes larger than the requested rectangle. 
       // This must be a bug in the Rich Edit control.  We deal 
       // with it by saving the returned value to use when 
       // we actually render the control to the screen. 
       while ((fr.chrg.cpMin <> -1) and (fr.chrg.cpMin < lastOffset)) do
       begin
         fr.rc         := rendRect;
         fr.rcPage     := pageRect;
         po.mStart     := fr.chrg.cpMin;
         fr.chrg.cpMin := SendMessage(Form1.Editor.Handle, EM_FORMATRANGE, 0, Longint(@fr));
         po.mEnd       := fr.chrg.cpMin - 1;
         po.rendRect   := fr.rc;
         if High(FPageOffsets) = -1 then SetLength(FPageOffsets, 1)
         else
           SetLength(FPageOffsets, Length(FPageOffsets) + 1);
         FPageOffsets[High(FPageOffsets)] := po
       end;
       // If we were writing a fully working preview function, 
       // we could use FPageOffsets.size() to determine how 
       // many pages had been formatted. 
       // We would then set currPage (below) to the page that we wanted to 
       // display. 
       // In this example, however, we are going to display only the first page. 
       currPage := 0;
       // Now we set the rendering device to the panel's canvas. 
       // Since we have not cleared the formatting buffer, 
       // the target device is not needed, so we set it to zero. 
       // Then we fill in the remaining parts of the 
       // FORMATRANGE structure with the values we saved in FPageOffsets. 
       // Finally, we render the text to the 
       // screen (WPARAM is non-zero). 
       fr.hdc := hdcCanvas;
       fr.hdcTarget  := 0;
       fr.rc := FPageOffsets[currPage].rendRect;
       fr.rcPage := pageRect;
       fr.chrg.cpMin := FPageOffsets[currPage].mStart;
       fr.chrg.cpMax := FPageOffsets[currPage].mEnd;
       fr.chrg.cpMin := SendMessage(Form1.Editor.Handle, EM_FORMATRANGE, 1, Longint(@fr));
       // As I mentioned, the text may be drawn outside of the rendering rectangle. 
       // To make that easier to see, 
       // let's draw a rectangle that shows where the rendering rectangle should be 
       SetMapMode(hdcCanvas, MM_TEXT);
       SetViewportOrgEx(hdcCanvas, 0, 0, nil);
       frameRect := rendRect;
       OffsetRect(frameRect, 1440 + 1440, 1440 + 1440);
       xFactor          := MulDiv(PreviewPanel.ClientWidth,
         (pageRect.Right - rendRect.Right) shr 1, pageRect.Right);
       yFactor          := MulDiv(PreviewPanel.ClientHeight,
         (pageRect.Bottom - rendRect.Bottom) shr 1, pageRect.Bottom);
       frameRect.Left   := xFactor;
       frameRect.Right  := PreviewPanel.ClientWidth - xFactor;
       frameRect.Top    := yFactor;
       frameRect.Bottom := PreviewPanel.ClientHeight - yFactor;
       Windows.FrameRect(hdcCanvas, frameRect, GetStockObject(BLACK_BRUSH));
       // To wrap up, we restore the panel's canvas to the original state, 
       // release the desktop DC, clear the Rich 
       // Edit control's formatting buffer, empty the page offset table, 
       // and Close the DrawRichEdit() method.RestoreDC(hdcCanvas, - 1);
       ReleaseDC(GetDesktopWindow, hdcDesktop);
       SendMessage(Form1.Editor.Handle, EM_FORMATRANGE, 0, 0);
       Finalize(FPageOffsets);
     end;
     
     (*****************************************************)
     (* Alles uber den Nachfahren von TPanel              *)
     (*****************************************************)
     
     constructor TPreviewPanel.Create(Owner: TComponent);
     begin
       inherited Create(Owner);
     end;
     
     destructor TPreviewPanel.Destroy;
     begin
       inherited Destroy
     end;
     
     procedure TPreviewPanel.Paint;
     begin
       inherited Paint;
       PreviewForm.DrawRichEdit;
     end;
     
     end.

