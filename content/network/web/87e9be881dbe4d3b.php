<h1>How to turn off ISAPI DLL caching on Windows 2000 and IIS5</h1>
<div class="date">01.01.2007</div>


<p>You may want to turn off DLL caching to allow you to better debug ISAPI DLL's. Note that if you do turn it off, it is best to turn it back on when you are ready to use your DLL as it greatly improves performance.</p>
<p>Click on Start-&gt;Settings-&gt;Control Panel-&gt;Administrative Tools-&gt;Internet Services Manager. Right click on your website and select Properties:</p>
<p>[IIS Manager Screen Shot]</p>
<p>Select the "Home Directory" tab, and click on Configuration...:</p>
<p>[Configuration]</p>
<p>Uncheck "Cache ISAPI applications":</p>
<p>[uncheck cache extensions]</p>
