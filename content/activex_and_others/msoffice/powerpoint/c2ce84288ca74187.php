<h1>How to save a presentation</h1>
<div class="date">01.01.2007</div>

<p>PowerPoint.Save; </p>
<p>Or for SaveAs:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 24px 0px 24px;"><pre>var
  EmbedFonts: OleVariant;
begin
  EmbedFonts := False;
  PowerPoint.ActivePresentation.SaveAs('PresName.ppt', ppSaveAsPresentation, EmbedFonts);
</pre>
&nbsp;<br>
<p>The second parameter for SaveAs determines the save format - possible values are ppSaveAsAddIn, ppSaveAsPowerPoint3, ppSaveAsPowerPoint4, ppSaveAsPowerPoint7, ppSaveAsPresentation, ppSaveAsRTF, or ppSaveAsTemplate. These are constants defined in the type library. If you aren't using the type library, you can define them yourself like this:</p>
<pre>
const
  ppSaveAsPresentation = $00000001;
  ppSaveAsPowerPoint7 = $00000002;
  ppSaveAsPowerPoint4 = $00000003;
  ppSaveAsPowerPoint3 = $00000004;
  ppSaveAsTemplate = $00000005;
  ppSaveAsRTF = $00000006;
  ppSaveAsShow = $00000007;
  ppSaveAsAddIn = $00000008;
  ppSaveAsWizard = $00000009;
  ppSaveAsPowerPoint4FarEast = $0000000A;
  ppSaveAsDefault = $0000000B;
</pre>

