<h1>How to close PowerPoint</h1>
<div class="date">01.01.2007</div>

<p>Early binding:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 24px 0px 24px;"><pre>PowerPoint.Quit; 
PowerPoint := nil; 
</pre>
&nbsp;</p>
<p>Late binding:</p>
<pre>
PowerPoint.Quit; 
PowerPoint := UnAssigned; 
</pre>

