---
Title: Как сделать предпросмотр?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---

Как сделать предпросмотр?
=========================

    unit printpreview;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls, ComCtrls;
     
    type
      TForm1 = class(TForm)
        Panel1: TPanel;
        Panel2: TPanel;
        PreviewPaintbox: TPaintBox;
        Label1: TLabel;
        Label2: TLabel;
        LeftMarginEdit: TEdit;
        TopMarginEdit: TEdit;
        Label3: TLabel;
        Label4: TLabel;
        RightMarginEdit: TEdit;
        Label5: TLabel;
        BottomMarginEdit: TEdit;
        ApplyMarginsButton: TButton;
        OrientationRGroup: TRadioGroup;
        Label6: TLabel;
        ZoomEdit: TEdit;
        ZoomUpDown: TUpDown;
        procedure LeftMarginEditKeyPress(Sender: TObject; var Key: Char);
        procedure FormCreate(Sender: TObject);
        procedure PreviewPaintboxPaint(Sender: TObject);
        procedure ApplyMarginsButtonClick(Sender: TObject);
      private
        { Private declarations }
        PreviewText: string;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    uses printers;
     
    {$R *.DFM}
     
    procedure TForm1.LeftMarginEditKeyPress(Sender: TObject; var Key: Char);
    begin
      if not (Key in ['0'..'9', #9, DecimalSeparator]) then
        Key := #0;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      S: string;
     
      procedure loadpreviewtext;
      var
        sl: TStringList;
      begin
        sl := TStringList.Create;
        try
          sl.Loadfromfile(Extractfilepath(application.exename) + 'printpreview.pas');
          PreviewText := sl.Text;
        finally
          sl.free
        end;
      end;
     
    begin
      {Initialize the margin edits with a margin of 0.75 inch}
      S := FormatFloat('0.00', 0.75);
      LeftMarginEdit.Text := S;
      TopMarginEdit.Text := S;
      RightMarginEdit.Text := S;
      BottomMarginEdit.Text := S;
      {Initialize the orientation radio group}
      if Printer.Orientation = poPortrait then
        OrientationRGroup.ItemIndex := 0
      else
        OrientationRGroup.ItemIndex := 1;
      {load test text for display}
      LoadPreviewtext;
    end;
     
    procedure TForm1.PreviewPaintboxPaint(Sender: TObject);
    var
      pagewidth, pageheight: Double; {printer page dimension in inch}
      printerResX, printerResY: Integer; {printer resolution in dots/inch}
      minmarginX, minmarginY: Double; {nonprintable margin in inch}
      outputarea: TRect; {print area in 1/1000 inches}
      scale: Double; {conversion factor, pixels per 1/1000 inch}
     
      procedure InitPrintSettings;
        function GetMargin(S: string; inX: Boolean): Double;
        begin
          Result := StrToFloat(S);
          if InX then
          begin
            if Result < minmarginX then
              Result := minmarginX;
          end
          else
          begin
            if Result < minmarginY then
              Result := minmarginY;
          end;
        end;
      begin
        printerResX := GetDeviceCaps(printer.handle, LOGPIXELSX);
        printerResY := GetDeviceCaps(printer.handle, LOGPIXELSY);
        pagewidth := GetDeviceCaps(printer.handle, PHYSICALWIDTH) / printerResX;
        pageheight := GetDeviceCaps(printer.handle, PHYSICALHEIGHT) / printerResY;
        minmarginX := GetDeviceCaps(printer.handle, PHYSICALOFFSETX) / printerResX;
        minmarginY := GetDeviceCaps(printer.handle, PHYSICALOFFSETY) / printerResY;
        outputarea.Left := Round(GetMargin(LeftMarginEdit.Text, true) * 1000);
        outputarea.Top := Round(GetMargin(TopMarginEdit.Text, false) * 1000);
        outputarea.Right := Round((pagewidth - GetMargin(RightMarginEdit.Text, true)) *
          1000);
        outputarea.Bottom := Round((pageheight - GetMargin(BottomMarginEdit.Text, false))
          * 1000);
      end;
     
      procedure ScaleCanvas(Canvas: TCanvas; widthavail, heightavail: Integer);
      var
        needpixelswidth, needpixelsheight: Integer;
        {dimensions of preview at current zoom factor in pixels}
        orgpixels: TPoint;
        {origin of preview in pixels}
      begin
        {set up a coordinate system for the canvas that uses 1/1000 inch as unit,
        honors the zoom factor and maintains the MM_TEXT orientation of the
        coordinate axis (origin in top left corner, positive Y axis points down}
        scale := Screen.PixelsPerInch / 1000;
        {Apply zoom factor}
        scale := scale * StrToInt(Zoomedit.text) / 100;
        {figure out size of preview}
        needpixelswidth := Round(pagewidth * 1000 * scale);
        needpixelsheight := Round(pageheight * 1000 * scale);
        if needpixelswidth >= widthavail then
          orgpixels.X := 0
        else
          orgpixels.X := (widthavail - needpixelswidth) div 2;
        if needpixelsheight >= heightavail then
          orgpixels.Y := 0
        else
          orgpixels.Y := (heightavail - needpixelsheight) div 2;
        {change mapping mode to MM_ISOTROPIC}
        SetMapMode(canvas.handle, MM_ISOTROPIC);
        {move viewport origin to orgpixels}
        SetViewportOrgEx(canvas.handle, orgpixels.x, orgpixels.y, nil);
        {scale the window}
        SetViewportExtEx(canvas.handle, Round(1000 * scale), Round(1000 * scale), nil);
        SetWindowExtEx(canvas.handle, 1000, 1000, nil);
      end;
     
    begin
      if OrientationRGroup.ItemIndex = 0 then
        Printer.Orientation := poPortrait
      else
        Printer.Orientation := poLandscape;
      InitPrintsettings;
      with Sender as TPaintBox do
      begin
        ScaleCanvas(Canvas, ClientWidth, ClientHeight);
        {specify font height in 1/1000 inch}
        Canvas.Font.Height := Round(font.height / font.pixelsperinch * 1000);
        {paint page white}
        Canvas.Brush.Color := clWindow;
        Canvas.Brush.Style := bsSolid;
        Canvas.FillRect(Rect(0, 0, Round(pagewidth * 1000), Round(pageheight * 1000)));
        {draw the text}
        DrawText(canvas.handle, PChar(PreviewText), Length(PreviewText),
          outputarea, DT_WORDBREAK or DT_LEFT);
        {Draw thin gray lines to mark borders}
        Canvas.Pen.Color := clGray;
        Canvas.Pen.Style := psSolid;
        Canvas.Pen.Width := 10;
        with Canvas do
        begin
          MoveTo(outputarea.left - 100, outputarea.top);
          LineTo(outputarea.right + 100, outputarea.top);
          MoveTo(outputarea.left - 100, outputarea.bottom);
          LineTo(outputarea.right + 100, outputarea.bottom);
          MoveTo(outputarea.left, outputarea.top - 100);
          LineTo(outputarea.left, outputarea.bottom + 100);
          MoveTo(outputarea.right, outputarea.top - 100);
          LineTo(outputarea.right, outputarea.bottom + 100);
        end;
      end;
    end;
     
    procedure TForm1.ApplyMarginsButtonClick(Sender: TObject);
    begin
      PreviewPaintbox.Invalidate;
    end;
     
    end.

    object Form1: TForm1
      Left = 192
      Top = 128
      Width = 696
      Height = 480
      Caption = 'Form1'
      Color = clBtnFace
      Font.Charset = ANSI_CHARSET
      Font.Color = clWindowText
      Font.Height = -15
      Font.Name = 'Arial'
      Font.Style = []
      OldCreateOrder = False
      OnCreate = FormCreate
      PixelsPerInch = 120
      TextHeight = 17
      object Panel1: TPanel
        Left = 503
        Top = 0
        Width = 185
        Height = 453
        Align = alRight
        TabOrder = 0
        object Label1: TLabel
          Left = 8
          Top = 8
          Width = 92
          Height = 17
          Caption = 'Margins (inch)'
        end
        object Label2: TLabel
          Left = 8
          Top = 45
          Width = 24
          Height = 17
          Caption = 'Left'
        end
        object Label3: TLabel
          Left = 8
          Top = 77
          Width = 25
          Height = 17
          Caption = 'Top'
        end
        object Label4: TLabel
          Left = 8
          Top = 109
          Width = 34
          Height = 17
          Caption = 'Right'
        end
        object Label5: TLabel
          Left = 8
          Top = 141
          Width = 47
          Height = 17
          Caption = 'Bottom'
        end
        object Label6: TLabel
          Left = 8
          Top = 261
          Width = 64
          Height = 17
          Caption = 'Zoom (%)'
        end
        object LeftMarginEdit: TEdit
          Left = 60
          Top = 40
          Width = 100
          Height = 25
          TabOrder = 0
          OnKeyPress = LeftMarginEditKeyPress
        end
        object TopMarginEdit: TEdit
          Left = 60
          Top = 72
          Width = 100
          Height = 25
          TabOrder = 1
          OnKeyPress = LeftMarginEditKeyPress
        end
        object RightMarginEdit: TEdit
          Left = 60
          Top = 104
          Width = 100
          Height = 25
          TabOrder = 2
          OnKeyPress = LeftMarginEditKeyPress
        end
        object BottomMarginEdit: TEdit
          Left = 60
          Top = 136
          Width = 100
          Height = 25
          TabOrder = 3
          OnKeyPress = LeftMarginEditKeyPress
        end
        object ApplyMarginsButton: TButton
          Left = 24
          Top = 304
          Width = 137
          Height = 25
          Caption = 'Apply'
          TabOrder = 4
          OnClick = ApplyMarginsButtonClick
        end
        object OrientationRGroup: TRadioGroup
          Left = 8
          Top = 176
          Width = 161
          Height = 65
          Caption = 'Orientation'
          Items.Strings = (
            'Portrait'
            'Landscape')
          TabOrder = 5
        end
        object ZoomEdit: TEdit
          Left = 80
          Top = 256
          Width = 40
          Height = 25
          TabOrder = 6
          Text = '50'
        end
        object ZoomUpDown: TUpDown
          Left = 120
          Top = 256
          Width = 17
          Height = 25
          Associate = ZoomEdit
          Min = 0
          Increment = 10
          Position = 50
          TabOrder = 7
          Wrap = False
        end
      end
      object Panel2: TPanel
        Left = 0
        Top = 0
        Width = 503
        Height = 453
        Align = alClient
        Font.Charset = ANSI_CHARSET
        Font.Color = clWindowText
        Font.Height = -17
        Font.Name = 'Times New Roman'
        Font.Style = []
        ParentFont = False
        TabOrder = 1
        object PreviewPaintbox: TPaintBox
          Left = 1
          Top = 1
          Width = 501
          Height = 451
          Align = alClient
          OnPaint = PreviewPaintboxPaint
        end
      end
    end

