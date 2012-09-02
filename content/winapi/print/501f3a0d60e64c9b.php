<h1>Print Preview</h1>
<div class="date">01.01.2007</div>


<pre>
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
    PreviewText: String;
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
  If not (Key in ['0'..'9',#9,DecimalSeparator]) Then
    Key := #0;
end;
procedure TForm1.FormCreate(Sender: TObject);
var
  S: String;
  procedure loadpreviewtext;
  var
    sl: TStringlist;
  begin
    sl:= Tstringlist.Create;
    try
      sl.Loadfromfile( Extractfilepath( application.exename )+'printpreview.pas');
      PreviewText := sl.Text;
    finally
      sl.free
    end;
  end;
begin
  // Initialize the margin edits with a margin of 0.75 inch
  S:= FormatFloat('0.00',0.75);
  LeftMarginEdit.Text := S;
  TopMarginEdit.Text := S;
  RightMarginEdit.Text := S;
  BottomMarginEdit.Text := S;
  // Initialize the orientation radio group
  If Printer.Orientation = poPortrait Then
    OrientationRGroup.ItemIndex := 0
  Else
    OrientationRGroup.ItemIndex := 1;
  // load test text for display
  LoadPreviewtext;
end;
procedure TForm1.PreviewPaintboxPaint(Sender: TObject);
var
  pagewidth, pageheight: Double;     // printer page dimension in inch
  printerResX, printerResY: Integer; // printer resolution in dots/inch
  minmarginX, minmarginY: Double;    // nonprintable margin in inch
  outputarea: TRect;                 // print area in 1/1000 inches
  scale: Double; // conversion factor, pixels per 1/1000 inch
  procedure InitPrintSettings;
    function GetMargin( S: String; inX: Boolean ):Double;
    begin
      Result := StrToFloat(S);
      if InX then begin
        if Result &lt; minmarginX then
          Result := minmarginX;
      end
      else begin
        if Result &lt; minmarginY then
          Result := minmarginY;
      end;
    end;
  begin
    printerResX := GetDeviceCaps( printer.handle, LOGPIXELSX );
    printerResY := GetDeviceCaps( printer.handle, LOGPIXELSY );
    pagewidth   := GetDeviceCaps( printer.handle, PHYSICALWIDTH ) / printerResX;
    pageheight  := GetDeviceCaps( printer.handle, PHYSICALHEIGHT) / printerResY;
    minmarginX  := GetDeviceCaps( printer.handle, PHYSICALOFFSETX)/ printerResX;
    minmarginY  := GetDeviceCaps( printer.handle, PHYSICALOFFSETY)/ printerResY;
    outputarea.Left := Round( GetMargin( LeftMarginEdit.Text, true ) * 1000);
    outputarea.Top  := Round( GetMargin( TopMarginEdit.Text, false ) * 1000);
    outputarea.Right := Round(( pagewidth -
                                GetMargin( RightMarginEdit.Text, true )) * 1000);
    outputarea.Bottom := Round(( pageheight -
                                 GetMargin( BottomMarginEdit.Text, false ))
                               * 1000);
  end; { InitPrintSettings }
</pre>

