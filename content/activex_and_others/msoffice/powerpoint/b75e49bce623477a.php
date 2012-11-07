<h1>How to close PowerPoint</h1>
<div class="date">01.01.2007</div>

<p>Early binding:</p>
<pre class="delphi">PowerPoint.Quit; 
PowerPoint := nil; 
</pre>

</p>

<p>Late binding:</p>

<pre class="delphi">
PowerPoint.Quit; 
PowerPoint := UnAssigned; 
</pre>

