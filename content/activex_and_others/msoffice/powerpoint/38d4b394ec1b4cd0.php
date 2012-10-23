<h1>How to start a new presentation</h1>
<div class="date">01.01.2007</div>

<p>PowerPoint.Presentations.Open('PresName.ppt', msoFalse, msoFalse, msoTrue);</p>
&nbsp;</p>
<p>The second parameter specifies whether the presentation should be opened in read-only mode. If the third parameter is True, an untitled copy of the file is made. The last parameter specifies whether the opened presentation should be visible. You can miss these parameters out in late binding if you're happy with the defaults (False, False, True, respectively, as in the code shown.)</p>
