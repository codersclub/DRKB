<h1>Как отловить CLX форму?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  Capturing a CLX form is easy, once you know. 
  It took me a little time to find out, so I'm giving the knowledge to help others : 
} 
 
type 
  TFormCapturable = class(TForm) 
  public 
    procedure PrintOne; 
  end; 
 
var 
  FormCapturable: TFormCapturable; 
 
implementation 
 
uses 
  Qt; 
 
procedure TFormCapturable.PrintOne; 
var 
  aBitmap : TBitmap; 
  aWinHandle : QWidgetH; 
  aWinId : Cardinal; 
  x, y, w, h : integer; 
begin 
  // create a new bitmap to hold the captured screen 
  aBitMap := TBitmap.Create; 
  try 
    // get a handle on the desktop 
    aWinHandle := QApplication_desktop; 
    // get the Id from the desktop handle 
    aWinId := QWidget_winId( aWinHandle); 
    // get the position and size of the windows 
    x := Self.Left; 
    y := Self.Top; 
    w := Self.Width; 
    h := Self.Height; 
    // capture the window into the bitmap's pixmap 
    QPixmap_grabWindow( aBitmap.Handle, aWinId, x, y, w, h); 
    // save the bitmap 
    aBitMap.SaveToFile( 'c:\temp\test.bmp'); 
  finally 
    // don't forget to kill the bitmap after use. 
    FreeAndNil( aBitMap); 
  end; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
