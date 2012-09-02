<h1>Как работать с Powerpoint через OLE?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  comobj; 
 
procedure TForm1.Button2Click(Sender: TObject); 
var 
  PowerPointApp: OLEVariant; 
begin 
  try 
    PowerPointApp := CreateOleObject('PowerPoint.Application'); 
  except 
    ShowMessage('Error...'); 
    Exit; 
  end; 
  // Make Powerpoint visible 
  PowerPointApp.Visible := True; 
 
  // Show powerpoint version 
  ShowMessage(Format('Powerpoint version: %s',[PowerPointApp.Version])); 
 
  // Open a presentation 
  PowerPointApp.Presentations.Open('c:\MyPresentation.ppt', False, False, True); 
 
  // Show number of slides 
  ShowMessage(Format('%s slides.',[PowerPointApp.ActivePresentation.Slides.Count])); 
 
  // Run the presentation 
  PowerPointApp.ActivePresentation.SlideShowSettings.Run; 
 
  // Go to next slide 
  PowerPointApp.ActivePresentation.SlideShowWindow.View.Next; 
 
  // Go to slide 2 
  PowerPointApp.ActivePresentation.SlideShowWindow.View.GoToSlide(2); 
 
  // Go to previous slide 
  PowerPointApp.ActivePresentation.SlideShowWindow.View.Previous; 
 
  // Go to last slide 
  PowerPointApp.ActivePresentation.SlideShowWindow.View.Last; 
 
  // Show current slide name 
  ShowMessage(Format('Current slidename: %s',[PowerPointApp.ActivePresentation.SlideShowWindow.View.Slide.Name])); 
 
  // Close Powerpoint 
  PowerPointApp.Quit; 
  PowerPointApp := UnAssigned; 
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
